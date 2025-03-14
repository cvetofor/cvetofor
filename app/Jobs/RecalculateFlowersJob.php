<?php

namespace App\Jobs;

use App\Models\GroupProduct;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Repositories\ProductPriceRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RecalculateFlowersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $productIds;

    public $marketId;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($productIds, $marketId)
    {
        $this->productIds = $productIds;
        $this->marketId = $marketId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $products = Product::whereIn('id', $this->productIds)->get();

        foreach ($products as $product) {
            ProductPriceRepository::recalculate($product, $this->marketId);

            \App\Repositories\ProductRepository::changeAccessibilityOnGroupProducts($product, $this->marketId);
        }
    }
}
