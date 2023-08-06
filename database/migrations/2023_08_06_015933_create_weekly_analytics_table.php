<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeeklyAnalyticsTable extends Migration
{
    public function up()
    {
        Schema::create('weekly_analytics', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('week_of_year')->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('weekly_analytics');
    }
}
