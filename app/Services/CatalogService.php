<?php

namespace App\Services;

use A17\Twill\Models\Tag;
use App\Models\GroupProduct;
use App\Models\GroupProductCategory;
use App\Models\Market;
use App\Models\Product;
use App\Models\ProductPrice;

class CatalogService {
    /**
     * Ищет цены в конкретном городе по категории с пагинацией
     *
     * @param [array<int>] $categories
     * @param  int  $paginate
     */
    public function findPricesByCategoriesId($categories, $paginate = 4, $price = false, $beetwen = false) {
        $result = [];

        $markets = Market::published()->whereHas('prices', fn($q) => $q->whereHas('groupProduct'))->where('city_id', CitiesService::getCity()->id)->get();

        foreach ($categories as $i => $category) {

            $builder = ProductPrice::whereIn('market_id', $markets->pluck('id')->toArray())
                ->whereHas('groupProduct', function ($qgp) use ($category, $markets) {
                    return $qgp->whereHas(
                        'remains',
                        fn($qr) => $qr->where('published', true)
                            ->whereIn('market_id', $markets->pluck('id')->toArray())
                    )
                        ->where('category_id', $category);
                })
                ->where('price', '<>', null)
                ->where('price', '<>', 0)
                ->published()
                ->priceFilter()
                ->orderByPrice();

            if (
                request()->input('order.title') && in_array(request()->input('order.title'), [
                    'asc',
                    'desc',
                ], true)
            ) {
                $builder = $builder->join('group_products', 'group_products.id', 'product_prices.group_product_id')
                    ->orderBy('group_products.title', strtoupper(request()->input('order.title')));
            } else {

                // После объединения. price->id == groupProduct->id
                // Стоит использоват price->sku, так как он является уникальным
                $builder = $builder->join('group_products', 'group_products.id', 'product_prices.group_product_id')
                    ->orderBy('group_products.title', strtoupper('asc'));
            }
            $result['category_' . $category] = $builder->paginate($paginate, ['*'], 'category_' . $category);
        }

        return $result;
    }

    public function findByTag($tag, $paginate = 4) {
        $markets = Market::published()->whereHas('prices', fn($q) => $q->whereHas('groupProduct'))->where('city_id', CitiesService::getCity()->id)->get();

        $result = [];

        $builder = ProductPrice::whereIn('market_id', $markets->pluck('id')->toArray())
            ->whereHas('groupProduct', function ($qgp) use ($tag, $markets) {
                return $qgp->whereHas('remains', fn($qr) => $qr->where('published', true)->whereIn('market_id', $markets->pluck('id')->toArray()))->whereHas('tags', fn($q) => $q->where('tag_id', $tag->id ?? false));
            })
            ->where('price', '<>', null)
            ->where('price', '<>', 0)
            ->published()
            ->priceFilter()
            ->orderByPrice();

        if (
            request()->input('order.title') && in_array(request()->input('order.title'), [
                'asc',
                'desc',
            ], true)
        ) {
            $builder = $builder->join('group_products', 'group_products.id', 'product_prices.group_product_id')
                ->orderBy('group_products.title', strtoupper(request()->input('order.title')));
        } else {
            // После объединения. price->id == groupProduct->id
            // Стоит использоват price->sku, так как он является уникальным
            $builder = $builder->join('group_products', 'group_products.id', 'product_prices.group_product_id')
                ->orderBy('group_products.title', strtoupper('asc'));
        }

        $result['category_' . $tag?->slug ?? ''] = $builder->paginate($paginate, ['*'], 'category_' . $tag?->slug ?? '');

        return $result;
    }

    public function search($search, $paginate = 12) {
        $tag = Tag::where('name', 'ilike', '%' . $search . '%')->first();

        $sku = ProductPrice::where('sku', $search)
            ->published()
            ->where('price', '<>', null)
            ->where('price', '<>', 0)->join('group_products', 'group_products.id', 'product_prices.group_product_id')
            ->orderBy('group_products.title', strtoupper('asc'))->paginate($paginate);

        if ($sku->count() > 0) {
            return $sku;
        }

        $markets = Market::published()->whereHas('prices', fn($q) => $q->whereHas('groupProduct'))->where('city_id', CitiesService::getCity()->id)->get();

        $builder = ProductPrice::whereIn('market_id', $markets->pluck('id')->toArray())
            ->whereHas('groupProduct', function ($qgp) use ($search, $tag, $markets) {
                return
                    $qgp->whereHas('remains', fn($qr) => $qr->where('published', true)->whereIn('market_id', $markets->pluck('id')->toArray())->where(function ($q) use ($search) {
                        return $q->where('title', 'ilike', '%' . $search . '%')->orWhere('description', 'ilike', '%' . $search . '%');
                    }))
                    ->orWhereHas('tags', fn($q) => $q->where('tag_id', $tag->id ?? false));
            })
            ->where('price', '<>', null)
            ->where('price', '<>', 0)
            ->published()
            ->priceFilter()
            ->orderByPrice();

        if (
            request()->input('order.title') && in_array(request()->input('order.title'), [
                'asc',
                'desc',
            ], true)
        ) {
            $builder = $builder->join('group_products', 'group_products.id', 'product_prices.group_product_id')
                ->orderBy('group_products.title', strtoupper(request()->input('order.title')));
        } else {

            // После объединения. price->id == groupProduct->id
            // Стоит использоват price->sku, так как он является уникальным
            $builder = $builder->join('group_products', 'group_products.id', 'product_prices.group_product_id')
                ->orderBy('group_products.title', strtoupper('asc'));
        }

        return $builder->paginate($paginate);
    }

