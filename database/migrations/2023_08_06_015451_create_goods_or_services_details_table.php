<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodsOrServicesDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('goods_or_services_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('url')->nullable();
            $table->string('category')->nullable();
            $table->string('supplier')->nullable();
            $table->string('country_origin')->nullable();
            $table->string('country_origin_code')->nullable();
            $table->decimal('weight', 10, 2)->nullable();
            $table->string('dimensions')->nullable();
            $table->string('color')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('goods_or_services_details');
    }
}
