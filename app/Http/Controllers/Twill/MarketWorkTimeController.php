<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Services\Listings\Filters\QuickFilter;
use A17\Twill\Services\Listings\Filters\QuickFilters;
use A17\Twill\Services\Listings\TableColumns;

class MarketWorkTimeController extends \App\Http\Controllers\Twill\AuthorizedBaseModuleController
{
    protected $moduleName = 'marketWorkTimes';

    protected function setUpController(): void
    {
        $this->modelTitle = 'Время работы';
        $this->setTitleColumnKey('title');
        $this->setSearchColumns(['id']);
        $this->disablePermalink();
        $this->disablePublish();
        $this->disableCreate();

        $this->disableCreate();
        // $this->disableEdit();
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
                ->label(twillTrans('twill::lang.listing.filter.all-items'))
                ->queryString('all'),
            // ->amount(fn () => $this->repository->getCountByStatusSlug('all', $scope)),
        ]);
    }

    /**
     * Дополнительные поля в списке
     */
    protected function getIndexTableColumns(): TableColumns
    {
        $table = parent::getIndexTableColumns();
        $table->get(0)->title('Магазин / Город');

        $after = $table->splice(1);

        return $table->merge($after);
    }
}
