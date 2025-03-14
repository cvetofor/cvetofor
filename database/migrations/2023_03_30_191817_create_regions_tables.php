<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegionsTables extends Migration
{
    public function up()
    {
        Schema::create('regions', function (Blueprint $table) {
            // this will create an id, a "published" column, and soft delete and timestamps columns
            createDefaultTableFields($table);

            $table->integer('position')->unsigned()->nullable();

            $table->string('name', 1000)->nullable();
            $table->string('type', 1000)->nullable();
            $table->string('name_with_type', 1000)->nullable();
            $table->string('federal_district', 1000)->nullable();
            $table->string('kladr_id', 1000)->nullable();
            $table->string('fias_id', 1000)->nullable();
            $table->string('okato', 1000)->nullable();
            $table->string('oktmo', 1000)->nullable();
            $table->string('tax_office', 1000)->nullable();
            $table->string('postal_code', 1000)->nullable();
            $table->string('iso_code', 1000)->nullable();
            $table->string('timezone', 1000)->nullable();
            $table->string('geoname_code', 1000)->nullable();
            $table->string('geoname_id', 1000)->nullable();
            $table->string('geoname_name', 1000)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('regions');
    }
}
