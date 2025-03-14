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
        Schema::table('seotags', function (Blueprint $table) {
            if (!Schema::hasColumn('seotags', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('seotags', function (Blueprint $table) {
            // this will create an id, a "published" column, and soft delete and timestamps columns
            $table->dropSoftDeletes();
        });
    }
};
