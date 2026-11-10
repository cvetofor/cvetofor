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
        Schema::create('design_clicks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('visitor_id')->nullable()->index();
            $table->string('variant_from')->nullable();
            $table->timestamps();
        });

        Schema::create('design_order_stats', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('order_id')->unique();
            $table->string('visitor_id')->nullable()->index();
            $table->string('design');
            $table->string('phone')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('design_order_stats');
        Schema::dropIfExists('design_clicks');
    }
};
