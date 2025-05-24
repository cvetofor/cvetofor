<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\Filters\BasicFilter;
use A17\Twill\Services\Listings\Filters\QuickFilter;
use A17\Twill\Services\Listings\Filters\QuickFilters;
use A17\Twill\Services\Listings\Filters\TableFilters;
use A17\Twill\Services\Listings\TableColumns;
use App\Models\City;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Repositories\OrderRepository;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class OrderController extends \App\Http\Controllers\Twill\AuthorizedBaseModuleController
{
    protected $moduleName = 'orders';

    public function setUpController(): void
    {
        $this->setSearchColumns(['parent_id']);
        $this->disableCreate();
        // $this->disableEdit();
        $this->disablePublish();
        $this->disableBulkPublish();
        $this->disableRestore();
        $this->disableBulkRestore();
        $this->disableForceDelete();
        $this->disableBulkForceDelete();
        $this->disableDelete();
        $this->disableBulkDelete();
        $this->disablePermalink();
        $this->disableEditor();
        $this->disableBulkEdit();
        $this->disableIncludeScheduledInList();

        $this->modelTitle = 'Заказ';
    }

    public function index(?int $parentModuleId = null): mixed
    {
        if ((auth()->user()->role->code ?? false) == 'courier') {
            return redirect()->route('twill.deliveries.index');
        }

        return parent::index($parentModuleId);
    }

    /**
     * The quick filters to apply to the listing table.
     */
    public function quickFilters(): QuickFilters
    {

        return QuickFilters::make([
            QuickFilter::make()
                ->label('Новые')
                ->queryString('issued')
                ->scope('issued')
                ->amount(fn () => $this->repository->filter($this->repository->getBaseModel())->issued()->count()),

            QuickFilter::make()
                ->label('Принятые')
                ->queryString('accepted')
                ->scope('accepted')
                // ->onlyEnableWhen($this->getIndexOption('publish'))
                ->amount(fn () => $this->repository->filter($this->repository->getBaseModel())->accepted()->count()),

            QuickFilter::make()
                ->label('Завершенные')
                ->queryString('succesfuled')
                ->amount(fn () => $this->repository->filter($this->repository->getBaseModel())->succesfuled()->count())
                ->scope('succesfuled'),

            QuickFilter::make()
                ->label('Отклоненные')
                ->queryString('closed')
                ->amount(fn () => $this->repository->filter($this->repository->getBaseModel())->closed()->count())
                ->scope('closed'),

            QuickFilter::make()
                ->label('Тендер')
                ->queryString('tender')
                ->amount(fn () => $this->repository->filter($this->repository->getBaseModel())->tender()->count())
                ->scope('tender'),
        ]);
    }

    // public function filters(): TableFilters
    // {

    //     if (auth()->user()->can('is_owner')) {
    //         return TableFilters::make([
    //             BasicFilter::make()
    //                 ->queryString('cities')
    //                 ->options(
    //                     collect(app(City::class)->whereHas('markets', fn($qm) => $qm->whereHas('orders'))->pluck('city', 'id'))
    //                 )
    //                 ->apply(function (Builder $builder, string $value) {
    //                     $builder->whereHas('market', fn($q) => $q->whereHas('city', fn($qc) => $qc->where('id', $value)));
    //                 })->label('Города'),
    //         ]);
    //     }
    //     return TableFilters::make();

    // }

    /**
     * This is an example and can be removed if no modifications are needed to the table.
     */
    protected function getIndexTableColumns(): TableColumns
    {
        $table = TableColumns::make();

        $table->add(
            Text::make()->field('title')->title('№ Заказа')->linkToEdit()
        );

        $table->add(
            Text::make()->field('payment_status_id')->title('Статус оплаты')->renderHtml()->customRender(function ($item) {
                return $item->paymentStatus->title ?? '';
            })->sortable()
        );

        $table->add(
            Text::make()->field('payment_id')->title('Метод оплаты')->renderHtml()->customRender(function ($item) {
                return $item->payment->name ?? '';
            })
        );

        $table->add(
            Text::make()->field('total_price')->title('Стоимость заказа')->sortable()
        );

        $table->add(
            Text::make()->field('delivery.price')->title('Стоимость доставки')->renderHtml()->customRender(function ($item) {
                return $item->delivery->price ?? '';
            })
        );

        $table->add(
            Text::make()->field('created_at')->title('Дата создания')->renderHtml()->customRender(function ($item) {
                return $item->created_at->format('d.m.y h:i');
            })->sortable()
        );

        $table->add(
            Text::make()->field('courier')->title('Дата доставки')->renderHtml()->customRender(function ($item) {

                return (new \DateTime($item->delivery_date))->format('d.m.Y') ?? '-';
            })
        );
        $table->add(
            Text::make()->field('source')->title('Источник')->renderHtml()->customRender(function ($item) {

                return $item->source ?? '';
            })
        );
        $actionName = 'Действие';
        if (request()->has('filter')) {
            $filter = json_decode(request()->get('filter'), true)['status'];

            if ($filter == 'tender' || $filter == 'issued') {
                $table->add(
                    Text::make()->field('order_status_id')->title($actionName)->renderHtml()->customRender(function ($item) {
                        return '
                        <form method="POST" action="'.route('twill.orders.status', ['order' => $item->id]).'">
                                 '.csrf_field().'
                                 <input type="hidden" name="action" value="take">
                                <button class="button button--green">Взять в работу</button>
                        </form>
                        ';
                    })
                );
            } elseif ($filter === 'accepted') {
                $table->add(
                    Text::make()->field('order_status_id')->title($actionName)->renderHtml()->customRender(function ($item) {
                        return '<form method="POST" action="'.route('twill.orders.status', ['order' => $item->id]).'">
                                 '.csrf_field().'
                                 <input type="hidden" name="action" value="complete">
                                 <button class="button button--green" onclick="return confirm(\'Вы уверены ?\')" type="submit">Завершить заказ</button>
                        </form>';
                    })
                );
            } elseif ($filter === 'succesfuled') {
                $table->add(
                    Text::make()->field('order_status_id')->title($actionName)->renderHtml()->customRender(function ($item) {
                        return '';
                    })
                );
            } else {
                $table->add(
                    Text::make()->field('order_status_id')->title($actionName)->renderHtml()->customRender(function ($item) {
                        return '';
                    })
                );
            }
        }

        return $table;
    }

    public function changeOrderStatus(Request $request, $order)
    {

        $data = $this->validate($request, [
            'order_id' => 'exists:order,id',
            'action' => 'in:take,refuse,complete',
        ]);

        $order = Order::where('id', $order)->firstOrFail();

        abort_unless(
            auth()->user()->can('edit-module', 'orders')
                || auth()->user()->can('edit', $order),
            403
        );

        $repository = new OrderRepository($order);

        if (
            $data['action'] == 'take' &&
            ($order->market_id == auth('twill_users')->user()->getMarketId() ||
                $order->market_id == null
            )
        ) {
            $result = $repository->update($order->id, [
                'order_status_id' => OrderStatus::where('code', OrderStatus::CONFIRMED)->first()->id,
            ]);

            // ТОЛЬКО ЗДЕСЬ МОЖНО МЕНЯТЬ market_id
            $order->update([
                'market_id' => auth('twill_users')->user()->getMarketId(),
            ]);
            $order->Save();

            \Log::channel('marketplace')->log('info', 'Магазин '.auth('twill_users')->user()->getMarketId().' взял заказ');
        }
        //  else if ($data['action'] == 'refuse') {
        //     $result = $repository->update($order->id,[
        //         'order_status_id' => OrderStatus::where('code', OrderStatus::ISSUED)->first()->id,
        //     ]);

        //     // ТОЛЬКО ЗДЕСЬ МОЖНО МЕНЯТЬ market_id
        //     $order->update([
        //         'market_id' => null,
        //     ]);
        //     $order->Save();

        //     \Log::channel('marketplace')->log('info', 'Магазин ' . auth('twill_users')->user()->getMarketId() . ' отказася от заказа');
        // }
        elseif ($data['action'] == 'complete') {
            $result = $repository->update($order->id, [
                'order_status_id' => OrderStatus::where('code', OrderStatus::COMPLETE)->first()->id,
            ]);
            \Log::channel('marketplace')->log('info', 'Заказ завёршен');
        } else {
            return back();
        }

        return back();
    }
}
