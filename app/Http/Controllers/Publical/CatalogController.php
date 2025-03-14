<?php

namespace App\Http\Controllers\Publical;

use stdClass;
use Illuminate\Support\Arr;
use App\Models\ProductPrice;
use Illuminate\Http\Request;
use App\Services\CitiesService;
use App\Services\CatalogService;
use App\Http\Controllers\Controller;
use App\Models\GroupProductCategory;
use Illuminate\Support\Facades\Cache;
use A17\Twill\Facades\TwillAppSettings;
use A17\Twill\Models\Tag;
use App\Models\GroupProduct;
use Artesaos\SEOTools\Facades\SEOTools;
use App\Repositories\GroupProductRepository;
use CwsDigital\TwillMetadata\Traits\SetsMetadata;
use App\Repositories\GroupProductCategoryRepository;
use App\Services\Defenders\ProductPriceDefender;
use App\ViewModel\CatalogController\MainPageTagsModel;
use Illuminate\Support\Collection;
use App\Helpers\SeoinfoHelper;
use morphos\Russian\GeographicalNamesInflection;

class CatalogController extends Controller {
    use SetsMetadata;

    protected $ttl = 0;


    public function index(Request $request, CatalogService $catalogService) {
        $categories = GroupProductCategory::published()->has('products')->get();

        $banner = TwillAppSettings::get('main-page.main_page.banner');

        if ($request->ajax()) {
            return $this->ajaxResponse($categories->pluck('id')->toArray(), $catalogService);
        }

        $unique = md5(
            json_encode(
                array_merge(
                    $categories->pluck('id')->toArray(),
                    \request()->toArray(),
                    [
                        'city_id' => CitiesService::getCity()->id,
                    ]
                )
            )
        );

        $prices = \Cache::remember('index|' . $unique, now()->addMinutes(1), fn() => $catalogService->findPricesByCategoriesId($categories->pluck('id')->toArray()));

        $city = GeographicalNamesInflection::getCase(CitiesService::getCity()->city, 'предложный');

        return view('welcome', compact('prices', 'banner', 'city'));
    }

    public function welcome(Request $request, CatalogService $catalogService) {
        $categories = TwillAppSettings::get('main-page.main_page.categories');

        $banner = TwillAppSettings::get('main-page.main_page.banner');

        if ($request->ajax()) {

            $_categories = [];
            foreach ($categories->pluck('id')->toArray() as $cagegory) {
                if (request()->has('category_' . $cagegory)) {
                    $_categories[] = $cagegory;
                }
            }

            $remains = $catalogService->findPricesByCategoriesId($_categories);
            if (!$remains) {

                $keys = array_keys(request()->all());
                foreach ($keys as $key) {
                    if (strpos($key, 'category_') !== false) {
                        $tag = str_replace('category_', '', $key);
                    }
                }


                $tagModel = Tag::where('slug', $tag)->firstOrFail();
                $remains = $catalogService->findByTag($tagModel);
            }

            return response()->json([
                'data' => Arr::map($remains, function ($paginator) {
                    return view('components.category', ['paginator' => $paginator])->render();
                }),
            ]);
        }

        $tags = TwillAppSettings::get('main-page.main_page.main_tags') ?? [];

        $tags = $tags ? $tags->toArray() : [];
        $_tags = $tags ? \Arr::pluck($tags, 'content.item') : [];


        $mainPageTagsModel = [];
        if (isset($_tags[0])) {
            $tags = [];
            # Для такой же сортировки, как в админ панели
            foreach ($_tags as $tag) {
                $tags[] = Tag::where('slug', $tag)->first();
            }
        }
        $taggedPrices = [];
        foreach ($tags as $tag) {
            if ($tag) {
                $unique = md5(
                    json_encode(
                        array_merge(
                            $categories->pluck('id')->toArray(),
                            \request()->toArray(),
                            [
                                'city_id' => CitiesService::getCity()->id,
                                'tag_id'  => $tag->id,
                            ]
                        )
                    )
                );
                $prices = \Cache::remember('welcome_categories_tags|' . $unique, now()->addMinutes(1), fn() => $catalogService->findByTag($tag));
                $mainPageTagsModel[] = new MainPageTagsModel($tag, $prices);
            }
        }

        $prices = [];
        if ($categories) {
            $unique = md5(
                json_encode(
                    array_merge(
                        $categories->pluck('id')->toArray(),
                        \request()->toArray(),
                        [
                            'city_id' => CitiesService::getCity()->id,
                        ]
                    )
                )
            );

            $city = GeographicalNamesInflection::getCase(CitiesService::getCity()->city, 'предложный');

            $prices = \Cache::remember('welcome_categories_prices|' . $unique, now()->addMinutes(1), fn() => $catalogService->findPricesByCategoriesId($categories->pluck('id')->toArray()));
        }

        SEOTools::setTitle('Доставка цветов в Улан-Удэ заказать букет с доставкой недорого по цене магазина Цветофор');
        SEOTools::setDescription('Заказать букет цветов в Улан-Удэ с доставкой на дом недорого. Доставка цветов в Улан-Удэ по адресу заказать онлайн на сайте по цене интернет-магазина Цветофор');

        return view('welcome', compact('prices', 'banner', 'mainPageTagsModel', 'tags', 'city'));
    }


