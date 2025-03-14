<?php

namespace App\Http\Controllers\Publical;

use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Repositories\PageRepository;
use A17\Twill\Facades\TwillAppSettings;
use CwsDigital\TwillMetadata\Traits\SetsMetadata;

class PageController extends Controller
{
    use SetsMetadata;

    public function show(string $slug, PageRepository $pageRepository): View
    {
        $page = $pageRepository->forNestedSlug($slug);

        if (!$page || !$page->published) {
            abort(404);
        }

        $parent = $page;
        $breadcrumbs[] = $page;
        while($parent = $parent->parent)
        {
            $breadcrumbs[] = $parent;
        }

        $this->setMetadata($page);
        return view('site.page', ['item' => $page , 'breadcrumbs' => array_reverse($breadcrumbs)]);
    }
}
