<?php

namespace App\Http\Controllers\Publical;

use App\Http\Controllers\Controller;
use App\Repositories\PageRepository;
use CwsDigital\TwillMetadata\Traits\SetsMetadata;
use Illuminate\Contracts\View\View;

class PageController extends Controller
{
    use SetsMetadata;

    public function show(string $slug, PageRepository $pageRepository): View
    {
        $page = $pageRepository->forNestedSlug($slug);

        if (! $page || ! $page->published) {
            abort(404);
        }

        $parent = $page;
        $breadcrumbs[] = $page;
        while ($parent = $parent->parent) {
            $breadcrumbs[] = $parent;
        }

        $this->setMetadata($page);
        $template='page';
        if($slug=='about'){
            $template='about';
        }
        if($slug=='payments'){
            $template='payments';
        }
        $array_data=[];
        if($slug=='contacts'){

            $template='contacts';
            foreach ($page->blocks as $block) {
                if($block->content&&is_array($block->content)){
                    $array_data=$block->content;
                }


            }
        }



        return view(config('is_new_desing')?'newdesing.'.$template:'site.page', ['item' => $page, 'breadcrumbs' => array_reverse($breadcrumbs),'array_data'=>$array_data]);
    }
}
