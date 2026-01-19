<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('menu_prices', function (Blueprint $table) {
            // this will create an id, a "published" column, and soft delete and timestamps columns
            createDefaultTableFields($table);
            $table->integer('price_start')->nullable();
            $table->integer('price_end')->nullable();
            $table->integer('sort')->nullable() ;

        });

    }

    public function down()
    {

        Schema::dropIfExists('menu_prices');
    }
};
