<?php

use Doctrine\DBAL\Schema\Index;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketsTables extends Migration
{
    public function up()
    {
        Schema::create('markets', function (Blueprint $table) {
            // this will create an id, a "published" column, and soft delete and timestamps columns
            createDefaultTableFields($table);


            $table->string('name', 1000)->nullable()->comment('Название магазина');
            $table->bigInteger('user_id')->nullable()->index()->unsigned()->comment();
            $table->bigInteger('market_work_times_id')->nullable()->index()->unsigned()->comment();
            $table->bigInteger('market_delivery_times_id')->nullable()->index()->unsigned()->comment();
            $table->bigInteger('city_id')->nullable()->index()->unsigned()->comment();

            $table->string('address', 1000)->nullable()->comment('Адрес');
            $table->string('phone', 1000)->nullable()->comment();
            $table->string('email', 1000)->nullable()->comment();
            $table->string('order_prepaid', 1000)->nullable()->comment();
            $table->string('card', 1000)->nullable()->comment();
            $table->string('card_holder_fio', 1000)->nullable()->comment();



            $table->string('delivery_time_order_interval',5)->nullable()->comment();
            $table->string('delivery_min_time',5)->nullable()->comment();
            $table->decimal('delivery_normal_price')->nullable()->comment();
            $table->decimal('delivery_night_price')->nullable()->comment();
            $table->decimal('free_delivery_price_order')->nullable()->comment();
            $table->decimal('delivery_radius')->nullable()->comment();
            $table->decimal('delivery_out_town_km_price')->nullable()->comment();
            $table->decimal('additional_service_photo_price')->nullable()->comment();
            $table->decimal('additional_service_hot_delivery_price')->nullable()->comment();
            $table->decimal('additional_service_to_current_time_price')->nullable()->comment();
            $table->decimal('holidays_percent')->nullable()->comment();
            $table->decimal('holidays_delivery_price')->nullable()->comment();
            $table->decimal('holidays_radius')->nullable()->comment();
            $table->decimal('holidays_out_town_km_price')->nullable()->comment();




            // add those 2 columns to enable publication timeframe fields (you can use publish_start_date only if you don't need to provide the ability to specify an end date)
            $table->timestamp('publish_start_date')->nullable();
            $table->timestamp('publish_end_date')->nullable();
        });

        Schema::create('market_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'market');
        });
    }

    public function down()
    {
        Schema::dropIfExists('market_revisions');
        Schema::dropIfExists('markets');
    }
}
