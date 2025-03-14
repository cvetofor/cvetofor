<?php

namespace App\Http\Controllers\Twill;

use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use A17\Twill\Services\Listings\Filters\QuickFilter;
use A17\Twill\Services\Listings\Filters\QuickFilters;
use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;

class CityController extends BaseModuleController
{


    protected $moduleName = 'cities';

    protected $indexOptions = [];

    protected $titleColumnKey = 'city';

    protected function setUpController(): void
    {
        $this->modelTitle = 'Город';
        $this->setSearchColumns(['city']);
        $this->setTitleColumnKey('city');
    }


    protected $perPage = 50;

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

    protected $indexColumns = [
        'city' => [ // field column
            'optional' => true,
            'title' => 'Город',
            'field' => 'city',
        ],
        'address' => [ // field column
            'optional' => true,
            'title' => 'Адрес',
            'field' => 'address',
        ],
        'postal_code' => [ // field column
            'optional' => true,
            'title' => 'Почтовый индекс',
            'field' => 'postal_code',
        ],
        'country' => [ // field column
            'optional' => true,
            'title' => 'Страна',
            'field' => 'country',
        ],
        'federal_district' => [ // field column
            'optional' => true,
            'title' => 'Федеральный район',
            'field' => 'federal_district',
        ],
        'region_type' => [ // field column
            'optional' => true,
            'title' => 'Тип региона',
            'field' => 'region_type',
        ],
        'region' => [ // field column
            'optional' => true,
            'title' => 'Регион',
            'field' => 'region',
        ],
        'area' => [ // field column
            'optional' => true,
            'title' => 'Область',
            'field' => 'area',
        ],
        'city_type' => [ // field column
            'optional' => true,
            'title' => 'Тип города',
            'field' => 'city_type',
        ],
        'okato' => [ // field column
            'optional' => true,
            'title' => 'ОКАТО',
            'field' => 'okato',
        ],
        'oktmo' => [ // field column
            'optional' => true,
            'title' => 'ОКТМО',
            'field' => 'oktmo',
        ],
        'timezone' => [ // field column
            'optional' => true,
            'title' => 'Time zone',
            'field' => 'timezone',
        ],
        'population' => [ // field column
            'optional' => true,
            'title' => 'Численность',
            'field' => 'population',
        ],
        'foundation_year' => [ // field column
            'optional' => true,
            'title' => 'Год основания',
            'field' => 'foundation_year',
        ],
    ];
}
