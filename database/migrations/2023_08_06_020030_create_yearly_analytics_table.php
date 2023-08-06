<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYearlyAnalyticsTable extends Migration
{
    public function up()
    {
        Schema::create('yearly_analytics', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('year')->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('yearly_analytics');
    }
}
