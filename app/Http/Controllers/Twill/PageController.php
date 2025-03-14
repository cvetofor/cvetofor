<?php

namespace App\Http\Controllers\Twill;

use App\Models\Page;
use CwsDigital\TwillMetadata\Traits\SetsMetadata;
use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Http\Controllers\Admin\NestedModuleController as BaseModuleController;

class PageController extends BaseModuleController
{
    use SetsMetadata;

    protected $moduleName = 'pages';

    public $slugAttributes = [
        'title',
    ];

    protected $showOnlyParentItemsInBrowsers = false;

    protected $nestedItemsDepth = 4;

    protected function formData($request)
    {
        return [
            'metadata_card_type_options' => config('metadata.card_type_options'),
            'metadata_og_type_options' => config('metadata.opengraph_type_options'),
        ];
    }

    protected function setUpController(): void
    {
        $this->modelTitle = 'Страница';
        $this->setPermalinkBase('');
        $this->withoutLanguageInPermalink();
        $this->enableReorder();
    }

    public function showPublic($slug)
    {
        $page = Page::forSlug($slug)->first();
        $this->setMetadata($page);
        return view('site.pages.page', ['page' => $page]);
    }

    protected function form(?int $id, ?TwillModelContract $item = null): array
    {
        $item = $this->repository->getById($id, $this->formWith, $this->formWithCount);
        Page::fixTree();
        $this->permalinkBase = $item->ancestorsSlug;

        return parent::form($id, $item);
    }
}
