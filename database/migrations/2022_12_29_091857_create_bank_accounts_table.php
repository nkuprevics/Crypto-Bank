<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('owner_id');
            $table->string('owner_name', 255)->nullable();
            $table->string('owner_lname', 255)->nullable();
            $table->string('number', 255);
            $table->bigInteger('balance');
            $table->string('currency', 255);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bank_accounts');
    }
};
