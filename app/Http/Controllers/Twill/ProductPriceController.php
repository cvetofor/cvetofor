<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;
use A17\Twill\Services\Listings\Filters\QuickFilter;
use A17\Twill\Services\Listings\Filters\QuickFilters;

class ProductPriceController extends BaseModuleController
{
    protected $moduleName = 'productPrices';

    protected $indexOptions = [
        'permalink' => false,
    ];

    protected function setUpController(): void
    {
        $this->modelTitle = 'Стоимость';
        $this->labels['listing.filter.all-items'] = __('Все');
        $this->labels['listing.filter.draft'] = __('Нет в наличии');
        $this->setSearchColumns(['id', 'sku']);
        $this->setTitleColumnKey('id');
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
}
