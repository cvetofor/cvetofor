<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('promocod_lists', function (Blueprint $table) {
            // this will create an id, a "published" column, and soft delete and timestamps columns
            createDefaultTableFields($table);

            $table->string('code')->nullable()->index();
            $table->integer('promocod_id')->nullable();

        });






    }

    public function down()
    {

        Schema::dropIfExists('promocod_lists');
    }
};
