<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceItemsTable extends Migration
{
    public function up()
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('unit');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('quantity', 10, 2);
            $table->decimal('base_amount', 10, 2);
            $table->decimal('rebate', 10, 2);
            $table->decimal('vat_price', 10, 2);
            $table->decimal('vat_percentage', 5, 2);
            $table->decimal('total_price', 10, 2);
            $table->string('image_url')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('invoice_items');
    }
}
