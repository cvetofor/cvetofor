<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;
use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Forms\Fields\Checkbox;
use A17\Twill\Services\Forms\Fields\DatePicker;
use A17\Twill\Services\Forms\Fields\Input;
use A17\Twill\Services\Forms\Form;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;

class TagController extends BaseModuleController
{
    protected $moduleName = 'tags';

    protected $indexOptions = ['publish' => false];

    /**
     * This method can be used to enable/disable defaults. See setUpController in the docs for available options.
     */
    protected function setUpController(): void
    {
        $this->disablePermalink();
        $this->setTitleColumnKey('name');
        $this->disableCreate();
    }

    /**
     * See the table builder docs for more information. If you remove this method you can use the blade files.
     * When using twill:module:make you can specify --bladeForm to use a blade form instead.
     */
    public function getForm(TwillModelContract $model): Form
    {
        $form = parent::getForm($model);

        $form->add(
            Input::make()->name('name')->label('Название')
        );
        $form->add(
            Input::make()->name('slug')->label('Uri')
        );
        $form->add(
            Checkbox::make()->name('is_category_limited')->label('Ограничение категории')
        );
        $form->add(
            DatePicker::make()->name('limit_start_date')->label('Дата начала ограничения')
        );
        $form->add(
            DatePicker::make()->name('limit_end_date')->label('Дата окончания ограничения')
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
            Text::make()->field('slug')->title('Uri')
        );

        return $table;
    }
}
