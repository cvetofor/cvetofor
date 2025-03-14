<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTables extends Migration
{
    public function up()
    {
        Schema::table('tags', function (Blueprint $table) {
            // this will create an id, a "published" column, and soft delete and timestamps columns
            if (!Schema::hasColumn('tags', 'deleted_at')) {
                $table->softDeletes();
            }
            if (!Schema::hasColumn('tags', 'created_at')) {
                $table->timestamps();
            }
        });

    }

    public function down()
    {
        Schema::table('tags', function (Blueprint $table) {
            // this will create an id, a "published" column, and soft delete and timestamps columns
            $table->dropSoftDeletes();
            $table->dropTimestamps();
        });
    }
}
