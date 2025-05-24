<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;
use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Forms\Fields\Input;
use A17\Twill\Services\Forms\Form;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;

class FormController extends BaseModuleController
{
    protected $moduleName = 'forms';

    /**
     * This method can be used to enable/disable defaults. See setUpController in the docs for available options.
     */
    protected function setUpController(): void
    {
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
            Input::make()->name('phone')->label('Телефон'),
        );

        // $form->add(
        //     Input::make()->name('email')->label('Email')
        // );
        $form->add(
            Input::make()->name('comment')->label('Комментарий')
        );
        $form->add(
            Input::make()->name('ip')->label('IP')
        );
        $form->add(
            Input::make()->name('page')->label('Страница')
        );
        $form->add(
            Input::make()->name('city_id')->label('ID города')
        );

        return $form;
    }

    /**
     * This is an example and can be removed if no modifications are needed to the table.
     */
    protected function additionalIndexTableColumns(): TableColumns
    {
        $table = parent::additionalIndexTableColumns();

        $table->add(
            Text::make()->field('phone')->title('Телефон'),
        );
        $table->add(
            Text::make()->field('email')->title('Email'),
        );
        $table->add(
            Text::make()->field('comment')->title('Комментарий'),
        );
        $table->add(
            Text::make()->field('ip')->title('IP'),
        );
        $table->add(
            Text::make()->field('page')->title('Страница'),
        );
        $table->add(
            Text::make()->field('city_id')->title('ID города'),
        );

        return $table;
    }
}
