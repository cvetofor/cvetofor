<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;
use A17\Twill\Services\Forms\Fields\Input;
use A17\Twill\Services\Forms\Form;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\Filters\BelongsToFilter;
use A17\Twill\Services\Listings\Filters\QuickFilter;
use A17\Twill\Services\Listings\Filters\QuickFilters;
use A17\Twill\Services\Listings\Filters\TableFilters;
use A17\Twill\Services\Listings\TableColumns;
use App\Models\Market;

class RemainController extends BaseModuleController
{
    protected $moduleName = 'remains';

    public function setUpController(): void
    {
        $this->setSearchColumns(['market_id']);
    }

    protected $titleColumnKey = 'quantity';

    protected $indexOptions = [
        'permalink' => false,
        'edit' => true,
        'create' => false,
        'delete' => true,
        'editInModal' => true,
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
            QuickFilter::make()
                ->label(__('Нет в наличии'))
                ->queryString('draft')
                ->scope('draft')
                // ->onlyEnableWhen($this->getIndexOption('publish'))
                ->amount(fn () => $this->repository->getCountByStatusSlug('draft', $scope)),
        ]);
    }

    public function getCreateForm(): Form
    {
        $form = Form::make();
        $form->add(Input::make()->name('quantity')->label('Количество')->type('number'));

        return $form;
    }

    public function getIndexTableColumns(): TableColumns
    {

        $table = parent::getIndexTableColumns();
        $table->forget(1);

        $table->push(
            Text::make()->field('product_id')->title('Продукт')->customRender(function ($model) {
                return $model->product?->title ?? '';
            })
        );

        $table->push(
            Text::make()->field('market_id')->title('Магазин')->customRender(function ($model) {
                return $model->market?->name ?? '';
            })
        );

        $table->push(
            Text::make()->field('quantity')->title('Количество')
        );

        return $table;
    }

    public function filters(): TableFilters
    {
        return TableFilters::make([
            BelongsToFilter::make()->field('market')->model(Market::class)->valueLabelField('name'),
        ]);
    }
}
