<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTables extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            // this will create an id, a "published" column, and soft delete and timestamps columns
            createDefaultTableFields($table);

            // feel free to modify the name of this column, but title is supported by default (you would need to specify the name of the column Twill should consider as your "title" column in your module controller if you change it)
            $table->string('title', 200)->nullable();

            // your generated model and form include a description field, to get you started, but feel free to get rid of it if you don't need it
            $table->text('description')->nullable();


            $table->bigInteger('market_id')->index()->unsigned()->nullable();
            $table->foreign('market_id')->references('id')->on('markets')->onDelete('set null');

            $table->bigInteger('category_id')->index()->unsigned()->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');

            $table->timestamp('verified_at')->nullable();

            $table->boolean('is_market_public')->default(false);


            // Для торговых предложений
            $table->nestedSet();

            // add those 2 columns to enable publication timeframe fields (you can use publish_start_date only if you don't need to provide the ability to specify an end date)
            // $table->timestamp('publish_start_date')->nullable();
            // $table->timestamp('publish_end_date')->nullable();
        });

        Schema::create('product_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'product');
        });

        Schema::create('product_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'product');
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_revisions');
        Schema::dropIfExists('product_slugs');
        Schema::dropIfExists('products');
    }
}
