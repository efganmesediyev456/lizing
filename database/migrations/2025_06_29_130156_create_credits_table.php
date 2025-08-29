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
        Schema::create('credits', function (Blueprint $table) {
            $table->id();
            $table->string("tableId")->nullable();
            $table->date('date')->nullable();
            $table->unsignedBigInteger("brand_id")->nullable();
            $table->foreign("brand_id")->references("id")->on("brands")->nullOnDelete();
            $table->unsignedBigInteger("model_id")->nullable();
            $table->foreign("model_id")->references("id")->on("models")->nullOnDelete();
            $table->unsignedBigInteger("vehicle_id")->nullable();
            $table->foreign("vehicle_id")->references("id")->on("vehicles")->nullOnDelete();
            $table->date('production_year')->nullable();
            $table->integer("calculation")->nullable()->comment('Hesab');
            $table->string("code")->nullable();
            $table->integer("down_payment")->nullable()->comment("İlkin ödəniş");
            $table->integer("monthly_payment")->nullable();
            $table->integer("total_months")->nullable();
            $table->integer("total_payable_loan")->nullable()->comment('Ümumi odənilenecek kredit');
            $table->integer("remaining_months")->nullable()->comment('Qalan ay');
            $table->integer("remaining_amount")->nullable()->comment('Qalan məbləğ');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credits');
    }
};
