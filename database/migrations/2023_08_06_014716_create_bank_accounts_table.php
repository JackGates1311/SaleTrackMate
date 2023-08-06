<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankAccountsTable extends Migration
{
    public function up()
    {
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('bank_identifier');
            $table->string('name');
            $table->string('iban');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bank_accounts');
    }
}
