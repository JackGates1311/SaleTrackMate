<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFiscalYearsTable extends Migration
{
    public function up()
    {
        Schema::create('fiscal_years', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('year');
            $table->boolean('is_closed')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fiscal_years');
    }
}
