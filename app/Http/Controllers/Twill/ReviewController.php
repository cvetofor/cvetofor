<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;
use A17\Twill\Services\Forms\Fields\Input;
use A17\Twill\Services\Forms\Form;
use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;

class ReviewController extends BaseModuleController
{
    protected $moduleName = 'reviews';
    /**
     * This method can be used to enable/disable defaults. See setUpController in the docs for available options.
     */
    protected function setUpController(): void
    {
        $this->modelTitle = 'Отзыв';
        $this->disablePermalink();
    }

    /**
     * See the table builder docs for more information. If you remove this method you can use the blade files.
     * When using twill:module:make you can specify --bladeForm to use a blade form instead.
     */
    public function getForm(TwillModelContract $model): Form
    {
        $form = parent::getForm($model);

        $form->add(
            Input::make()->name('description')->label('Описание')
        );
        $form->add(
            Input::make()->name('user_id')->label('ID покупателя')->disabled()
        );
        $form->add(
            Input::make()->name('order_id')->label('ID заказа')->disabled()
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
            Text::make()->field('description')->title('Описание')
        );

        $table->add(
            Text::make()->field('user_id')->title('Покупатель ID')
        );

        $table->add(
            Text::make()->field('order_id')->title('Заказ ID')
        );

        return $table;
    }
}
