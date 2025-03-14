<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;
use A17\Twill\Services\Listings\Filters\QuickFilter;
use A17\Twill\Services\Listings\Filters\QuickFilters;
use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;

class PaymentDetailController extends BaseModuleController {
    protected $moduleName = 'paymentDetails';
    protected $perPage = 100;


    public function setUpController(): void {

        $this->setSearchColumns(['company_name', 'inn', 'kpp']);
        $this->setTitleColumnKey('fio');
        $this->disablePermalink();
    }

    protected function getIndexTableColumns(): TableColumns {
        $columns = new TableColumns();

        $title = Text::make()->field('fio')->title('Название компании');
        $title->linkToEdit(true);
        $columns->add(
            $title
        );
        $columns->add(
            Text::make()->field('inn')->title('ИНН')->optional()
        );
        $columns->add(
            Text::make()->field('ogrn')->title('ОГРНИП')->optional()
        );
        $columns->add(
            Text::make()->field('legal_address')->title('ОГРНИП')->optional()
        );
        $columns->add(
            Text::make()->field('postal_address')->title('Юр. Адрес')->optional()
        );
        $columns->add(
            Text::make()->field('bank_fullname')->title('Название банка')->optional()
        );
        $columns->add(
            Text::make()->field('payment_account')->title('Платежный аккаунт')->optional()
        );
        $columns->add(
            Text::make()->field('correspondent_account')->title('Корреспондентский счёт')->optional()
        );
        $columns->add(
            Text::make()->field('bik')->title('БИК')->optional()
        );

        return $columns;
    }

    /**
     * The quick filters to apply to the listing table.
     */
    public function quickFilters(): QuickFilters {
        $scope = ($this->submodule ? [
            $this->getParentModuleForeignKey() => $this->submoduleParentId,
        ] : []);

        return QuickFilters::make([
            QuickFilter::make()
                ->label(twillTrans('twill::lang.listing.filter.all-items'))
                ->queryString('all')
                ->amount(fn() => $this->repository->getCountByStatusSlug('all', $scope)),
        ]);
    }


    /*
     * Columns of the browser view for this module when browsed from another module
     * using a browser form field
     */
    protected $browserColumns = [
        'company_name' => [ // field column
            'title' => 'Название компании',
            'field' => 'company_name',
        ],
        'inn' => [ // field column
            'title' => 'ИНН',
            'field' => 'inn',
        ],
    ];
}
