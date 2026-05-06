<?php

namespace App\Services;

use A17\Twill\Repositories\ModuleRepository;
use App\Models\Market;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\Remain;
use Illuminate\Support\Facades\DB;

class ProductCopyService
{
    public function copyOneProductToMarket(
        int $productId,
        int $targetMarketId,
        ?int $newParentId = null,
        ModuleRepository $repository
    ): ?Product {
        $sourceProduct = Product::query()->findOrFail($productId);

        if ((int) $sourceProduct->market_id === (int) $targetMarketId) {
            return null;
        }

        $exists = Product::query()
            ->where('market_id', $targetMarketId)
            ->where('copy_id', $sourceProduct->id)
            ->first();

        if ($exists) {

            return null;
        }

        $newProduct = $sourceProduct->replicate();

        $newProduct->market_id = $targetMarketId;
        $newProduct->copy_id = $sourceProduct->id;
        $newProduct->parent_id = $newParentId;

        $newProduct->created_at = now();
        $newProduct->updated_at = now();
        $newProduct->save();
        $market=Market::query()->findOrFail($targetMarketId);

        // цены НЕ копируем
        $this->copyRemains($sourceProduct->id, $newProduct->id, $targetMarketId,$sourceProduct->market_id);
        $this->copySlugs($sourceProduct->id, $newProduct->id);
        $this->copyRelated($sourceProduct->id, $newProduct->id);
        $this->copyBlocks($sourceProduct->id, $newProduct->id);
        $this->copyMedias($sourceProduct->id, $newProduct->id);
        $this->copyPrices($sourceProduct->id, $newProduct->id,$targetMarketId,$market);

        $children = Product::query()
            ->where('parent_id', $sourceProduct->id)
            ->get();

        foreach ($children as $child) {
            $this->copyOneProductToMarket(
                productId: $child->id,
                targetMarketId: $targetMarketId,
                newParentId: $newProduct->id,
                 repository:$repository
            );
        }
       /* if(!$newProduct->published&&$sourceProduct->published){
            $repository->updateBasic($newProduct->id, [
                    'published' => true,
                ]);

        }*/

        $newProduct->save();
        return $newProduct;
    }
    private function copyPrices(int $sourceProductId, int $newProductId, int $targetMarketId,$market): void
    {

        $marketName = $market?->name ?? '';
        $regionName = $market?->city?->province?->geoname_name ?? '';
        $cityName = $market?->city?->city ?? '';
        $sku = \App\Services\CatalogService::generateSku(
            \Str::slug(mb_strtolower($marketName), true),
            $regionName,
            \Str::slug($cityName, true),
            $targetMarketId,
            $newProductId
        );


        ProductPrice::query()
            ->where('product_id', $sourceProductId)->where('market_id', auth()->user()->market_id)
            ->get()
            ->each(function (ProductPrice $price) use ($newProductId, $targetMarketId,$sku) {
                $sku .= '-' . round($price->quantity_from).'-'.$price->id;
                $newPrice = $price->replicate();
                $newPrice->product_id = $newProductId;
                $newPrice->market_id = $targetMarketId;
                $newPrice->created_at = now();
                $newPrice->sku = $sku;
                $newPrice->updated_at = now();
                $newPrice->save();
            });
    }

