<?php

namespace App\Services;

use A17\Twill\Models\Block;
use App\Models\Color;
use App\Models\GroupProduct;
use App\Models\Market;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\Remain;
use Illuminate\Support\Facades\DB;

class GroupProductCopyService
{
    private function copyOneProductToMarket(
        int  $productId,
        int  $targetMarketId,
        ?int $newParentId = null
    )
    {
        $sourceProduct = GroupProduct::query()->findOrFail($productId);

        if ((int)$sourceProduct->market_id === (int)$targetMarketId) {
            return null;
        }

           $exists = GroupProduct::query()
              ->where('market_id', $targetMarketId)
              ->where('copy_id', $sourceProduct->id)
              ->first();

          if ($exists) {
              return null;
          }

        $newProduct = $sourceProduct->replicate();

        $newProduct->market_id = $targetMarketId;
        $newProduct->copy_id = $sourceProduct->id;


        $newProduct->created_at = now();
        $newProduct->updated_at = now();
        $newProduct->save();

        $market=Market::query()->findOrFail($targetMarketId);
        $this->copyRemains($sourceProduct->id, $newProduct->id, $targetMarketId);
        $this->copySlugs($sourceProduct->id, $newProduct->id);
        $this->copyRelated($sourceProduct->id, $newProduct->id);
        $this->copyBlocks($sourceProduct->id, $newProduct->id, $targetMarketId);
        $this->copyMedias($sourceProduct->id, $newProduct->id);
        $this->copyPrices($sourceProduct->id, $newProduct->id,$targetMarketId,$market);


        return $newProduct;
    }

    public function copyToMarket(int $productId, int $targetMarketId)
    {

        return $this->copyOneProductToMarket(
            productId: $productId,
            targetMarketId: $targetMarketId,
            newParentId: null
        );

    }

