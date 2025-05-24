<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;
use A17\Twill\Services\Listings\Filters\QuickFilter;
use A17\Twill\Services\Listings\Filters\QuickFilters;
use A17\Twill\Services\Listings\TableColumns;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class RegionController extends BaseModuleController
{
    protected $moduleName = 'regions';

    protected $indexOptions = [];

    protected $titleColumnKey = 'name_with_type';

    protected $perPage = 100;

    // protected function getIndexOption($option)
    // {
    //     $this->authorize('admin');

    //     return parent::getIndexOption($option);
    // }

    public function import()
    {
        abort_unless(\Gate::allows('edit-module', 'cities'), 403);

        return view('twill.regions.import');
    }

    public function runImport()
    {
        $this->authorize('edit-module', 'cities');
        $out = '';

        try {
            Artisan::call('regions:import');
        } catch (\Exception $e) {
            $out .= $e->getMessage();
            Log::error($out);
        }

        try {
            Artisan::call('cities:import');
        } catch (\Exception $e) {
            $out .= $e->getMessage();
            Log::error($out);
        }

        return back()->with([
            'message' => filled($out) ? 'Произошла ошибка' : 'Успешно',
        ]);
    }

    protected function getIndexTableColumns(): TableColumns
    {
        $table = parent::getIndexTableColumns();

        $table->get(1)->title('Название');

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
