<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Models\Contracts\TwillModelContract;

use A17\Twill\Services\Forms\Fields\Select;
use A17\Twill\Services\Listings\TableColumns;
use A17\Twill\Services\Forms\Fields\Input;
use A17\Twill\Services\Forms\Form;
use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;

use App\Models\Market;

use App\Models\Store;

class StoreController extends BaseModuleController
{
    protected $moduleName = 'stores';
    /**
     * This method can be used to enable/disable defaults. See setUpController in the docs for available options.
     */
    protected function setUpController(): void
    {
        $this->modelTitle = 'Адреса магазинов';
        $this->disablePermalink();
    }


    /**
     * This is an example and can be removed if no modifications are needed to the table.
     */

    protected function getIndexTableColumns(): TableColumns
    {
        $table = parent::getIndexTableColumns();

        $table->get(1)->title('Название');





        return $table;
    }

    public function getCreateForm(): Form
    {

        return Form::make([
            Input::make()
                ->name('title')
                ->label('Название/Адрес'),

            Select::make()
                ->name('market_id')
                ->label('Магазин')
                ->options(
                    Market::all()->pluck('name', 'id')->toArray()
                )
                ->required(true),
        ]);
    }
}
