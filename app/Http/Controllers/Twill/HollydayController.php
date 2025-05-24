<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;
use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Forms\Fields\Input;
use A17\Twill\Services\Forms\Form;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\Filters\QuickFilter;
use A17\Twill\Services\Listings\Filters\QuickFilters;
use A17\Twill\Services\Listings\TableColumns;

class HollydayController extends BaseModuleController
{
    protected $moduleName = 'hollydays';

    /**
     * This method can be used to enable/disable defaults. See setUpController in the docs for available options.
     */
    protected function setUpController(): void
    {
        $this->modelTitle = 'Праздник';
        $this->disablePermalink();
        $this->setTitleColumnKey('title');
    }

    /**
     * The quick filters to apply to the listing table.
     */
    public function quickFilters(): QuickFilters
    {
        $scope = ($this->submodule ? [
            $this->getParentModuleForeignKey() => $this->submoduleParentId,
        ] : []);

        return QuickFilters::make([
            QuickFilter::make()
                ->label(twillTrans('twill::lang.listing.filter.all-items'))
                ->queryString('all')
                ->amount(fn () => $this->repository->getCountByStatusSlug('all', $scope)),
        ]);
    }

    /**
     * See the table builder docs for more information. If you remove this method you can use the blade files.
     * When using twill:module:make you can specify --bladeForm to use a blade form instead.
     */
    public function getForm(TwillModelContract $model): Form
    {
        $form = parent::getForm($model);

        $form->add(
            Input::make()->name('title')->label('Название')
        );

        $form->add(
            Input::make()->name('description')->label('Описание')
        );

        $form->add(
            Input::make()->name('begin_at')->label('Дата начала')
        );

        $form->add(
            Input::make()->name('end_at')->label('Дата окончания')
        );

        return $form;
    }

    /**
     * This is an example and can be removed if no modifications are needed to the table.
     */
    protected function getIndexTableColumns(): TableColumns
    {
        $table = parent::getIndexTableColumns();
        $title = $table->get(1);
        $title->title('Название');

        $table->add(
            Text::make()->field('description')->title('Описание')
        );

        return $table;
    }
}
