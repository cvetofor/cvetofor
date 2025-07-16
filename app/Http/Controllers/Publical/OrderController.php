<?php

namespace App\Http\Controllers\Publical;

use App\Events\OrderCreated;
use App\Http\Controllers\Api\SMSController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Delivery;
use App\Models\LegalAccount;
use App\Models\Market;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Payment;
use App\Models\PaymentStatus;
use App\Models\ProductPrice;
use App\Models\User;
use App\Services\CitiesService;
use App\Services\Defenders\ProductPriceDefender;
use App\Services\PriceService;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OrderController extends Controller {
    public function index(ProductPriceDefender $productPriceDefender) {

        $cart = $productPriceDefender->checkRottenProducts(\Cart::getContent(), $canGoToNext);

        if (\Cart::isEmpty() || ! $canGoToNext) {
            return redirect()->route('cart.index');
        }

        SEOTools::setTitle('Оформление заказа');
        SEOTools::metatags()->setRobots('noindex, nofollow');

        $cart = \Cart::getContent();
        $cartByMarket = $cart->sortBy('attributes.order')->groupBy('attributes.market_id');
        $totalDeliveryPrice = 0.0;
        $postcard_price = 0.0;

        $markets = [];
        foreach ($cartByMarket as $market) {
            $markets[] = Market::find($market->first()->associatedModel->market->id);

            $totalDeliveryPrice += end($markets)?->delivery_price ?? 0;
            $postcard_price += end($markets)?->postcard_price ?? 0;
        }

        $payments = Payment::published()->orderBy('position')->get();

        $deliveryTimes = Market::getDeliveryTime($markets);

        return view(
            'order',
            compact(
                'cart',
                'cartByMarket',

                'deliveryTimes',

                'totalDeliveryPrice',
                'payments',
                'postcard_price',
            )
        );
    }

    public function pay(Order $order) {
        if ($order->payment_link) {
            return redirect()->to($order->payment_link);
        }

        if ($order->paymentStatus?->code === \App\Models\PaymentStatus::AWAIT) {
            $paymentResolver = new \App\Gateway\PaymentGateway;
            $redirect = $paymentResolver->resolve($order);

            return redirect()->to($redirect);
        }

        return back();
    }

    public function paymentShortLink(int $order_num) {

        if (! $order_num) {
            abort(404);
        }

        $order = Order::where('num_order', $order_num)->where('parent_id', null)->first();

        if (! $order) {
            abort(404);
        }

        $relatedOrders = Order::where('parent_id', $order->id)->get();
        $paidOrders = $relatedOrders->where('payment_status_id', 2);

        if ($paidOrders->isNotEmpty()) {
            return redirect()->to('https://xn--b1ag1aakjpl.xn--p1ai/order/' . $order->uuid);
        }

        $payment_link = \Cache::remember(
            `order_payment_short_link_` . $order_num,
            600,
            function () use ($order) {

                $paymentResolver = new \App\Gateway\PaymentGateway;

                return $paymentResolver->resolve($order);
            }
        );

        return redirect()->to($payment_link);
    }

    public function show(Order $order) {
        SEOTools::setTitle('Заказ №' . $order->id);
        SEOTools::metatags()->setRobots('noindex, nofollow');

        return view('order.show', compact('order'));
    }

    private function addToCartPostcardItem($price, $market_id) {
        if (\Cart::has(md5('Открытка_' . $market_id))) {
            \Cart::update(md5('Открытка_' . $market_id), [
                'quantity' => [
                    'relative' => false,
                    'value' => 1,
                ],
            ]);
        } else {
            \Cart::add([
                'id' => md5('Открытка_' . $market_id),
                'name' => 'Открытка',
                'price' => $price,
                'quantity' => 1,
                'attributes' => [
                    'market_id' => $market_id,
                    'order' => 9999999,
                    // Сортировка
                ],
                'conditions' => null,
            ]);
        }
    }

    public function create(OrderRequest $orderRequest, ProductPriceDefender $productPriceDefender, PriceService $priceService) {
        // Проверить текущий город с городами магазина  /  смысл есть, адреса может не быть.
        // Проверить радиусы доставки +
        // Проверить даты доставки +
        // Время доставки +

        $cart = $productPriceDefender->checkRottenProducts(\Cart::getContent(), $canGoToNext);
        $meta['meta']['basePrice'] = 0;
        $meta['meta']['comissions'] = [];

        if (\Cart::isEmpty() || ! $canGoToNext) {
            return redirect()->route('cart.index');
        }

        // Добавить открытку в корзину, перед формированием заказа

        if ($orderRequest['postcard']) {
            $cart = \Cart::getContent();
            $cartByMarket = $cart->sortBy('attributes.order')->groupBy('attributes.market_id');

            foreach ($cartByMarket as $_market) {
                $market = Market::find($_market->first()->associatedModel->market->id);

                $price = optional($market)->postcard_price ?? 0;
                $this->addToCartPostcardItem($price, $market->id);
            }

            unset($cart);
            unset($cartByMarket);
        }

        $cart = \Cart::getContent();

        $minStartDate = null;
        $maxEndDate = null;
        $deliveryDate = \Carbon\Carbon::parse($orderRequest->input('delivery_date'));
        foreach ($cart as $item) {
            $product = $item->associatedModel?->groupProduct;
            if ($product) {
                $category = $product->groupProductCategory;
                if ($category && $category->is_category_limited) {
                    $categoryStartDate = \Carbon\Carbon::parse($category->limit_start_date);
                    $categoryEndDate = \Carbon\Carbon::parse($category->limit_end_date);

                    if (! $minStartDate || $categoryStartDate->gt($minStartDate)) {
                        $minStartDate = $categoryStartDate;
                    }
                    if (! $maxEndDate || $categoryEndDate->lt($maxEndDate)) {
                        $maxEndDate = $categoryEndDate;
                    }
                }

                foreach ($product->tags as $tag) {
                    if ($tag->is_category_limited) {
                        $tagStartDate = \Carbon\Carbon::parse($tag->limit_start_date);
                        $tagEndDate = \Carbon\Carbon::parse($tag->limit_end_date);

                        if (! $minStartDate || $tagStartDate->gt($minStartDate)) {
                            $minStartDate = $tagStartDate;
                        }
                        if (! $maxEndDate || $tagEndDate->lt($maxEndDate)) {
                            $maxEndDate = $tagEndDate;
                        }
                    }
                }
            }
        }
        if (
            ($minStartDate && $deliveryDate->lt($minStartDate)) ||
            ($maxEndDate && $deliveryDate->gt($maxEndDate))
        ) {
            return response()->json([
                'message' => 'Выбранная дата выходит за диапазон доступной доставки одного из букетов в вашей корзине. Пожалуйста, выберите другую дату',
            ], 400);
        }

        $cartByMarket = $cart->sortBy('attributes.order')->groupBy('attributes.market_id');
        $markets = [];

        $totalDeliveryPrice = 0.0;
        foreach ($cartByMarket as $_market) {
            $market = Market::find($_market->first()->associatedModel->market->id);
            $markets[] = $market;
            $totalDeliveryPrice += $market->delivery_price ?? 0;
        }

        if ($orderRequest->checkRadius($markets)) {
            return response()->json($orderRequest->checkRadius($markets), 400);
        } elseif (! $orderRequest->has('coordinates')) {
            foreach ($markets as $market) {
                if ($market->city->id !== CitiesService::getCity()->id) {
                    return response()->json([
                        'modal' => 'delivery-area',
                        'message' => 'Ваш город "' . CitiesService::getCity()->city . "\" не совпадает с городом магазина \"{$market->name}\" - \"{$market->city->city}\"",
                    ], 400);
                }
            }
        }

        if (
            $orderRequest->checkTimes($markets)
        ) {
            return response()->json([
                'message' => 'Некорректная дата или время доставки, выберите пожалуйта другое время либо дату доставки',
            ], 400);
        }

        /**
         * type Order
         */
        $lastOrder = DB::table('orders')->latest()->first();

        $order = DB::transaction(function () use ($orderRequest, $cartByMarket, $cart, $totalDeliveryPrice, $priceService, $lastOrder) {

            $user = auth()->check() ? auth()->user() : $this->findOrCreateUser($orderRequest);
            $orderRequest['delivery_date'] = (new \DateTime($orderRequest['delivery_date']))->format('Y-m-d H:i:s');
            // --- UDS: если были списаны баллы, используем новую сумму и записываем баллы ---
            if (session('uds_points_used') && session('uds_points_amount') && session('uds_new_total')) {
                $orderRequest['total_price'] = session('uds_new_total');
                $orderRequest['uds_points'] = session('uds_points_amount');
                $orderRequest['uds_code'] = session('uds_code');
            } else {
                if (session('uds_code')) {
                    $orderRequest['uds_code'] = session('uds_code');
                }

                $orderRequest['total_price'] = \Cart::getTotal() + $totalDeliveryPrice;
            }
            $meta['meta']['basePrice'] = 0;

            $orderRequest['user_id'] = $user->id;
            $orderRequest['city_id'] = CitiesService::getCity()->id;
            $orderRequest['num_order'] = $lastOrder->num_order + 1;

            $arrCart = $cart->toArray();
            foreach ($arrCart as $i => $cartItem) {

                if (isset($cartItem['associatedModel']['id'])) {
                    $priceObject = ProductPrice::where('id', $cartItem['associatedModel']['id'] ?? false)->first();
                    $calcReponse = $priceService->calc($priceObject, $cartItem['attributes']['composition'] ?? [], 'price');
                    $meta['meta']['basePrice'] += $calcReponse->totalWithContitions * $cartItem['quantity'];
                } else {
                    $meta['meta']['basePrice'] += $cartItem['price'] * $cartItem['quantity'];
                }

                // У Открытки нет ассоциации с моделью
                try {
                    $modelId = $arrCart[$i]['associatedModel']['id'];
                    unset($arrCart[$i]['associatedModel']);
                    $arrCart[$i]['associatedModel'] = [];
                    $arrCart[$i]['associatedModel']['id'] = $modelId;
                } catch (\Throwable $th) {
                    // throw $th;
                }
            }
            $orderRequest['cart'] = $arrCart;

            $orderRequest['name'] = $orderRequest['fio'];
            $orderRequest['uuid'] = (string) \Str::uuid();

            $orderRequest['payment_status_id'] = PaymentStatus::where('code', 'WA')->orWhere('title', 'Ожидает оплаты')->first()?->id ?? null;
            // $orderRequest['delivery_status_id'] = DeliveryStatus::where('code', 'UD')->orWhere('title', 'Не доставлен')->first()->id;
            $orderRequest['order_status_id'] = OrderStatus::where('code', OrderStatus::ISSUED)->orWhere('title', 'Оформлен')->first()?->id ?? null;

            $botName = session('bot_name') ?? request()->cookie('bot_name');
            \Log::info('SOURCE', ['source' => $orderRequest['source']]);
            $orderRequest['address'] = [
                'address' => $orderRequest['address'],
                'coordinates' => $orderRequest['coordinates'],
                'apartament_number' => $orderRequest['apartament_number'],
                'city' => CitiesService::getCity()->city,
            ];

            $orderRequest['is_anon'] = $orderRequest['is_anon'] ? true : false;

            $orderRequest['published'] = true;
            $orderRequest['source'] = $botName;
            $order = Order::create(array_merge($orderRequest->toArray(), $meta));

            // Если это оплата по счёту
            if ($orderRequest->has('legal_account') && $order->isPaymentByInvoce()) {
                $orderRequest['legal_account'] = json_decode($orderRequest->get('legal_account'), true);

                $legalAccount = LegalAccount::create([
                    'title' => $orderRequest['legal_account']['recipient'],
                    'address' => $orderRequest['legal_account']['address'],
                    'recipient' => $orderRequest['legal_account']['recipient'],
                    'recipient_account' => $orderRequest['legal_account']['recipient_account'],
                    'bik' => $orderRequest['legal_account']['bik'],
                    'bank' => $orderRequest['legal_account']['bank'],
                    'correspondent_account' => $orderRequest['legal_account']['correspondent_account'],
                    'inn' => $orderRequest['legal_account']['inn'],
                    'kpp' => $orderRequest['legal_account']['kpp'],
                    'order_id' => $order->id,
                ]);
            }

            // Для каждого магазина свой заказ . . .
            // и один глобальный для пользователя
            // Для каждого заказа сделать доставку

            foreach ($cartByMarket as $market) {
                $marketOrder = null;
                $price = 0.0;

                $meta['meta']['basePrice'] = 0;

                foreach ($market as $product) {
                    $price += $product->getPriceSumWithConditions();

                    if (isset($product->associatedModel->id)) {
                        $priceObject = ProductPrice::where('id', $product->associatedModel->id ?? false)->first();

                        /**
                         * @var \App\Services\CalcReponse
                         */
                        $calcReponse = $priceService->calc($priceObject, $product['attributes']['composition'] ?? [], 'price');

                        $meta['meta']['basePrice'] += $calcReponse->totalWithContitions * $product->quantity;
                        $meta['meta']['comissions']['marketplace'] = $priceObject->getMarketplaceComission();
                        $meta['meta']['comissions']['market'] = $priceObject->getMarketComission();
                    } else {
                        $meta['meta']['basePrice'] += $product->getPriceSumWithConditions();
                    }
                }

                // В заказе магазина не будем в общую стоимость учитывать и стоимость доставки
                $orderRequest['total_price'] = $price;

                $orderRequest['parent_id'] = $order->id;
                $orderRequest['market_id'] = $market->first()->associatedModel->market->id;
                $arrCart = $market->toArray();

                foreach ($arrCart as $i => $cartItem) {

                    // У Открытки нет ассоции с моделью
                    try {
                        $modelId = $arrCart[$i]['associatedModel']['id'];
                        unset($arrCart[$i]['associatedModel']);
                        $arrCart[$i]['associatedModel'] = [];
                        $arrCart[$i]['associatedModel']['id'] = $modelId;
                    } catch (\Throwable $th) {
                        // throw $th;
                    }
                }
                $orderRequest['cart'] = $arrCart;

                $orderRequest['uuid'] = (string) \Str::uuid();
                $orderRequest['source'] = $botName;
                $marketOrder = Order::create(array_merge($orderRequest->toArray(), $meta));

                $marketObject = Market::find($market->first()->associatedModel->market?->id);

                \Log::channel('marketplace')->info('Стоимость доставки', [$marketObject->toArray(), $marketObject?->delivery_price]);

                Delivery::create([
                    'published' => true,
                    'city_id' => CitiesService::getCity()->id,
                    'order_id' => $marketOrder->id,
                    'address' => $orderRequest['address'],
                    'km' => 0.0,
                    'price' => (float) $marketObject?->delivery_price ?? 0,
                ]);
            }
            \Cart::clear();

            return $order;
        }, 3);

        if ($order) {
            $paymentResolver = new \App\Gateway\PaymentGateway;

            $redirect = $paymentResolver->resolve($order);

            event(new OrderCreated($order));

            \Log::channel('marketplace')->log('info', 'Создан новый заказ', [
                'ID' => $order->id,
                '№' => $order->num_order,
                'Стоимость' => $order->total_price,
                'Пользователь' => $order->user_id,
            ]);

            \App\Jobs\SendOrderReminder::dispatch($order->id)->delay(now()->addMinutes(10));
            \session()->forget('order_delivery_radius_km');
            \session()->forget(['uds_points_used', 'uds_points_amount', 'uds_new_total', 'uds_old_total', 'uds_points', 'uds_code']);
            return response()->json([
                'redirect' => $redirect,
            ]);
        }

        \Log::channel('marketplace')->log('warnign', 'Ошибка создания заказа. Заказ небыл создан', [
            $cartByMarket,
            auth()->check() ? auth()->user() : null,
        ],);

        return back();
    }

    public function pdf(Order $order) {
        $order->load('legalAccount');
        $ch = $order->childs;
        $deliveryPrice = 0.0;
        foreach ($ch as $child) {
            $deliveryPrice += $child->delivery->price;
        }

        $legal = \TwillAppSettings::getGroupDataForSectionAndName('legal', 'legal')->content;
        $medias = \TwillAppSettings::getGroupDataForSectionAndName('legal', 'legal')->medias;
        $months = [
            'января',
            'февраля',
            'марта',
            'апреля',
            'мая',
            'июня',
            'июля',
            'августа',
            'сентября',
            'октября',
            'ноября',
            'декабря',
        ];

        $month = $months[$order->created_at->format('n') - 1];

        \Pdf::setOption(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        $pdf = \PDF::loadView('reports.pdf', [
            'order' => $order,
            'month' => $month,
            'legal' => $legal,
            'medias' => $medias,
            'deliveryPrice' => $deliveryPrice,
        ], []);

        $pdf->setHttpContext(
            stream_context_create([
                'ssl' => [
                    'allow_self_signed' => true,
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ],
            ])
        );

        return $pdf->download('Заказ_№' . $order->num_order . '.pdf');
    }

    /**
     * POST
     * Проверка радиуса доставки при выборе адреса
     */
    public function deliveryRadius(Request $request) {

        $deliveryPricesResult = [];
        $deliveryPricesResult['totalDeliveryPrice'] = 0;
        @[$lat, $long] = $request['coordinates'];

        if (! isset($lat) || ! isset($long) || ! $lat || ! $long) {
            session()->put('order_delivery_radius_km', -1);
        }

        if ($request['isKnowAdress']) {
            session()->forget('order_delivery_radius_km');
        }

        $cart = \Cart::getContent();
        $cartByMarket = $cart->sortBy('attributes.order')->groupBy('attributes.market_id');

        foreach ($cartByMarket as $_market) {
            $market = Market::find($_market->first()->associatedModel->market->id);

            $lt = $market->city->geo_lat;
            $ln = $market->city->geo_lon;

            $deliveryRadiusKm = isset($lat) && isset($long) ? \App\Services\Helpers::haversineGreatCircleDistance(
                $lat,
                $long,
                $lt,
                $ln
            ) : 0;

            $maxDeliveryRadius = $market->delivery_radius;

            if (isset($lat) && isset($long)) {
                session()->put('order_delivery_radius_km', $deliveryRadiusKm);
            }

            if ($deliveryRadiusKm > $maxDeliveryRadius) {

                return \response()->json([
                    'radius' => $deliveryRadiusKm,
                    'modal' => 'delivery-area',
                    'message' => "Продавец {$market->name} не осуществляет доставку по выбранному адресу. Попробуйте выбрать другой адрес.",
                    'r' => $maxDeliveryRadius,
                    'lat' => $lat,
                    'long' => $long,
                ], 400);
            } else {

                $deliveryPricesResult['markets'][$market->id] = [
                    'price' => $market->delivery_price ?? 0,
                ];

                $deliveryPricesResult['totalDeliveryPrice'] += $market->delivery_price ?? 0;
            }
        }

        $deliveryPricesResult['totalPrice'] = \Cart::getTotal() + $deliveryPricesResult['totalDeliveryPrice'];
        $deliveryPricesResult['radius'] = $deliveryRadiusKm;

        if (session('uds_points_used') && session('uds_old_total') && session('uds_new_total')) {
            $deliveryPricesResult['oldTotal'] = session('uds_old_total');
            $deliveryPricesResult['newTotal'] = session('uds_new_total');
        }

        return $deliveryPricesResult;
    }

    protected function findOrCreateUser(OrderRequest $data) {

        if ($data->filled('email2')) {
            $user = User::where('email', $data['email2'])->first();
            if ($user) {
                \auth()->login($user);

                return $user;
            }
        }

        if ($data->has('phone')) {
            $data['phone'] = str_replace(['(', ')', '-', ' '], ['', '', '', ''], $data['phone']);
            $user = User::where('phone', $data['phone'])->first();
            if ($user) {
                \auth()->login($user);

                return $user;
            }
        }

        $data['password'] = RegisterController::password(6, false, true, false);
        $name = explode(' ', $data['fio']);
        $user = User::create([
            'last_name' => $name[0] ?? '',
            'name' => $name[1] ?? '',
            'second_name' => $name[2] ?? '',
            'email' => $data['email2'],
            'phone' => $data['phone'] ?? '',
            'password' => Hash::make($data['password']),
        ]);

        \auth()->login($user);

        $sms = new SMSController($data['phone'], $data['password'], true, $name['name'] ?? '');
        $sms->sendSMS();

        event(new Registered($user));

        return $user;
    }
}
