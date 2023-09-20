<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('invoice_items', function (Blueprint $table) {
            $table->foreignUuid('invoice_id')->references('id')->on('invoices')
                ->onDelete('cascade');

            $table->foreignUuid('good_or_service_id')->nullable();

            $table->foreign('good_or_service_id')->references('id')->on('goods_or_services');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};
