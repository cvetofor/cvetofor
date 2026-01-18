<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDateIntervalsTable extends Migration
{
    public function up()
    {
        Schema::create('date_intervals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('market_id');
            $table->unsignedInteger('start_time');
            $table->unsignedInteger('name_date_interval_id');
            $table->date('date');
            $table->unsignedInteger('end_time');
            $table->unsignedInteger('close_time');
            $table->enum('close_time_behavior', ['before', 'after'])->default('after');
            $table->timestamps();

            $table->foreign('market_id')->references('id')->on('markets')->onDelete('cascade');
            $table->index('market_id');
            $table->unique(['market_id', 'start_time', 'end_time','date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('date_intervals');
    }
}
