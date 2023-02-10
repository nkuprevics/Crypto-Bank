<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('num_from', 255)->nullable();
            $table->string('num_to', 255)->nullable();
            $table->string('name_from', 255)->nullable();
            $table->string('lname_from', 255)->nullable();
            $table->string('name_to', 255)->nullable();
            $table->string('lname_to', 255)->nullable();
            $table->bigInteger('amount_from')->nullable();
            $table->bigInteger('amount_to')->nullable();
            $table->string('currency_from', 255)->nullable();
            $table->string('currency_to', 255)->nullable();
            $table->string('comment', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
