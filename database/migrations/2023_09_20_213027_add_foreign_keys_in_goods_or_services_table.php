<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('goods_or_services', function (Blueprint $table) {
            $table->foreignUuid('company_id')->references('id')->on('companies')
                ->onDelete('cascade');

            $table->foreignUuid('tax_category_id')->references('id')->on('tax_categories');
            $table->foreignUuid('price_id')->references('id')->on('prices');
            $table->foreignUuid('price_discount_id')->references('id')->on('price_discounts');
            $table->foreignUuid('unit_of_measure_id')->references('id')->on('unit_of_measures');
            $table->foreignUuid('good_or_service_details_id')->nullable();

            $table->foreign('good_or_service_details_id')->references('id')
                ->on('goods_or_services_details');
        });
    }

    public function down(): void
    {
        Schema::table('goods_or_services', function (Blueprint $table) {
            //
        });
    }
};
