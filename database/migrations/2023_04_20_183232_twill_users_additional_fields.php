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
        $twillUsersTable = config('twill.users_table', 'twill_users');

        if (Schema::hasTable($twillUsersTable)) {
            Schema::table($twillUsersTable, function (Blueprint $table) {
                $table->string('second_name', 100)->nullable();
                $table->string('last_name', 100)->nullable();
                $table->string('phone', 30)->nullable();
                $table->boolean('send_notify_email')->default(true)->nullable();
                $table->boolean('send_notify_phone')->default(false)->nullable();

                $table->bigInteger('market_id')->index()->unsigned()->nullable();
                $table->foreign('market_id')->references('id')->on('markets');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $twillUsersTable = config('twill.users_table', 'twill_users');

        Schema::table($twillUsersTable, function (Blueprint $table) {
            $table->dropColumn('phone');
            $table->dropColumn('send_notify_email');
            $table->dropColumn('send_notify_phone');
            $table->dropColumn('second_name');
            $table->dropColumn('last_name');
            $table->dropColumn('market_id');
        });
    }
};