    private function copyMedias(int $sourceProductId, int $newProductId): void
    {
        $table = config('twill.mediables_table', 'twill_mediables');

        $items = DB::table($table)
            ->where('mediable_id', $sourceProductId)
            ->where('mediable_type', GroupProduct::class)
            ->get();

        foreach ($items as $item) {
            DB::table($table)->insert([
                'mediable_id' => $newProductId,
                'mediable_type' => GroupProduct::class,
                'media_id' => $item->media_id,
                'crop' => $item->crop,
                'role' => $item->role,
                'crop_w' => $item->crop_w,
                'crop_h' => $item->crop_h,
                'crop_x' => $item->crop_x,
                'crop_y' => $item->crop_y,
                'lqip_data' => $item->lqip_data,
                'ratio' => $item->ratio,
                'metadatas' => $item->metadatas,
                'locale' => $item->locale,
                'position' => $item->position,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function copyRelated(int $sourceProductId, int $newProductId): void
    {
        $items = DB::table('related')
            ->where('subject_id', $sourceProductId)
            ->where('subject_type', GroupProduct::class)
            ->get();

        foreach ($items as $item) {
            DB::table('related')->insert([
                'subject_id' => $newProductId,
                'subject_type' => GroupProduct::class,
                'related_id' => $item->related_id,
                'related_type' => $item->related_type,
                'browser_name' => $item->browser_name,
                'position' => $item->position,

            ]);
        }
    }

    private function copyBlocks(int $sourceProductId, int $newProductId, $targetMarketId): void
    {
        $blocks = Block::
        where('blockable_id', $sourceProductId)
            ->where('blockable_type', GroupProduct::class)
            ->get();

        $products_ids=[];
        $colors_ids=[];
        foreach ($blocks as $block) {

            if ($block->type == 'products') {
                $datacontent = $block->content;
                if (isset($datacontent['browsers']['products'])) {
                    $products = [];
                    foreach ($datacontent['browsers']['products'] as $productId) {
                        $checkProduct = Product::where('copy_id', $productId)->where('market_id', $targetMarketId)->first();

                        if ($checkProduct) {
                            $products[] = $checkProduct->id;
                            $products_ids[$checkProduct->id] =1 ;
                        } else {
                            $prodCopy = new ProductCopyService();
                            $res = $prodCopy->copyOneProductToMarket($productId, $targetMarketId);
                            $products[] =$res->id;
                            $products_ids[$res->id] =1;
                        }

                    }

                    $datacontent['browsers']['products']=$products;
                }
                foreach ($datacontent['browsers']['colors']??[] as $color) {
                    $colors_ids[$color] =1 ;
                }

                //

                $newBlock = $block->replicate();
                $newBlock->blockable_id = $newProductId;
                $newBlock->content = $datacontent;
                $newBlock->save();




            } else {
                $newBlock = $block->replicate();
                $newBlock->blockable_id = $newProductId;
                $newBlock->content = $block->content;
                $newBlock->save();
            }


$i=1;
            foreach (array_keys($products_ids) as $id) {
                $rel=DB::table('related')->where('subject_id', $newProductId)->where('browser_name', 'products')->where('related_id', $id)->first();
                if(!$rel) {
                    DB::table('related')->insert([
                        'subject_id' => $newProductId,
                        'subject_type' =>'blocks',
                        'related_id' => $id,
                        'related_type' =>Product::class,
                        'browser_name' => 'products',
                        'position' => $i,

                    ]);
                    $i++;
                }
            }
            foreach (array_keys($colors_ids) as $id) {
                $rel=DB::table('related')->where('subject_id', $newProductId)->where('browser_name', 'colors')->where('related_id', $id)->first();
                if(!$rel) {
                    DB::table('related')->insert([
                        'subject_id' => $newProductId,
                        'subject_type' =>'blocks',
                        'related_id' => $id,
                        'related_type' =>Color::class,
                        'browser_name' => 'colors',
                        'position' => $i,

                    ]);
                    $i++;
                }
            }



        }
    }

    /**
     * Копировать несколько товаров в несколько магазинов.
     */



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
            ->where('group_product_id', $sourceProductId)->where('market_id', auth()->user()->market_id)
            ->get()
            ->each(function (ProductPrice $price) use ($newProductId, $targetMarketId,$sku) {
                $sku .= '-' . round($price->quantity_from).'-'.$price->id;
                $newPrice = $price->replicate();
                $newPrice->group_product_id = $newProductId;
                $newPrice->market_id = $targetMarketId;
                $newPrice->created_at = now();
                $newPrice->sku = $sku;
                $newPrice->updated_at = now();
                $newPrice->save();
            });
    }

    private function copyRemains(int $sourceProductId, int $newProductId, int $targetMarketId): void
    {
        Remain::query()
            ->where('group_product_id', $sourceProductId)
            ->get()
            ->each(function (Remain $remain) use ($newProductId, $targetMarketId) {
                $newRemain = $remain->replicate();
                $newRemain->group_product_id = $newProductId;
                $newRemain->market_id = $targetMarketId;
                $newRemain->created_at = now();
                $newRemain->updated_at = now();
                $newRemain->save();
            });
    }

    private function copySlugs(int $sourceProductId, int $newProductId): void
    {
        $slugs = DB::table('group_product_slugs')
            ->where('group_product_id', $sourceProductId)
            ->get();

        foreach ($slugs as $slug) {
            DB::table('group_product_slugs')->insert([
                'group_product_id' => $newProductId,
                'deleted_at' => $slug->deleted_at,
                'created_at' => now(),
                'updated_at' => now(),
                'slug' => $slug->slug . '-' . $newProductId,
                'locale' => $slug->locale,
                'active' => $slug->active,
            ]);
        }
    }
    public function copyProductsToMarkets(array $productIds, array $marketIds): array
    {
        $result = [
            'created' => [],
            'skipped' => [],
        ];

        foreach ($productIds as $productId) {
            foreach ($marketIds as $marketId) {
                $newProduct = $this->copyToMarket((int)$productId, (int)$marketId);

                if ($newProduct) {

                    $sourceProduct = GroupProduct::find($productId);
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

                    $sourceProduct = GroupProduct::find($productId);
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

}
