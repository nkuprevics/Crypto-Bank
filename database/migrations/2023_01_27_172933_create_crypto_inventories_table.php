<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('crypto_inventories', function (Blueprint $table) {
            $table->id();
            $table->string('owner_bank_account', 255)->nullable();
            $table->string('inventory', 500)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('crypto_inventories');
    }
};
