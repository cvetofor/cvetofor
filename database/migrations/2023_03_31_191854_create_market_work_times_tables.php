<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketWorkTimesTables extends Migration
{
    public function up()
    {
        Schema::create('market_work_times', function (Blueprint $table) {
            // this will create an id, a "published" column, and soft delete and timestamps columns
            createDefaultTableFields($table);


            $table->json('times')->nullable()->default('{"monday0900":true,"tuesday0900":true,"wednesday0900":true,"thursday0900":true,"friday0900":true,"saturday0900":true,"sunday0900":true,"monday1000":true,"tuesday1000":true,"wednesday1000":true,"thursday1000":true,"friday1000":true,"saturday1000":true,"sunday1000":true,"monday1100":true,"tuesday1100":true,"wednesday1100":true,"thursday1100":true,"friday1100":true,"saturday1100":true,"sunday1100":true,"monday1200":true,"tuesday1200":true,"wednesday1200":true,"thursday1200":true,"friday1200":true,"saturday1200":true,"sunday1200":true,"monday1300":true,"tuesday1300":true,"wednesday1300":true,"thursday1300":true,"friday1300":true,"saturday1300":true,"sunday1300":true,"monday1400":true,"tuesday1400":true,"wednesday1400":true,"thursday1400":true,"friday1400":true,"saturday1400":true,"sunday1400":true,"monday1500":true,"tuesday1500":true,"wednesday1500":true,"thursday1500":true,"friday1500":true,"saturday1500":true,"sunday1500":true,"monday1600":true,"tuesday1600":true,"wednesday1600":true,"thursday1600":true,"friday1600":true,"saturday1600":true,"sunday1600":true,"monday1700":true,"tuesday1700":true,"wednesday1700":true,"thursday1700":true,"friday1700":true,"saturday1700":true,"sunday1700":true,"monday1800":true,"tuesday1800":true,"wednesday1800":true,"thursday1800":true,"friday1800":true,"saturday1800":true,"sunday1800":true,"monday1900":true,"tuesday1900":true,"wednesday1900":true,"thursday1900":true,"friday1900":true,"saturday1900":true,"sunday1900":true,"monday2000":true,"tuesday2000":true,"wednesday2000":true,"thursday2000":true,"friday2000":true,"saturday2000":true,"sunday2000":true,"monday2100":true,"tuesday2100":true,"wednesday2100":true,"thursday2100":true,"friday2100":true,"saturday2100":true,"sunday2100":true}');

            // add those 2 columns to enable publication timeframe fields (you can use publish_start_date only if you don't need to provide the ability to specify an end date)
            // $table->timestamp('publish_start_date')->nullable();
            // $table->timestamp('publish_end_date')->nullable();
        });

        Schema::create('market_work_time_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'market_work_time');
        });
    }

    public function down()
    {
        Schema::dropIfExists('market_work_time_revisions');
        Schema::dropIfExists('market_work_times');
    }
}
