<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;
use A17\Twill\Services\Forms\Fields\Input;
use A17\Twill\Services\Forms\Form;
use A17\Twill\Http\Controllers\Admin\NestedModuleController as BaseModuleController;

class GroupProductCategoryController extends BaseModuleController
{
    protected $moduleName = 'groupProductCategories';
    protected $showOnlyParentItemsInBrowsers = true;
    protected $nestedItemsDepth = 1;
    /**
     * This method can be used to enable/disable defaults. See setUpController in the docs for available options.
     */
    protected function setUpController(): void
    {
        $this->modelTitle = 'Категория букетов';
        $this->enableReorder();
        $this->setPermalinkBase('catalog');
    }

    protected function formData($request)
    {
        return [
            'metadata_card_type_options' => config('metadata.card_type_options'),
            'metadata_og_type_options' => config('metadata.opengraph_type_options'),
        ];
    }


    /**
     * This is an example and can be removed if no modifications are needed to the table.
     */
    protected function additionalIndexTableColumns(): TableColumns
    {
        $table = parent::additionalIndexTableColumns();

        $table->add(
            Text::make()->field('description')->title('Description')
        );

        return $table;
    }

    protected function form(?int $id, ?TwillModelContract $item = null): array
    {

        $item = $this->repository->getById($id, $this->formWith, $this->formWithCount);



        $this->permalinkBase .= '/' . $item->ancestorsSlug;
        $this->permalinkBase = str_replace('//', '/', $this->permalinkBase);

        $this->permalinkBase = rtrim($this->permalinkBase,'/');

        return parent::form($id, $item);
    }
}
