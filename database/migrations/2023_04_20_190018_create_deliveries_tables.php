<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveriesTables extends Migration
{
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            // this will create an id, a "published" column, and soft delete and timestamps columns
            createDefaultTableFields($table);

            $table->bigInteger('city_id')->unsigned()->index()->nullable();
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('set null');

            $table->bigInteger('order_id')->unsigned()->index()->nullable();
            $table->foreign('order_id')->references('id')->on('orders')->cascadeOnDelete();

            $table->json('address')->nullable();

            $table->decimal('km');
            $table->decimal('price');


            // add those 2 columns to enable publication timeframe fields (you can use publish_start_date only if you don't need to provide the ability to specify an end date)
            // $table->timestamp('publish_start_date')->nullable();
            // $table->timestamp('publish_end_date')->nullable();
        });

        Schema::create('delivery_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'delivery');
        });
    }

    public function down()
    {
        if (Schema::hasTable('deliveries')) {
            Schema::table('deliveries', function (Blueprint $table) {
                $table->dropForeign(['city_id']);
                $table->dropIndex(['city_id']);
                $table->dropForeign(['order_id']);
                $table->dropIndex(['order_id']);
            });
        }
        Schema::dropIfExists('delivery_revisions');
        Schema::dropIfExists('deliveries');
    }
}
