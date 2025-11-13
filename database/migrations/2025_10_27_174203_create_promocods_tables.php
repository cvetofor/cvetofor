<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('promocods', function (Blueprint $table) {
            // this will create an id, a "published" column, and soft delete and timestamps columns
            createDefaultTableFields($table);
            $table->string('title')->nullable();
            $table->string('code')->nullable()->index();
            $table->integer('type_sale')->nullable();
            $table->double('sale')->nullable() ;
            $table->string('platform')->nullable();
            $table->date('date_start')->nullable();
            $table->date('date_end')->nullable();
            $table->integer('total_limit')->nullable();
            $table->integer('client_limit')->nullable();
            $table->integer('minimal_sum_cart')->nullable();
            $table->integer('type_max_sale')->nullable();
            $table->integer('sum_max_sale')->nullable();
            $table->string('type_order')->nullable();
            $table->integer('show_in_order')->nullable();
            $table->longtext('products')->nullable();
            $table->longtext('categories')->nullable();
            $table->longtext('tags')->nullable();
        });






    }

    public function down()
    {

        Schema::dropIfExists('promocods');
    }
};
