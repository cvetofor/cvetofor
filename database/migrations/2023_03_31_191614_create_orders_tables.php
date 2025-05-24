<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTables extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            // this will create an id, a "published" column, and soft delete and timestamps columns
            createDefaultTableFields($table, true, false);

            $table->boolean('published')->default(true);
            $table->bigInteger('market_id')->unsigned()->index()->nullable();
            $table->foreign('market_id')->references('id')->on('markets')->onDelete('set null');

            $table->bigInteger('payment_id')->unsigned()->index();
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('set null');

            $table->bigInteger('user_id')->unsigned()->index()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');

            $table->bigInteger('city_id')->unsigned()->index()->nullable();
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('set null');

            $table->bigInteger('payment_status_id')->unsigned()->index()->nullable();
            $table->foreign('payment_status_id')->references('id')->on('payment_statuses')->onDelete('set null');

            $table->bigInteger('delivery_status_id')->unsigned()->index()->nullable();
            $table->foreign('delivery_status_id')->references('id')->on('delivery_statuses')->onDelete('set null');

            $table->bigInteger('order_status_id')->unsigned()->index()->nullable();
            $table->foreign('order_status_id')->references('id')->on('order_statuses')->onDelete('set null');

            $table->uuid('uuid')->unique();
            $table->string('email', 300)->nullable();
            $table->string('phone', 300)->nullable();
            $table->json('address')->nullable();
            $table->string('comment', 1000)->nullable();
            $table->string('market_comment', 1000)->nullable();
            $table->boolean('is_photo_needle')->default(false); //
            $table->boolean('is_anon')->defalt(false)->nullable(); //
            $table->dateTime('delivery_date')->nullable(); // #
            $table->string('delivery_time', 100)->nullable(); // #
            $table->decimal('total_price')->nullable();
            $table->text('postcard_text')->nullable();
            $table->boolean('is_policy_accepted')->nullable();
            $table->string('person_receiving_name', 100)->nullable(); //
            $table->string('person_receiving_phone', 50)->nullable(); //
            $table->string('payment_link', 1000)->nullable(); //
            $table->json('cart')->nullable();
            $table->nestedSet();
        });

        Schema::create('order_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'order');
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_revisions');
        Schema::dropIfExists('orders');
    }
}
