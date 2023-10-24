<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipientsTable extends Migration
{
    public function up()
    {
        Schema::create('recipients', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('tax_code');
            $table->string('reg_id')->nullable();
            $table->string('vat_id')->nullable();
            $table->string('name');
            $table->string('country');
            $table->string('place');
            $table->string('postal_code');
            $table->string('address');
            $table->string('phone_num')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('recipients');
    }
}
