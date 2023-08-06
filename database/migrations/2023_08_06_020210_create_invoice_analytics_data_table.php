<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceAnalyticsDataTable extends Migration
{
    public function up()
    {
        Schema::create('invoice_analytics_data', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('number_of_invoices');
            $table->decimal('average_invoice_amount', 12, 2);
            // Add other fields as needed

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('invoice_analytics_data');
    }
}
