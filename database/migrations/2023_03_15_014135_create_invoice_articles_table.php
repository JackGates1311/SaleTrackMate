<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoice_articles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('invoice_id')->references('id')->on('invoices')->
                onDelete('cascade');;
            $table->string('article_id');
            $table->string('name');
            $table->string('unit');
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->decimal('rebate', 10, 2)->nullable();
            $table->decimal('vat', 5, 2);
            $table->decimal('price_with_vat', 10, 2);
            $table->string('image_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_articles');
    }
};