    public function category(
        $slug,
        Request $request,
        CatalogService $catalogService,
        GroupProductRepository $groupProductRepository,
        GroupProductCategoryRepository $groupProductCategoryRepository,
    ) {
        $category = $groupProductCategoryRepository->forNestedSlug($slug);

        if ($category && $category->published) {

            if ($request->ajax()) {
                return $this->ajaxResponse([$category->id], $catalogService, 16);
            }

            $prices = $catalogService->findPricesByCategoriesId([$category->id], 16);

            $breadcrumbs = array_reverse($this->breadcrumbs($category));

            $this->setMetadata($category);

            return view('category', compact('prices', 'breadcrumbs', 'category'));
        }

        abort(404);
    }

    public function tags(
        $tag,
        CatalogService $catalogService,
        Request $request,
        \App\Services\CitiesService $citiesService,
    ) {

        $tagModel = Tag::where('slug', $tag)->firstOrFail();

        $banner = TwillAppSettings::get('main-page.main_page.banner');

        if ($request->ajax()) {

            $prices = $catalogService->findByTag($tagModel);
            return response()->json([
                'data' => Arr::map($prices, function ($paginator) {
                    return view('components.category', ['paginator' => $paginator])->render();
                }),
            ]);
        }

        $prices = $catalogService->findByTag($tagModel);
        SEOTools::setTitle($tagModel->name . ' В ' . $citiesService::getCity()->parent_case);

        $seoHelper = SeoinfoHelper::getInstance()->getSeoForUrl($_SERVER['REQUEST_URI']);

        if (!empty($seoHelper['title'])) {
            SEOTools::setTitle(str_replace('%city%', $citiesService::getCity()->parent_case, $seoHelper['title']));
        }

        if (!empty($seoHelper['desc'])) {
            SEOTools::setDescription(str_replace('%city%', $citiesService::getCity()->parent_case, $seoHelper['desc']));
        }

        $seoText = '';
        if (!empty($seoHelper['text'])) {
            $seoText = $seoHelper['text'];
            $seoText = str_replace('%city%', $citiesService::getCity()->parent_case, $seoText);
        }

        return view('tags', compact('prices', 'banner', 'tagModel', 'seoText'));
    }



