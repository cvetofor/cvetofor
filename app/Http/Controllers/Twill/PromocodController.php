<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Forms\Fields\DatePicker;
use A17\Twill\Services\Forms\Fields\MultiSelect;
use A17\Twill\Services\Forms\Fields\Select;
use A17\Twill\Services\Listings\Columns\Image;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;
use A17\Twill\Services\Forms\Fields\Input;
use A17\Twill\Services\Forms\Form;
use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;
use App\Models\Category;
use App\Models\GroupProductCategory;
use App\Models\Product;
use App\Models\Tag;

class PromocodController extends BaseModuleController
{
    protected $moduleName = 'promocods';
    /**
     * This method can be used to enable/disable defaults. See setUpController in the docs for available options.
     */
    protected function setUpController(): void
    {
        $this->modelTitle = 'Промокоды';
        $this->disablePermalink();
    }


    /**
     * This is an example and can be removed if no modifications are needed to the table.
     */

    protected function getIndexTableColumns(): TableColumns
    {
        $table = parent::getIndexTableColumns();

        $table->get(1)->title('Название');

        $table->add(
            Text::make()->field('code')->title('Description')
        );


        $table->add(Text::make()->field('orders_count')->title('Кол-во заказов'));
        $table->add(Text::make()->field('average_order_amount')->title('Средний чек'));
        $table->add(Text::make()->field('discount_sum')->title('Сумма скидок'));



        return $table;
    }
    public function getForm(TwillModelContract $model): Form
    {


        return Form::make([
            Input::make()->name('code')->label('Промокод')->required(true),
            Input::make()->name('promoall')->rows(5)->label('Синонимы промокода'),

            Select::make()
                ->name('type_sale')
                ->label('Тип скидки')
                ->options([
                    0 => 'Фиксированная скидка в рублях',
                    1 => 'Процентная скидка',
                    2 => 'Бесплатная доставка',
                    3 => 'Доставка скидка %',
                    4 => 'Доставка скидка , руб',
                ])
                ->required(true),

            Input::make()
                ->name('sale')
                ->label('Скидка (%)')
                ->type('number')
                ->min(0)
                ->max(9999999999.99)
                ->step(0.01)->required(true),

            Select::make()
                ->name('platform')
                ->label('Платформа')
                ->options([
                    'site' => 'Сайт',
                    'telegram' => 'Приложение ТГ',
                  //  'app' => 'Приложение на смартфоне',
                ])
                ,

            DatePicker::make()->name('date_start')->label('Дата начала')->withoutTime(true)  ->required(true),//повтор дата
            DatePicker::make()->name('date_end')->label('Дата окончания') ->withoutTime(true)  ->required(true),//повтор дата

            Input::make()->name('total_limit')->label('Общий лимит')->type('number')  ->required(true),//повтор дата
          //  Input::make()->name('client_limit')->label('Лимит на клиента')->type('number'),
            Input::make()->name('minimal_sum_cart')->label('Минимальная сумма корзины')->type('number'),

            Select::make()
                ->name('type_max_sale')
                ->label('Тип максимальной скидки')
                ->options([
                    0 => 'Фиксированная скидка в рублях',
                    1 => 'Процентная скидка',
                ]),

            Input::make()
                ->name('sum_max_sale')
                ->label('Максимальная скидка (% или Р)')
                ->type('number')
                ->min(0)
                ->max(9999999999.99)
                ->step(0.01),

            Select::make()
                ->name('type_order')
                ->label('Заказ')
                ->options([
                    0 => 'Новый',
                    1 => 'Повторный',
                    2 => 'Любой',
                ]),

            Select::make()
                ->name('show_in_order')
                ->label('Отображение в заказе')
                ->options([
                    1 => 'Да',
                    0 => 'Нет',
                ]),

          /*  MultiSelect::make()
                ->name('products')
                ->label('Товары')
                ->options(Product::pluck('title','id')->toArray()),*/
            MultiSelect::make()
                ->name('categories')
                ->label('Категории')
                ->options(GroupProductCategory::pluck('title','id')->toArray()),
            MultiSelect::make()
                ->name('tags')
                ->label('Поводы')
                ->options(Tag::pluck('name','id')->toArray()),
        ]);
    }
}
