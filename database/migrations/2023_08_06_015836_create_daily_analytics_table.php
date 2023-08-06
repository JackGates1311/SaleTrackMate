<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyAnalyticsTable extends Migration
{
    public function up()
    {
        Schema::create('daily_analytics', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->date('date')->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('daily_analytics');
    }
}
