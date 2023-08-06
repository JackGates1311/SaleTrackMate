<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoice_analytics_data_goods_or_services', function (Blueprint $table) {
            $table->id();
            $table->uuid('invoice_analytics_data_id');
            $table->uuid('goods_or_services_id');

            $table->foreign('invoice_analytics_data_id')->references('id')->on('invoice_analytics_data')->onDelete('cascade');
            $table->foreign('goods_or_services_id')->references('id')->on('goods_or_services')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_analytics_data_goods_or_services');
    }
};
