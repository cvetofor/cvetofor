<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductPricesTables extends Migration
{
    public function up()
    {
        Schema::create('product_prices', function (Blueprint $table) {
            // this will create an id, a "published" column, and soft delete and timestamps columns
            createDefaultTableFields($table);

            $table->bigInteger('product_id')->index()->unsigned()->nullable();
            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();

            $table->bigInteger('group_product_id')->unsigned()->index()->nullable();
            $table->foreign('group_product_id')->references('id')->on('group_products')->cascadeOnDelete();

            $table->bigInteger('market_id')->index()->unsigned()->nullable();
            $table->foreign('market_id')->references('id')->on('markets')->cascadeOnDelete();

            $table->decimal('price')->nullable();

            $table->decimal('quantity_from')->nullable();

            // add those 2 columns to enable publication timeframe fields (you can use publish_start_date only if you don't need to provide the ability to specify an end date)
            // $table->timestamp('publish_start_date')->nullable();
            // $table->timestamp('publish_end_date')->nullable();
        });

        Schema::create('product_price_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'product_price');
        });
    }

    public function down()
    {
        if (Schema::hasTable('product_prices')) {
            Schema::table('product_prices', function (Blueprint $table) {
                $table->dropIndex(['market_id']);
                $table->dropIndex(['product_id']);
                $table->dropForeign(['market_id']);
                $table->dropForeign(['product_id']);
            });
        }
        Schema::dropIfExists('product_price_revisions');
        Schema::dropIfExists('product_prices');
    }
}
