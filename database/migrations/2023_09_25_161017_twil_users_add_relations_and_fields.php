<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $twillUsersTable = config('twill.users_table', 'twill_users');

        if (Schema::hasTable($twillUsersTable)) {
            Schema::table(
                $twillUsersTable,
                function (Blueprint $table) use ($twillUsersTable) {

                    $table->bigInteger("master_user_id")->nullable();
                    $table->foreign('master_user_id')
                        ->references('id')->on($twillUsersTable)->cascadeOnDelete();
                }
            );
        }

        Schema::create(
            'market_user',
            function (Blueprint $table) use ($twillUsersTable) {
                $table
                    ->bigIncrements('id');

                $table
                    ->bigInteger("market_id");

                $table
                    ->foreign('market_id')
                    ->references('id')
                    ->on('markets')
                    ->cascadeOnDelete();

                $table
                    ->bigInteger("user_id");

                $table
                    ->foreign('user_id')
                    ->references('id')
                    ->on($twillUsersTable)
                    ->cascadeOnDelete();
            }
        );


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $twillUsersTable = config('twill.users_table', 'twill_users');

        Schema::table(
            $twillUsersTable,
            function (Blueprint $table) {
                $table->dropColumn("master_user_id");
            }
        );

        Schema::dropIfExists('market_user');
    }
};
