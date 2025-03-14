<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTables extends Migration
{
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            // this will create an id, a "published" column, and soft delete and timestamps columns
            createDefaultTableFields($table);

            $table->decimal('price');
            $table->string('title', 200);
            $table->decimal('quantity');

            $table->bigInteger('product_id')->unsigned()->index()->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');

            $table->bigInteger('order_id')->unsigned()->index()->nullable();
            $table->foreign('order_id')->references('id')->on('orders')->cascadeOnDelete();
        });

        Schema::create('order_item_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'order_item');
        });
    }

    public function down()
    {
        if (Schema::hasTable('order_items')) {
            Schema::table('order_items', function (Blueprint $table) {
                $table->dropIndex(['product_id']);
                $table->dropIndex(['order_id']);

                $table->dropForeign(['product_id']);
                $table->dropForeign(['order_id']);
            });
        }
        Schema::dropIfExists('order_item_revisions');
        Schema::dropIfExists('order_item_translations');
        Schema::dropIfExists('order_item_slugs');
        Schema::dropIfExists('order_items');
    }
}
