<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Services\Forms\Form;
use A17\Twill\Services\Forms\Fields\Input;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;
use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Listings\Filters\QuickFilter;
use A17\Twill\Services\Listings\Filters\QuickFilters;
use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;

class DeliveryController extends \App\Http\Controllers\Twill\AuthorizedBaseModuleController
{
    protected $moduleName = 'deliveries';
    /**
     * This method can be used to enable/disable defaults. See setUpController in the docs for available options.
     */
    protected function setUpController(): void
    {

        $this->modelTitle = 'Доставка';
        $this->disablePermalink();
        $this->disableCreate();
        #$this->disableEdit();
        $this->disableSortable();
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
                ->label('В работе')
                ->queryString('atWork')
                ->scope('atWork'),

            QuickFilter::make()
                ->label('Доставленные')
                ->queryString('delivered')
                ->scope('delivered'),
        ]);
    }

    /**
     * This is an example and can be removed if no modifications are needed to the table.
     */
    protected function getIndexTableColumns(): TableColumns
    {
        $table = TableColumns::make();

        $table->add(
            Text::make()->field('title')->title('Информация')->linkToEdit()
        );

        return $table;
    }
}
