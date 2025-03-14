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
        Schema::table('markets', function (Blueprint $table) {
            $table->dropColumn('delivery_normal_price');
            $table->dropColumn('free_delivery_price_order');
            $table->dropColumn('delivery_radius');
            $table->dropColumn('holidays_delivery_price');
            $table->dropColumn('holidays_radius');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('markets', function (Blueprint $table) {
            $table->decimal('delivery_normal_price')->nullable()->comment();
            $table->decimal('free_delivery_price_order')->nullable()->comment();
            $table->decimal('delivery_radius')->nullable()->comment();
            $table->decimal('holidays_delivery_price')->nullable()->comment();
            $table->decimal('holidays_radius')->nullable()->comment();
        });
    }
};
