<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreIntervalsTable extends Migration
{
    public function up()
    {
        Schema::create('store_intervals', function (Blueprint $table) {


            $table->integer('store_id')->nullable();
            $table->time('time_start')->nullable();
            $table->time('time_end')->nullable();


            createDefaultTableFields($table);


        });
    }

    public function down()
    {
        Schema::dropIfExists('stores');
    }
}
