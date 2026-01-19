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

class MenuPriceController extends BaseModuleController
{
    protected $moduleName = 'menuPrices';
    /**
     * This method can be used to enable/disable defaults. See setUpController in the docs for available options.
     */
    protected function setUpController(): void
    {
        $this->disablePermalink();

        $this->modelTitle = 'Цены в меню';
    }


    /**
     * This is an example and can be removed if no modifications are needed to the table.
     */

    protected function getIndexTableColumns(): TableColumns
    {
        $table = new TableColumns();


        $table->add(Text::make()->field('price_start')->title('Начальная цена'));
        $table->add(Text::make()->field('price_end')->title('Конечная цена'));
        $table->add(Text::make()->field('sort')->title('Сортировка'));





        return $table;
    }
    public function getForm(TwillModelContract $model): Form
    {
        return Form::make([
            Input::make()
                ->name('price_start')
                ->label('Начальная цена')
                ->required(true),

            Input::make()
                ->name('price_end')
                ->label('Конечная цена')
                ->required(true),
            Input::make()
                ->name('sort')
                ->label('Сортировка')
                ->required(true),
        ]);
    }
}
