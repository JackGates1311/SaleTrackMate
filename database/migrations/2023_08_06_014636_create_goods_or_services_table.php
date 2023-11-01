<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodsOrServicesTable extends Migration
{
    public function up()
    {
        Schema::create('goods_or_services', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('serial_num');
            $table->string('name');
            $table->string('description');
            $table->string('image_url')->nullable();
            $table->integer('warranty_len')->nullable();
            $table->string('type'); // Assuming GoodsOrServicesType is a string-based enumeration
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('goods_or_services');
    }
}
