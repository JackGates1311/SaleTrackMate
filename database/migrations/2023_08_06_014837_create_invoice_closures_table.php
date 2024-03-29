<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceClosuresTable extends Migration
{
    public function up()
    {
        Schema::create('invoice_closures', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->dateTime('closure_date')->nullable();
            $table->decimal('closure_amount')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('invoice_closures');
    }
}
