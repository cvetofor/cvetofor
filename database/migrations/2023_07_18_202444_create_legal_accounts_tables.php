<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLegalAccountsTables extends Migration
{
    public function up()
    {
        Schema::create('legal_accounts', function (Blueprint $table) {
            // this will create an id, a "published" column, and soft delete and timestamps columns
            createDefaultTableFields($table, true, false);

            // feel free to modify the name of this column, but title is supported by default (you would need to specify the name of the column Twill should consider as your "title" column in your module controller if you change it)
            $table->string('title', 200)->nullable();
            $table->string('recipient', 500)->nullable();
            $table->string('address', 500)->nullable();
            $table->string('recipient_account', 500)->nullable();
            $table->string('bik', 500)->nullable();
            $table->string('bank', 500)->nullable();
            $table->string('correspondent_account', 500)->nullable();
            $table->string('inn', 500)->nullable();
            $table->string('kpp', 500)->nullable();

            $table->bigInteger('order_id')->unsigned()->index()->nullable();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('set null');

            // add those 2 columns to enable publication timeframe fields (you can use publish_start_date only if you don't need to provide the ability to specify an end date)
            // $table->timestamp('publish_start_date')->nullable();
            // $table->timestamp('publish_end_date')->nullable();
        });
    }

    public function down()
    {

        Schema::dropIfExists('legal_accounts');
    }
}
