<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasBlocks;
use App\Casts\TimeCast;
use A17\Twill\Models\User;
use A17\Twill\Models\Model;
use App\Services\CitiesService;
use Illuminate\Database\Eloquent\Builder;
use A17\Twill\Models\Behaviors\HasRelated;
use A17\Twill\Models\Behaviors\HasRevisions;
use App\Pipelines\Market\DeliveryPrice\SetZeroIfSumEagerThen;
use Illuminate\Support\Collection;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasEvents;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Pipeline\Pipeline;
use Carbon\Carbon;

class Market extends Model
{
    use HasRevisions;
    use HasRelated;
    use HasBlocks;

    protected $dates = [
        'publish_start_date',
        'publish_end_date',
    ];

    protected $casts = [
        'additional_addresses' => 'array',
        'deliveries_radius'    => 'array',
    ];


    protected static function boot()
    {
        parent::boot();

        static::created(function ($market) {
            $time1 = new MarketWorkTime(
                ['published' => true]
            );
            $time1->save();
            $market->work_times()->associate($time1->id);
            $time2 = new MarketWorkTime(
                ['published' => true]
            );
            $time2->save();
            $market->delivery_times()->associate($time2->id);
            $market->save();


            if (empty($market->user_id)) {
                $market->user_id = auth()->user()->id;
                $market->save();
            }
        });
    }

    protected $fillable = [
        'published',
        'name',
        'user_id',
        'city_id',
        'address',
        'Адрес',
        'phone',
        'email',
        'order_prepaid',
        'card',
        'card_holder_fio',
        'delivery_night_price',
        'delivery_out_town_km_price',
        'additional_service_photo_price',
        'additional_service_hot_delivery_price',
        'additional_service_to_current_time_price',
        'holidays_percent',
        'holidays_out_town_km_price',
        'publish_start_date',
        'publish_end_date',
        'market_work_times_id',
        'market_delivery_times_id',
        'postcard_price',
        'additional_addresses',
        'deliveries_radius',
        'balance',
        'price_i_dont_know_address',
        'telegram_bot_market_username',
    ];

    protected $hidden = [
        'balance',
    ];


