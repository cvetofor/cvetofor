<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;
use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Forms\Fields\Input;
use A17\Twill\Services\Forms\Form;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;

class LegalAccountController extends BaseModuleController
{
    protected $moduleName = 'legalAccounts';

    /**
     * This method can be used to enable/disable defaults. See setUpController in the docs for available options.
     */
    protected function setUpController(): void
    {
        $this->modelTitle = 'Юр. компания';
        $this->disablePermalink();
        $this->disablePublish();
        $this->disableBulkPublish();
        $this->setSearchColumns(['recipient', 'recipient_account', 'bik', 'inn', 'kpp']);
    }

    /**
     * See the table builder docs for more information. If you remove this method you can use the blade files.
     * When using twill:module:make you can specify --bladeForm to use a blade form instead.
     */
    public function getForm(TwillModelContract $model): Form
    {
        $form = parent::getForm($model);

        $form->add(
            Input::make()->name('recipient')->label('Получатель')
        );
        $form->add(
            Input::make()->name('recipient_account')->label('Счет получателя')
        );
        $form->add(
            Input::make()->name('bik')->label('БИК')
        );
        $form->add(
            Input::make()->name('bank')->label('Наименование банка')
        );
        $form->add(
            Input::make()->name('correspondent_account')->label('Корреспондентский счет')
        );
        $form->add(
            Input::make()->name('inn')->label('ИНН')
        );
        $form->add(
            Input::make()->name('order_id')->label('Номер заказа')
        );
        $form->add(
            Input::make()->name('address')->label('Адрес')
        );

        return $form;
    }

    /**
     * This is an example and can be removed if no modifications are needed to the table.
     */
    protected function getIndexTableColumns(): TableColumns
    {
        $table = TableColumns::make();

        $table->add(
            Text::make()->field('recipient')->title('Покупатель')
        );

        $table->add(
            Text::make()->field('order_id')->title('Номер заказа')
        );

        return $table;
    }
}
