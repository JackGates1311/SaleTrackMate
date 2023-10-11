<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->foreignUuid('company_id')->references('id')->on('companies')
                ->onDelete('cascade');
            $table->foreignUuid('issuer_company_id')->references('id')->on('invoice_issuers')
                ->onDelete('cascade');
            $table->foreignUuid('recipient_company_id')->references('id')->on('invoice_recipients')
                ->onDelete('cascade');
            $table->foreignUuid('fiscal_year_id')->references('id')->on('fiscal_years')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