    public function searchProducts($search, $paginate = 12) {

        $markets = Market::published()->whereHas('prices', fn($q) => $q->whereHas('product'))->where('city_id', CitiesService::getCity()->id)->get();

        $products = Product::published()->where('title', 'ilike', '%' . $search . '%')->whereHas('category', function ($q) {
            return $q->where('is_visible', true);
        })->get()->pluck('id');

        $builder = ProductPrice::whereIn('market_id', $markets->pluck('id')->toArray())
            ->whereHas('groupProduct', function ($qgp) use ($products, $markets) {
                return $qgp->whereHas(
                    'remains',
                    fn($qr) => $qr->where('published', true)
                        ->whereIn('market_id', $markets->pluck('id')->toArray())
                )->whereHas('blocks', function ($q) use ($products) {
                    return $q->where('type', 'products')->whereIn('content->browsers->products->0', $products);
                });
            })
            ->where('price', '<>', null)
            ->where('price', '<>', 0)
            ->published()
            ->priceFilter()
            ->orderByPrice();

        if (
            request()->input('order.title') && in_array(request()->input('order.title'), [
                'asc',
                'desc',
            ], true)
        ) {
            $builder = $builder->join('group_products', 'group_products.id', 'product_prices.group_product_id')
                ->orderBy('group_products.title', strtoupper(request()->input('order.title')));
        } else {

            // После объединения. price->id == groupProduct->id
            // Стоит использоват price->sku, так как он является уникальным
            $builder = $builder->join('group_products', 'group_products.id', 'product_prices.group_product_id')
                ->orderBy('group_products.title', strtoupper('asc'));
        }

        return $builder->paginate($paginate);
    }

    /**
     * В меню
     *
     * @return void
     */
    public function getPublishedCategories() {
        $markets = Market::published()->whereHas('prices', fn($q) => $q->whereHas('product'))->where('city_id', CitiesService::getCity()->id)->get();

        return GroupProductCategory::published()->whereHas('products', function ($q) use ($markets) {
            return $q->whereHas('remains', function ($qr) use ($markets) {
                return $qr->where('published', true)->whereIn('market_id', $markets->pluck('id')->toArray());
            });
        })->get();
    }

    /**
     * В меню
     *
     * @return void
     */
    public function getPublishedProducts() {
        return Product::published()
            ->whereHas(
                'prices',
                function ($q) {
                    return $q->whereHas(
                        'market',
                        function ($qm) {
                            return $qm->where('city_id', CitiesService::getCity()->id);
                        }
                    )->where('price', '<>', 0)->where('price', '<>', null);
                }
            )
            ->whereIn('parent_id', [null, 0])->whereHas(
                'category',
                function ($qc) {
                    return $qc->where('is_visible', true)->where('is_visible_menu', true);
                }
            )->get();
    }

    public static function generateSku($market_name, $region, $city, $market_id = null, $id = null) {
        $result = '';
        $market_name = mb_strtoupper($market_name);

        if (isset($market_name[0])) {
            $result .= mb_strtoupper($market_name[0]);
        }

        if (isset($region[0])) {
            $result .= mb_strtoupper($region[0]);
        }

        if (isset($city[0])) {
            $result .= mb_strtoupper($city[0]);
        }

        $result .= $market_id;
        $result .= str_pad($id, 6, 0, STR_PAD_LEFT);

        return $result;
    }

    public static function isSku($sku) {
        return preg_match('/\w{3,}\d{6}/', $sku);
    }

    public static function getRecomendations($market_id) {
        return ProductPrice::published()
            ->where('price', '<>', null)
            ->where('price', '<>', 0)
            ->where('market_id', $market_id)
            ->whereHas('product', function ($qp) use ($market_id) {
                return $qp->whereHas('category', function ($qc) {
                    return $qc->where('is_additional_product', true);
                })->whereHas('remains', fn($qr) => $qr->where('published', true)->where('market_id', $market_id));
            })
            ->where('quantity_from', 1)
            ->inRandomOrder()
            ->limit(9)
            ->get();
    }

    /*
     * Для фидов
     */
    public function getPublishedCategoriesFeed($cityId) {
        $markets = Market::published()->whereHas('prices', fn($q) => $q->whereHas('product'))->where('city_id', $cityId)->get();

        return GroupProductCategory::published()->whereHas('products', function ($q) use ($markets) {
            return $q->whereHas('remains', function ($qr) use ($markets) {
                return $qr->where('published', true)->whereIn('market_id', $markets->pluck('id')->toArray());
            });
        })->get();
    }

    public function getPublishedProductsFeed($cityId) {
        $price = new ProductPrice;
        $groupProduct = $price->groupProduct;

        return $groupProduct;
    }
}
