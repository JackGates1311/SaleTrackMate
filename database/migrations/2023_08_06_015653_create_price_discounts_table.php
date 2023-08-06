<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePriceDiscountsTable extends Migration
{
    public function up()
    {
        Schema::create('price_discounts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->decimal('percentage', 5, 2);
            $table->dateTime('from_date');
            $table->dateTime('due_date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('price_discounts');
    }
}
