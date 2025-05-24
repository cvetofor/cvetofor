<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTables extends Migration
{
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            // this will create an id, a "published" column, and soft delete and timestamps columns
            createDefaultTableFields($table);

            $table->string('title', 200)->nullable();
            $table->string('code', 200);

            $table->integer('quantity')->default(0);
            $table->integer('percent')->nullable();
            $table->decimal('price')->nullable();

            $table->bigInteger('market_id')->index()->unsigned()->nullable();
            $table->foreign('market_id')->references('id')->on('markets')->onDelete('set null');

            $table->unique(['code', 'market_id']);

            // add those 2 columns to enable publication timeframe fields (you can use publish_start_date only if you don't need to provide the ability to specify an end date)
            $table->timestamp('publish_start_date')->nullable();
            $table->timestamp('publish_end_date')->nullable();
        });

        Schema::create('stock_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'stock');
        });
    }

    public function down()
    {
        if (Schema::hasTable('stocks')) {
            Schema::table('stocks', function (Blueprint $table) {
                $table->dropIndex(['market_id']);
                $table->dropForeign(['market_id']);
            });
        }
        Schema::dropIfExists('stock_revisions');
        Schema::dropIfExists('stocks');
    }
}
