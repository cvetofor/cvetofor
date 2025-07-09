<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ChangeAccessibilityOnGroupProducts implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $product;

    public $marketId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Product $product, $marketId) {
        $this->product = $product;
        $this->marketId = $marketId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        \App\Repositories\ProductRepository::changeAccessibilityOnGroupProducts($this->product, $this->marketId);
    }
}