    public function isActive()
    {
        return $this->published && ($this->publish_start_date <= now() && ($this->publish_end_date >= now() || $this->publish_end_date == null) && $this->user->published);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function employees()
    {
        return $this->belongsToMany(\A17\Twill\Models\User::class, 'market_user', 'market_id', 'user_id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function work_times(): BelongsTo
    {
        return $this->belongsTo(MarketWorkTime::class, 'market_work_times_id');
    }

    public function delivery_times(): BelongsTo
    {
        return $this->belongsTo(MarketWorkTime::class, 'market_delivery_times_id');
    }

    public function prices()
    {
        return $this->hasMany(ProductPrice::class, 'market_id');
    }

    /**
     * Заказы магазина
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }


    public function scopePublished($query): Builder
    {
        return $query->where("{$this->getTable()}.published", true)->visible()->whereHas('user', function ($qu) {
            return $qu->where('published', true);
        });
    }


    public function getDeliveryRadiusAttribute()
    {
        if (Hollyday::isHollyDays()) {
            return \Illuminate\Support\Collection::make($this->deliveries_radius)->where('holidays', true)->max('radius') ?? 0;
        }

        return \Illuminate\Support\Collection::make($this->deliveries_radius)->max('radius') ?? 0;
    }
    
    public function getDeliveryProductPriceAttribute($outerGroupProductPrice = false)
    {
        $id = $this->id;
        
        $price = \Cache::driver('array')->rememberForever(
            'request_delivery_product_price_market_' . $id,
            function () use ($id, $outerGroupProductPrice) {


                $cartPrice = 0;
                $radiusCollection = null;

               
                $radiusCollection = \Illuminate\Support\Collection::make($this->deliveries_radius);
        


                // Берем ближайший радиус
                $DaP = $radiusCollection->sort(fn($l, $r) => $l['radius'] >= $r['radius'])->where('radius', '>=',  0)->first();
             
                $DaP = $DaP ?: $radiusCollection->sort(fn($l, $r) => $l['radius'] >= $r['radius'])->where('radius', '<=',  0)->last();
           
               
                return $DaP['price'] ?? 0;
            }
        );
    
        return $price;
    }
    public function getDeliveryPriceAttribute($outerGroupProductPrice = false)
    {
        $id = $this->id;

        $price = \Cache::driver('array')->rememberForever(
            'request_delivery_price_market_' . $id,
            function () use ($id, $outerGroupProductPrice) {

                $userDeliveryRadius = \session()->get('order_delivery_radius_km', null);

                // Если не установлен радиус, берем максимальную стоимость доставки
                if ($userDeliveryRadius && $userDeliveryRadius < 0 && $this->price_i_dont_know_address) {
                    return $this->price_i_dont_know_address;
                }


                $cartPrice = 0.0;
                // Если считаем не по цене букета, в листинге, берем стоимость корзины
                $cart = \Cart::getContent();
                $items = $cart->where('attributes.market_id', '=', $id);

                foreach ($items as $key => $item) {
                    $cartPrice += $item->getPriceSumWithConditions();
                }


                $cartPrice = $outerGroupProductPrice > 0 ? $outerGroupProductPrice : $cartPrice;

                $radiusCollection = null;

                if (Hollyday::isHollyDays()) {
                    $radiusCollection = \Illuminate\Support\Collection::make($this->deliveries_radius)->where('holidays', true);
                } else {
                    $radiusCollection = \Illuminate\Support\Collection::make($this->deliveries_radius);
                }



                // Берем ближайший радиус
                $DaP = $radiusCollection->sort(fn($l, $r) => $l['radius'] >= $r['radius'])->where('radius', '>=', $userDeliveryRadius ?? 0)->first();
                $DaP = $DaP ?: $radiusCollection->sort(fn($l, $r) => $l['radius'] >= $r['radius'])->where('radius', '<=', $userDeliveryRadius ?? 0)->last();

                if (
                    isset($DaP['free_delivery_at']) && $DaP['free_delivery_at'] > 0 &&
                    // Если цена букета, или цена корзины >= бесплатной доставки
                    ($cartPrice >= $DaP['free_delivery_at'] || $cartPrice >= $DaP['free_delivery_at'])
                ) {
                    return 0;
                }

                return $DaP['price'] ?? 0;
            }
        );
        return $price;
    }


    public function workTimeLong()
    {
        $times = self::humanTimes($this->work_times->times);

        foreach ($times as $key => $weekDay) {
            $times[$key] = array_keys($times[$key]);
        }

        $weeksday = array_merge(
            $times['wednesday'] ?? [],
            $times['thursday'] ?? [],
            $times['friday'] ?? [],
            $times['monday'] ?? [],
            $times['tuesday'] ?? [],
        );
        $weekend = array_merge(
            $times['saturday'] ?? [],
            $times['sunday'] ?? [],
        );

        if ($weeksday) {
            $weeksday[0] = (string) collect($weeksday)->min();
            $weeksday[1] = (string) collect($weeksday)->max();
            $weeksday[0] = $weeksday[0][0] . $weeksday[0][1] . ':' . $weeksday[0][2] . $weeksday[0][3];
            $weeksday[1] = $weeksday[1][0] . $weeksday[1][1] . ':' . $weeksday[1][2] . $weeksday[1][3];
        }

        if ($weekend) {
            $weekend[0] = $weekend ? (string) collect($weekend)->min() : false;
            $weekend[1] = $weekend ? (string) collect($weekend)->max() : false;
            $weekend[0] = $weekend ? $weekend[0][0] . $weekend[0][1] . ':' . $weekend[0][2] . $weekend[0][3] : false;
            $weekend[1] = $weekend ? $weekend[1][0] . $weekend[1][1] . ':' . $weekend[1][2] . $weekend[1][3] : false;
        }

        return [
            $weeksday ? 'Будни с ' . $weeksday[0] . ' до ' . $weeksday[1] : null,
            $weekend ? 'Выходные С ' . $weekend[0] . ' до ' . $weekend[1] : null,
        ];
    }


    public static function getDeliveryDate($markets)
    {
        $date = CitiesService::DateTime();

        return $date;
    }

    public function intervals()
    {
        return $this->hasMany(Interval::class)->orderBy('start_time', 'asc');
    }


    /**
     * Преобразует минуты в формат HH:MM.
     */
    private function minutesToTime($minutes)
    {
        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;
        return sprintf('%02d:%02d', $hours, $remainingMinutes);
    }

    private static function intervalAvailable($interval, $currentTime)
    {
        list($start_hour, $start_minutes) = explode(':', $interval->start_time);
        $startMinutes = $start_hour * 60 + $start_minutes;

        list($close_hour, $close_min) = explode(':', $interval->close_time);
        $closeMinutes = $close_hour * 60 + $close_min;
        
        $closeTimeInMinutes = $interval->close_time_behavior === 'before'
            ? $startMinutes - $closeMinutes
            : $startMinutes + $closeMinutes;


        return $currentTime < $closeTimeInMinutes;
    }

    public function getAvailableIntervals(Carbon $currentTime = null): Collection
    {
        // Если параметр времени не передан, используем текущее время
        $currentTime = $currentTime ?? now();

        // Если переданное время меньше текущего, возвращаем пустую коллекцию
        if ($currentTime->lessThan(now())) {
            return collect(); // Пустая коллекция
        }

        // Возвращаем только доступные интервалы
        return $this->intervals()->filter(function ($interval) use ($currentTime) {
            return $interval->isAvailable($currentTime);
        });
    }

    static function humanTimes($times)
    {
        $times = \Arr::undot(array_flip(\Arr::map($times, function ($line, $key) {
            return str_replace(
                ['monday', 'tuesday', 'friday', 'wednesday', 'thursday', 'saturday', 'sunday'],
                ['monday.', 'tuesday.', 'friday.', 'wednesday.', 'thursday.', 'saturday.', 'sunday.'],
                $key
            );
        })));
        return $times;
    }

    
    private static function parseWorkingHours($workingHoursArray)
    {
        $parsedHours = [];

        foreach ($workingHoursArray as $key => $isOpen) {
            // Предположим, что есть дополнительный флаг "isStart"
            $isStart = $isOpen['isStart'] ?? true; // По умолчанию считаем, что это начало интервала

            $day = substr($key, 0, -4);
            $time = substr($key, -4);

            if (!isset($parsedHours[$day])) {
                $parsedHours[$day] = [];
            }

            // Если это начало интервала или массив для дня пуст, добавляем время
            if ($isStart) {
                $parsedHours[$day][] = substr($time, 0, 2) . ':' . substr($time, 2);
            }
        }

        return $parsedHours;
    }

 
       public static function getDeliveryTime($market, $date = null)
    {
        $date = $date ?? CitiesService::DateTime();

        $hours = (int) $date->format('H');
        $minutes = (int) $date->format('i');
        $currentTimeInMinutes = $hours * 60 + $minutes;

        $weekMap = [
            'sunday'    => 0,
            'monday'    => 1,
            'tuesday'   => 2,
            'wednesday' => 3,
            'thursday'  => 4,
            'friday'    => 5,
            'saturday'  => 6,
        ];
        $todayOfWeek = (int) $date->format('w');

        // Получение рабочих дней и интервалов доставки
        $workTimes = \Arr::pluck($market, 'work_times.times');
        $deliveryIntervals = \Arr::pluck($market, 'intervals');

        $workHours = self::parseWorkingHours($workTimes[0] ?? []);

        $availableDeliveryTimes = [];
        $todayDeliveryTimes = [];

        foreach ($workHours as $dayOfWeek => $times) {
            $weekDay = $weekMap[$dayOfWeek];

            // Инициализируем массив
            $availableDeliveryTimes[$dayOfWeek] = [];
            if ($weekDay === $todayOfWeek) {
                $todayDeliveryTimes = [];
            }

            foreach ($times as $time) {
                list($hours, $minutes) = explode(':', $time);
                $totalMinutes = $hours * 60 + $minutes;
                $next_time = $totalMinutes + 60;

                foreach ($deliveryIntervals[0] ?? [] as $interval) {
                    list($start_hour, $start_minutes) = explode(':', $interval->start_time);
                    $startMinutes = $start_hour * 60 + $start_minutes;


                    $intervalString = [$interval->start_time, $interval->end_time];

                    // Добавляем в общий список
                    if ($totalMinutes <= $startMinutes && $next_time > $startMinutes && !in_array($intervalString, $availableDeliveryTimes[$dayOfWeek] ?? [])) {
                        $availableDeliveryTimes[$dayOfWeek][] = $intervalString;
                    }

                    // Добавляем в todayTimes только если это сегодня

                        if( $weekDay === $todayOfWeek && !in_array($intervalString, $todayDeliveryTimes) &&self::intervalAvailable($interval, $currentTimeInMinutes)){
                            $todayDeliveryTimes[] = $intervalString;
                        }

                }
            }
        }

        return [
            'todayTimes' => $todayDeliveryTimes,
            'times' => $availableDeliveryTimes
        ];
    }


    /**
     * Сумма средств для вывода магазина
     */
    public function withdrawalFunds()
    {
        $totalSumForPaid = 0.0;
        $completedOrders = $this->getCompletedOrders();
        $returnedOrders = $this->getReturnedOrders();

        foreach ($completedOrders as $order) {
            $totalSumForPaid += ($order->total_price + $order->delivery?->price ?? 0) - $order->getMarketplaceComission();
        }

        foreach ($returnedOrders as $order) {
            $totalSumForPaid -= ($order->total_price + $order->delivery?->price ?? 0) - $order->getMarketplaceComission();
        }

        return $totalSumForPaid;
    }

    // Сумма замороженных средств
    public function frozenFunds()
    {
        $totalSum = 0.0;

        $frozenOrders = $this->getFrozenOrders();
        foreach ($frozenOrders as $order) {
            $totalSum += ($order->total_price + $order->delivery?->price ?? 0) - $order->getMarketplaceComission();
        }

        return $totalSum;
    }


    public function getFrozenOrders()
    {
        $returnedOrdersId = \DB::select(
            "
        SELECT id as order_id
        FROM orders
        WHERE orders.market_id = :market_id AND
        (
            orders.order_status_id = (SELECT order_statuses.id from order_statuses where order_statuses.code = :order_status_code_confirmed LIMIT 1) OR
            orders.order_status_id = (SELECT order_statuses.id from order_statuses where order_statuses.code = :order_status_code_issued LIMIT 1) OR
            orders.order_status_id = (SELECT order_statuses.id from order_statuses where order_statuses.code = :order_status_code_work LIMIT 1)
        )
        AND
        orders.payment_status_id = (SELECT payment_statuses.id from payment_statuses where payment_statuses.code like :payment_status_code LIMIT 1)
        EXCEPT SELECT order_id
        FROM balance_order;",
            [
                'market_id'                   => $this->id,
                'order_status_code_confirmed' => OrderStatus::CONFIRMED,
                'order_status_code_issued'    => OrderStatus::ISSUED,
                'order_status_code_work'      => OrderStatus::WORK,
                'payment_status_code'         => PaymentStatus::PAID,
            ]
        );

        return Order::whereIn('id', Collection::make($returnedOrdersId)->pluck('order_id')->toArray())->get();
    }

    public function getCompletedOrders()
    {
        $completedOrdersId = \DB::select(
            "
        SELECT id as order_id
        FROM orders
        WHERE orders.market_id = :market_id AND
        orders.order_status_id = (SELECT order_statuses.id from order_statuses where order_statuses.code like :order_status_code LIMIT 1) AND
        orders.payment_status_id = (SELECT payment_statuses.id from payment_statuses where payment_statuses.code like :payment_status_code LIMIT 1)
        EXCEPT SELECT order_id
        FROM balance_order
        WHERE balance_order.code = :order_status_code
        ;",
            [
                'market_id'           => $this->id,
                'order_status_code'   => OrderStatus::COMPLETE,
                'payment_status_code' => PaymentStatus::PAID,
            ]
        );

        return Order::whereIn('id', Collection::make($completedOrdersId)->pluck('order_id')->toArray())->get();
    }

    public function getReturnedOrders()
    {
        $returnedOrdersId = \DB::select(
            "
        SELECT id as order_id
        FROM orders
        WHERE orders.market_id = :market_id AND
        (
            orders.order_status_id = (SELECT order_statuses.id from order_statuses where order_statuses.code = :order_status_code_canceled LIMIT 1) OR
            orders.order_status_id = (SELECT order_statuses.id from order_statuses where order_statuses.code = :order_status_code_canceled_user LIMIT 1)
        )
        AND
        orders.payment_status_id = (SELECT payment_statuses.id from payment_statuses where payment_statuses.code like :payment_status_code LIMIT 1)
        INTERSECT SELECT order_id
        FROM balance_order
        WHERE (balance_order.code = :order_status_code) AND
        (SELECT COUNT(order_id) from balance_order WHERE balance_order.code = :order_status_code_canceled OR balance_order.code = :order_status_code_canceled_user) = 0
        ;",
            [
                'market_id'                       => $this->id,
                'order_status_code'               => OrderStatus::COMPLETE,
                'order_status_code_canceled'      => OrderStatus::CANCELED,
                'order_status_code_canceled_user' => OrderStatus::CANCELED_USER,
                'payment_status_code'             => PaymentStatus::PAID,
            ]
        );

        return Order::whereIn('id', Collection::make($returnedOrdersId)->pluck('order_id')->toArray())->get();
    }
}
