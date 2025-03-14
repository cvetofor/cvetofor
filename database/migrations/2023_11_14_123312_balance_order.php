<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('balances', function (Blueprint $table) {
            if (Schema::hasColumn('balances', 'order_id')) {
                $table->dropColumn('order_id');
            }

            $table->bigInteger('market_id')->unsigned()->index()->nullable();
            $table->foreign('market_id')->references('id')->on('markets');
        });

        Schema::create('balance_order', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('order_id')->unsigned()->index()->nullable();
            $table->foreign('order_id')->references('id')->on('orders');

            $table->bigInteger('balance_id')->unsigned()->index()->nullable();
            $table->foreign('balance_id')->references('id')->on('balances');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('balance_order');

    }
};
