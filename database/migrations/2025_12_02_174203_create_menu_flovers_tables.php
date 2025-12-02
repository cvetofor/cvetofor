<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('menu_flovers', function (Blueprint $table) {
            // this will create an id, a "published" column, and soft delete and timestamps columns
            createDefaultTableFields($table);
            $table->string('title')->nullable();
            $table->integer('sort')->nullable() ;

        });

    }

    public function down()
    {

        Schema::dropIfExists('menu_flovers');
    }
};