    public function copyToMarket(int $productId, int $targetMarketId,$repository): ?Product
    {

            return $this->copyOneProductToMarket(
                productId: $productId,
                targetMarketId: $targetMarketId,
                newParentId: null,
                repository:$repository
            );

    }
    private function copyMedias(int $sourceProductId, int $newProductId): void
    {
        $table = config('twill.mediables_table', 'twill_mediables');

        $items = DB::table($table)
            ->where('mediable_id', $sourceProductId)
            ->where('mediable_type', Product::class)
            ->get();

        foreach ($items as $item) {
            DB::table($table)->insert([
                'mediable_id'   => $newProductId,
                'mediable_type' => Product::class,
                'media_id'      => $item->media_id,
                'crop'          => $item->crop,
                'role'          => $item->role,
                'crop_w'        => $item->crop_w,
                'crop_h'        => $item->crop_h,
                'crop_x'        => $item->crop_x,
                'crop_y'        => $item->crop_y,
                'lqip_data'     => $item->lqip_data,
                'ratio'         => $item->ratio,
                'metadatas'     => $item->metadatas,
                'locale'        => $item->locale,
                'position'      => $item->position,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }
    }
    private function copyRelated(int $sourceProductId, int $newProductId): void
    {
        $items = DB::table('related')
            ->where('subject_id', $sourceProductId)
            ->where('subject_type', Product::class)
            ->get();

        foreach ($items as $item) {
            DB::table('related')->insert([
                'subject_id'   => $newProductId,
                'subject_type' => Product::class,
                'related_id'   => $item->related_id,
                'related_type' => $item->related_type,
                'browser_name' => $item->browser_name,
                'position'     => $item->position,

            ]);
        }
    }

    private function copyBlocks(int $sourceProductId, int $newProductId): void
    {
        $blocks = DB::table('blocks')
            ->where('blockable_id', $sourceProductId)
            ->where('blockable_type', Product::class)
            ->get();

        foreach ($blocks as $block) {
            $newBlockId = DB::table('blocks')->insertGetId([
                'blockable_id'   => $newProductId,
                'blockable_type' => Product::class,
                'position'       => $block->position,
                'content'        => $block->content,
                'type'           => $block->type,
                'child_key'      => $block->child_key,
                'parent_id'      => null,

            ]);

            DB::table('blocks')
                ->where('parent_id', $block->id)
                ->get()
                ->each(function ($child) use ($newBlockId, $newProductId) {
                    DB::table('blocks')->insert([
                        'blockable_id'   => $newProductId,
                        'blockable_type' => Product::class,
                        'position'       => $child->position,
                        'content'        => $child->content,
                        'type'           => $child->type,
                        'child_key'      => $child->child_key,
                        'parent_id'      => $newBlockId,

                    ]);
                });
        }
    }

    /**
     * Копировать несколько товаров в несколько магазинов.
     */

    public function copyProductsToMarkets(array $productIds, array $marketIds,$repository): array
    {
        $result = [
            'created' => [],
            'skipped' => [],
        ];

        foreach ($productIds as $productId) {
            foreach ($marketIds as $marketId) {
                $newProduct = $this->copyToMarket((int) $productId, (int) $marketId,$repository);

                if ($newProduct) {

                    $sourceProduct = Product::find($productId);
                    $market = Market::find($marketId);

                    $result['created'][] = [
                        'source_product_id' => (int) $productId,
                        'source_product_title' => $sourceProduct?->title,

                        'new_product_id' => $newProduct->id,
                        'new_product_title' => $newProduct->title,

                        'market_id' => (int) $marketId,
                        'market_title' => $market?->title ?? $market?->name,
                    ];

                } else {

                    $sourceProduct = Product::find($productId);
                    $market = Market::find($marketId);

                    $result['skipped'][] = [
                        'source_product_id' => (int) $productId,
                        'source_product_title' => $sourceProduct?->title,

                        'market_id' => (int) $marketId,
                        'market_title' => $market?->title ?? $market?->name,

                        'reason' => 'same_market_or_already_exists',
                    ];
                }
            }
        }

        return $result;
    }


    /*private function copyPrices(int $sourceProductId, int $newProductId, int $targetMarketId,$market): void
    {

        $marketName = $market?->name ?? '';
        $regionName = $market?->city?->province?->geoname_name ?? '';
        $cityName = $market?->city?->city ?? '';
        $sku = \App\Services\CatalogService::generateSku(
            \Str::slug(mb_strtolower($marketName), true),
            $regionName,
            \Str::slug($cityName, true),
            $targetMarketId,
            $newProductId
        );


        ProductPrice::query()
            ->where('product_id', $sourceProductId)->where('market_id', auth()->user()->market_id)
            ->get()
            ->each(function (ProductPrice $price) use ($newProductId, $targetMarketId,$sku) {
                $sku .= '-' . round($price->quantity_from).'-'.$price->id;
                $newPrice = $price->replicate();
                $newPrice->product_id = $newProductId;
                $newPrice->market_id = $targetMarketId;
                $newPrice->created_at = now();
                $newPrice->sku = $sku;
                $newPrice->updated_at = now();
                $newPrice->save();
            });
    }*/

    private function copyRemains(int $sourceProductId, int $newProductId, int $targetMarketId,$sourceMarket): void
    {
        Remain::query()
            ->where('product_id', $sourceProductId)->where('market_id', $sourceMarket)
            ->get()
            ->each(function (Remain $remain) use ($newProductId, $targetMarketId) {
                $newRemain = $remain->replicate();
                $newRemain->product_id = $newProductId;
                $newRemain->market_id = $targetMarketId;
                $newRemain->created_at = now();
                $newRemain->updated_at = now();
                $newRemain->save();
            });
    }

    private function copySlugs(int $sourceProductId, int $newProductId): void
    {
        $slugs = DB::table('product_slugs')
            ->where('product_id', $sourceProductId)
            ->get();

        foreach ($slugs as $slug) {
            DB::table('product_slugs')->insert([
                'product_id' => $newProductId,
                'deleted_at' => $slug->deleted_at,
                'created_at' => now(),
                'updated_at' => now(),
                'slug' => $slug->slug . '-' . $newProductId,
                'locale' => $slug->locale,
                'active' => $slug->active,
            ]);
        }
    }
}
