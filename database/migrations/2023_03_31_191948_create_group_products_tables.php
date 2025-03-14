<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupProductsTables extends Migration
{
    public function up()
    {
        Schema::create('group_products', function (Blueprint $table) {
            // this will create an id, a "published" column, and soft delete and timestamps columns
            createDefaultTableFields($table);

            $table->string('title', 300)->nullable();

            $table->bigInteger('category_id')->unsigned()->index()->nullable();
            $table->foreign('category_id')->references('id')->on('group_product_categories')->cascadeOnDelete();

            $table->bigInteger('created_by_market_id')->unsigned()->index()->nullable();
            $table->foreign('created_by_market_id')->references('id')->on('markets');

            $table->boolean('is_public')->default(false);

            $table->text('description')->nullable();

            // add those 2 columns to enable publication timeframe fields (you can use publish_start_date only if you don't need to provide the ability to specify an end date)
            // $table->timestamp('publish_start_date')->nullable();
            // $table->timestamp('publish_end_date')->nullable();
        });

        Schema::create('group_product_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'group_product');
        });

        Schema::create('group_product_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'group_product');
        });
    }

    public function down()
    {
        Schema::dropIfExists('group_product_revisions');
        Schema::dropIfExists('group_product_slugs');
        Schema::dropIfExists('group_products');
    }
}
