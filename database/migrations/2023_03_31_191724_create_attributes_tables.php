<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributesTables extends Migration
{
    public function up()
    {
        Schema::create('attributes', function (Blueprint $table) {
            // this will create an id, a "published" column, and soft delete and timestamps columns
            createDefaultTableFields($table);

            $table->text('label')->nullable();
            $table->boolean('is_variable')->default(false)->comment("Показатель вариативности продукта");
            $table->dateTime('variable_generated_at')->nullable()->comment("Дата генерации вариативного товара");

            $table->bigInteger('product_id')->index()->unsigned()->nullable();
            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('attributes');
    }
}
