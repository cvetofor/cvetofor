<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;
use A17\Twill\Services\Listings\Columns\Image;
use A17\Twill\Services\Listings\Filters\QuickFilter;
use A17\Twill\Services\Listings\Filters\QuickFilters;
use A17\Twill\Services\Listings\TableColumns;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class PaymentController extends BaseModuleController
{
    public function __construct(Application $app, Request $request)
    {
        parent::__construct($app, $request);
    }

    protected $moduleName = 'payments';

    protected $titleColumnKey = 'name';

    protected function setUpController(): void
    {
        $this->modelTitle = 'Оплата';
        $this->enableReorder();
    }

    protected function getIndexTableColumns(): TableColumns
    {
        $table = parent::getIndexTableColumns();

        $table->get(1)->title('Название');

        $table->add(
            Image::make()
                ->field('logo')
        );

        return $table;
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
