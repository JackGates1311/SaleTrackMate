<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('company_id')->constrained('companies')->onDelete('cascade');
            $table->string('article_id');
            $table->string('serial_num');
            $table->string('name');
            $table->string('unit');
            $table->integer('min_unit')->nullable();
            $table->integer('max_unit')->nullable();
            $table->float('price');
            $table->string('description');
            $table->string('image_url')->nullable();
            $table->integer('available_quantity')->nullable();
            $table->integer('warranty_len')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
