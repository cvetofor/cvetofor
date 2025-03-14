<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {

        Schema::table(config('twill.files_table', 'files'), function (Blueprint $table) {
            $table->bigInteger('market_id')->nullable();
        });
    }



    public function down()
    {
        Schema::table(config('twill.files_table', 'files'), function (Blueprint $table) {
            $table->dropColumn('market_id');
        });
    }
};
