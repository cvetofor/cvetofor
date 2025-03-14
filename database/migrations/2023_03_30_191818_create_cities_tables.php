<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTables extends Migration
{
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            // this will create an id, a "published" column, and soft delete and timestamps columns
            createDefaultTableFields($table);

            $table->integer('position')->unsigned()->nullable();

            $table->string('address', 1000)->nullable();
            $table->string('postal_code', 1000)->nullable();
            $table->string('country', 1000)->nullable();
            $table->string('federal_district', 1000)->nullable();
            $table->string('region_type', 1000)->nullable();
            $table->string('region', 1000)->nullable();
            $table->string('area_type', 1000)->nullable();
            $table->string('area', 1000)->nullable();
            $table->string('city_type', 1000)->nullable();
            $table->string('city', 1000)->nullable();
            $table->string('settlement_type', 1000)->nullable();
            $table->string('settlement', 1000)->nullable();
            $table->string('kladr_id', 1000)->nullable();
            $table->string('fias_id', 1000)->nullable();
            $table->string('fias_level', 1000)->nullable();
            $table->string('capital_marker', 1000)->nullable();
            $table->string('okato', 1000)->nullable();
            $table->string('oktmo', 1000)->nullable();
            $table->string('tax_office', 1000)->nullable();
            $table->string('timezone', 1000)->nullable();
            $table->string('geo_lat', 1000)->nullable();
            $table->string('geo_lon', 1000)->nullable();
            $table->string('population', 1000)->nullable();
            $table->string('foundation_year', 1000)->nullable();

            $table->bigInteger('region_id')->unsigned()->nullable();
            $table->foreign('region_id')->references('id')->on('regions');

            // add those 2 columns to enable publication timeframe fields (you can use publish_start_date only if you don't need to provide the ability to specify an end date)
            // $table->timestamp('publish_start_date')->nullable();
            // $table->timestamp('publish_end_date')->nullable();
        });

        Schema::create('city_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'city');
        });
    }

    public function down()
    {
        Schema::dropIfExists('city_slugs');
        Schema::dropIfExists('cities');
    }
}
