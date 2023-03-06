<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('article_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('article_id')->references('id')->on('articles')->
                onDelete('cascade');
            $table->string('url')->nullable();
            $table->string('category')->nullable();
            $table->string('supplier')->nullable();
            $table->string('country_origin')->nullable();
            $table->string('country_origin_code')->nullable();
            $table->float('weight')->nullable();
            $table->string('dimensions')->nullable();
            $table->string('color')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('article_details');
    }
};
