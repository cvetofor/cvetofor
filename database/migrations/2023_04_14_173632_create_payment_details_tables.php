<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentDetailsTables extends Migration
{
    public function up()
    {
        Schema::create('payment_details', function (Blueprint $table) {
            // this will create an id, a "published" column, and soft delete and timestamps columns
            createDefaultTableFields($table);

            // feel free to modify the name of this column, but title is supported by default (you would need to specify the name of the column Twill should consider as your "title" column in your module controller if you change it)
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('twill_users')->cascadeOnDelete();

            $table->boolean('approved')->default(false);

            $table->string('fio', 300)->nullable();
            $table->string('legal_address', 300)->nullable();
            $table->string('postal_address', 1000)->nullable();
            $table->string('inn', 50)->nullable();
            $table->string('kpp', 50)->nullable();
            $table->string('ogrn', 50)->nullable();
            $table->string('bank_fullname', 1000)->nullable();
            $table->string('payment_account', 300)->nullable();
            $table->string('correspondent_account', 300)->nullable();
            $table->string('bik', 300)->nullable();

            // add those 2 columns to enable publication timeframe fields (you can use publish_start_date only if you don't need to provide the ability to specify an end date)
            $table->timestamp('publish_start_date')->nullable();
            $table->timestamp('publish_end_date')->nullable();
        });

        Schema::create('payment_detail_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'payment_detail');
        });
    }

    public function down()
    {
        Schema::dropIfExists('payment_detail_revisions');
        Schema::dropIfExists('payment_details');
    }
}
