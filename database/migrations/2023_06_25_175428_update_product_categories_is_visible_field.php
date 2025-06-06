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
        Schema::table('categories', function (Blueprint $table) {
            $table->boolean('is_visible')->default(false)->comment('Категория товаров доступна для выбора в букетах, но невидима покупателю');
            $table->boolean('is_visible_menu')->default(false)->comment('Показывает элементы в меню');
            $table->boolean('is_additional_product')->default(false)->comment('Товар можно положить в корзину без букета');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('is_visible');
            $table->dropColumn('is_visible_menu');
        });
    }
};
