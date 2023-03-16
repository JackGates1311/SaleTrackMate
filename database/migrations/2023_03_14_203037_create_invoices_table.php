<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('issuer_company_id')->references('id')->on('companies')->
                onDelete('cascade');
            $table->foreignUuid('recipient_company_id')->references('id')->
                on('invoice_recipients')->onDelete('cascade');
            $table->string('invoice_num');
            $table->date('invoice_date');
            $table->string('invoice_location');
            $table->date('due_date');
            $table->string('due_location');
            $table->date('delivery_date');
            $table->string('delivery_location');
            $table->string('payment_method');
            $table->date('payment_deadline');
            $table->string('fiscal_receipt_num');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
