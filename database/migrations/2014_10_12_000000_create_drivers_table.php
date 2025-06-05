<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('tableId');
            $table->string('fin')->unique();
            $table->string('id_card_serial_code')->unique();
            $table->string('current_address')->nullable();
            $table->string('registered_address')->nullable();
            $table->date('date')->nullable();
            $table->tinyInteger('gender')->default(0)->comment("0 kisi, 1 qadin");
            $table->string('id_card_front')->nullable();
            $table->string('id_card_back')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};