    public function product(
        $slug = false,
        ProductPrice $price,
        GroupProductCategoryRepository $groupProductCategoryRepository,
        ProductPriceDefender $productPriceDefender,
    ) {
        $groupProduct = $price->groupProduct;

        $breadcrumbs = isset($groupProduct->category) ? array_reverse($this->breadcrumbs($groupProduct->category)) : [];

        $item = new stdClass();
        $item->nestedSlug = '';
        $item->title = $groupProduct->title;
        $breadcrumbs[] = $item;

        $canPutToCart = !$productPriceDefender->isProductNotPublished($price);

        abort_if(
            ($groupProduct->category && $slug !== $groupProduct->category->nestedSlug . '/' . $groupProduct->slug
                || !$price->market->isActive()
            ),
            404
        );

        if ($groupProduct) {
            try {
                $this->setMetadata($groupProduct);
            } catch (\Throwable $th) {
                //throw $th;
            }
        }

        $currentCity = \App\Services\CitiesService::getCity()->parent_case;
        $seoHelper = SeoinfoHelper::getInstance()->getSeoForUrl($_SERVER['REQUEST_URI']);

        if (!empty($seoHelper['title'])) {
            SEOTools::setTitle(str_replace('%city%', $currentCity, $seoHelper['title']));
        }

        if (!empty($seoHelper['desc'])) {
            SEOTools::setDescription(str_replace('%city%', $currentCity, $seoHelper['desc']));
        }

        $seoText = '';
        if (!empty($seoHelper['text'])) {
            $seoText = $seoHelper['text'];
            $seoText = str_replace('%city%', $currentCity, $seoText);
        }


        return view('product', compact('price', 'groupProduct', 'breadcrumbs', 'canPutToCart', 'seoText'));
    }



    public function search(Request $request, CatalogService $catalogService) {
        $data = $this->validate($request, [
            'q'       => 'required_if:product,""|min:2',
            'product' => 'required_if:q,""|min:1',
        ]);

        $method = isset($data['q']) ? 'search' : 'searchProducts';

        $search = isset($data['q']) ? $data['q'] : $data['product'];
        $search = htmlspecialchars($search);

        if ($request->ajax()) {
            return response()->json([
                'data' => ['category_search' => view('components.category', ['paginator' => $catalogService->{$method}($search)])->render()],
            ]);
        }
        SEOTools::setTitle('Поиск по сайту: ' . $search);

        $result = $catalogService->{$method}($search);

        $currentCity = \App\Services\CitiesService::getCity()->parent_case;
        $seoHelper = SeoinfoHelper::getInstance()->getSeoForUrl($_SERVER['REQUEST_URI']);

        if (!empty($seoHelper['title'])) {
            SEOTools::setTitle(str_replace('%city%', $currentCity, $seoHelper['title']));
        }

        if (!empty($seoHelper['desc'])) {
            SEOTools::setDescription(str_replace('%city%', $currentCity, $seoHelper['desc']));
        }

        $seoText = '';
        if (!empty($seoHelper['text'])) {
            $seoText = $seoHelper['text'];
            $seoText = str_replace('%city%', $currentCity, $seoText);
        }

        $seoH1 = '';
        if (!empty($seoHelper['h1'])) {
            $seoH1 = str_replace('%city%', $currentCity, $seoHelper['h1']);
        }
        return view('search', compact('result', 'search', 'seoText', 'seoH1'));
    }

    public function searchFast(Request $request, CatalogService $catalogService) {
        $data = $this->validate($request, [
            'q' => 'required|min:2',
        ]);

        $search = $data['q'];

        return response()->json([
            'data' => $catalogService->search($search)->transform(function ($price) {

                return [
                    'price' => round($price->public_price),
                    'title' => $price->title,
                    'href'  => $price->link,
                ];
            }),
        ]);
    }

    protected function breadcrumbs($item) {
        $parent = $item;
        if ($item) {
            $breadcrumbs[] = $item;
        }
        if ($parent && $parent->parent) {
            while ($parent = $parent->parent) {
                $parent->nestedSlug = 'catalog/' . $parent->nestedSlug;
                $breadcrumbs[] = $parent;
            }
        }

        $catalog = new stdClass();
        $catalog->nestedSlug = '';
        $catalog->title = 'Каталог';
        $breadcrumbs[] = $catalog;
        return $breadcrumbs;
    }

    protected function ajaxResponse($categories, $catalogService, $paginate = 4) {
        $_categories = [];
        foreach ($categories as $cagegory) {
            if (request()->has('category_' . $cagegory)) {
                $_categories[] = $cagegory;
            }
        }
        $remains = $catalogService->findPricesByCategoriesId($_categories, $paginate);
        return response()->json([
            'data' => Arr::map($remains, function ($paginator) {
                return view('components.category', ['paginator' => $paginator])->render();
            }),
        ]);
    }
}
