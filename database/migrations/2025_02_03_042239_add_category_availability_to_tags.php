<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoryAvailabilityToTags extends Migration
{
    public function up()
    {
        Schema::table('tags', function (Blueprint $table) {
            $table->boolean('is_category_limited')->default(false)->after('name'); // Флаг ограничения
            $table->date('limit_start_date')->nullable()->after('is_category_limited'); // Дата начала ограничения
            $table->date('limit_end_date')->nullable()->after('limit_start_date'); // Дата окончания ограничения
        });
    }

    public function down()
    {
        Schema::table('tags', function (Blueprint $table) {
            $table->dropColumn(['is_category_limited', 'limit_start_date', 'limit_end_date']);
        });
    }
}
