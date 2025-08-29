<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('debts', function (Blueprint $table) {
            $table->id();
            $table->string("tableId")->nullable();
            $table->date("date")->nullable();
            $table->unsignedBigInteger("brand_id")->nullable();
            $table->foreign("brand_id")->references("id")->on("brands")->nullOnDelete();
            $table->unsignedBigInteger("model_id")->nullable();
            $table->foreign("model_id")->references("id")->on("models")->nullOnDelete();
            $table->unsignedBigInteger("vehicle_id")->nullable();
            $table->foreign("vehicle_id")->references("id")->on("vehicles")->nullOnDelete();
            $table->string("production_year")->nullable();
            $table->string("spare_part_title")->nullable();
            $table->double("price", 10,2)->nullable();
            $table->double("price_payment", 10,2)->nullable();
            $table->longText("note")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('debts');
    }
};
