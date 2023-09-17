<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_num');
            $table->date('invoice_date');
            $table->string('invoice_location');
            $table->dateTime('due_date');
            $table->string('due_location');
            $table->dateTime('delivery_date');
            $table->string('delivery_location');
            $table->string('payment_method');
            $table->dateTime('payment_deadline');
            $table->string('fiscal_receipt_num');
            $table->decimal('total_base_amount', 10);
            $table->decimal('total_price', 10);
            $table->decimal('total_vat', 10);
            $table->decimal('total_rebate', 10);
            $table->string('status');
            $table->string('type');
            $table->timestamps();
        });
    }

    function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
