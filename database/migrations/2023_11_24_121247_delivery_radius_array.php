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
            $table->json('deliveries_radius')->nullable();
            $table->decimal('price_i_dont_know_address')->nullable();
            $table->string('telegram_bot_market_username')->nullable();
        });

        Schema::create('telegram_chat_users', function (Blueprint $table) {

            // feel free to modify the name of this column, but title is supported by default (you would need to specify the name of the column Twill should consider as your "title" column in your module controller if you change it)
            $table->string('username', 100);

            // your generated model and form include a description field, to get you started, but feel free to get rid of it if you don't need it
            $table->string('chat_id', 100);

            $table->string('bot', 50);

            $table->primary(['username', 'chat_id', 'bot']);
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
            $table->dropColumn('deliveries_radius');
            $table->dropColumn('price_i_dont_know_address');
            $table->dropColumn('telegram_bot_market_username');
        });

        Schema::dropIfExists('telegram_chat_users');
    }
};
