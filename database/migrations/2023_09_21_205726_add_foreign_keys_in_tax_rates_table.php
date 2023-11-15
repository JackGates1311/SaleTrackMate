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
        Schema::table('tax_rates', function (Blueprint $table) {
            $table->foreignUuid('tax_category_id')->references('id')->on('tax_categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tax_category', function (Blueprint $table) {
            //
        });
    }
};
