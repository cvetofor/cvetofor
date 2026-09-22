<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {

            $table->integer('market_id')->nullable();
            $table->string('title')->nullable();



            createDefaultTableFields($table);



        });
    }

    public function down()
    {
        Schema::dropIfExists('stores');
    }
}
