<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('invoice_analytics_data_recipients', function (Blueprint $table) {
            $table->id();
            $table->uuid('invoice_analytics_data_id');
            $table->uuid('recipient_id');

            $table->foreign('invoice_analytics_data_id')->references('id')->on('invoice_analytics_data')->onDelete('cascade');
            $table->foreign('recipient_id')->references('id')->on('recipients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_analytics_data_recipients');
    }
};
