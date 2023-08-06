<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonthlyAnalyticsTable extends Migration
{
    public function up()
    {
        Schema::create('monthly_analytics', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('month')->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('monthly_analytics');
    }
}
