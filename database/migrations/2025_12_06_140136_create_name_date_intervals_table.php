<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNameDateIntervalsTable extends Migration
{
    public function up()
    {
        Schema::create('name_date_intervals', function (Blueprint $table) {

            $table->integer('market_id')->nullable();

            $table->date('date');


            createDefaultTableFields($table);



        });
    }

    public function down()
    {
        Schema::dropIfExists('name_date_intervals');
    }
}
