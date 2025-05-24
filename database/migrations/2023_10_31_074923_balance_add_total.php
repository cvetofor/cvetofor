<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('balances', function (Blueprint $table) {
            $table->decimal('total')->nullable();

            $table->string('status', 50)->nullable();

            $table->bigInteger('order_id')->unsigned()->index()->nullable();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('set null');
        });

        Schema::table('markets', function (Blueprint $table) {
            $table->decimal('balance')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('balances', function (Blueprint $table) {
            $table->dropColumn('total');
            $table->dropColumn('status');

            if (Schema::hasColumn('balances', 'order_id')) {
                $table->dropColumn('order_id');
            }
        });

        Schema::table('markets', function (Blueprint $table) {
            $table->dropColumn('balance');
        });
    }
};
