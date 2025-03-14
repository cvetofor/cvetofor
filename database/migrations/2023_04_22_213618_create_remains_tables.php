<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRemainsTables extends Migration
{
    public function up()
    {
        Schema::create('remains', function (Blueprint $table) {
            // this will create an id, a "published" column, and soft delete and timestamps columns
            createDefaultTableFields($table);

            $table->bigInteger('product_id')->unsigned()->index()->nullable();
            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();

            $table->bigInteger('group_product_id')->unsigned()->index()->nullable();
            $table->foreign('group_product_id')->references('id')->on('group_products')->cascadeOnDelete();

            $table->bigInteger('market_id')->unsigned()->index()->nullable();
            $table->foreign('market_id')->references('id')->on('markets')->cascadeOnDelete();
            $table->integer('quantity')->default(0);
            $table->integer('position')->default(0);
        });

        Schema::create('remain_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'remain');
        });
    }

    public function down()
    {
        if (Schema::hasTable('remains')) {
            Schema::table('remains', function (Blueprint $table) {
                $table->dropForeign(['market_id']);
                $table->dropIndex(['market_id']);
                $table->dropForeign(['product_id']);
                $table->dropIndex(['product_id']);
            });
        }
        Schema::dropIfExists('remain_revisions');
        Schema::dropIfExists('remains');
    }
}
