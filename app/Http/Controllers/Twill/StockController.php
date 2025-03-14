<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;
use A17\Twill\Services\Listings\Filters\QuickFilter;
use A17\Twill\Services\Listings\Filters\QuickFilters;
use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;

class StockController extends BaseModuleController
{
    protected $moduleName = 'stocks';

    protected $indexOptions = [
        'permalink' => false,
    ];

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

    public function setUpController() : void
    {
        $this->modelTitle = 'Скидка';
        $this->setSearchColumns(['title']);
        $this->enableSkipCreateModal();
    }

    /**
     * Дополнительные поля в списке
     */
    protected function getIndexTableColumns(): TableColumns
    {
        $table = parent::getIndexTableColumns();
        $table->get(1)->title('Название');
        $table->forget(2);

        $after = $table->splice(1);

        $after->push(
            Text::make()->field('code')->title(__('Код'))->sortable()
        );
        $after->push(
            Text::make()->field('price')->title(__('Фиксированная скидки'))->sortable()
        );

        $after->push(
            Text::make()->field('percent')->title(__('Процент от заказа'))->sortable()
        );


        return $table->merge($after);
    }
}
