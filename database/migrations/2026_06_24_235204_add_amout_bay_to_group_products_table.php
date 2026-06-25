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
        Schema::table('group_products', function (Blueprint $table) {
            $table->integer('limit_bay_rule')->nullable();
            $table->integer('limit_bay_amount')->nullable();
            $table->integer('limit_bay_now')->nullable();

        });
    }
//php artisan migrate:rollback --step=1
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('group_products', function (Blueprint $table) {
            $table->dropColumn('limit_bay_rule');
            $table->dropColumn('limit_bay_amount');
            $table->dropColumn('limit_bay_now');

        });
    }
};
