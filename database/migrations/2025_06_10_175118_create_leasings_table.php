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
        Schema::create('leasings', function (Blueprint $table) {
            $table->id();
            $table->string("tableId")->nullable();
            $table->unsignedBigInteger("driver_id")->nullable();
            $table->foreign("driver_id")->references("id")->on("drivers")->nullOnDelete();
            $table->tinyInteger("has_advertisement")->default(0)->comment("0 yoxdur, 1 var");
            $table->integer("deposit_payment")->nullable();
            $table->integer("deposit_price")->nullable();
            $table->integer("deposit_debt")->nullable();
            $table->unsignedBigInteger("vehicle_id")->nullable();
            $table->foreign("vehicle_id")->references("id")->on("vehicles")->nullOnDelete();
            $table->integer("leasing_price")->nullable();
            $table->integer("daily_payment")->nullable();
            $table->integer("monthly_payment")->nullable();
            $table->integer("leasing_period_days")->nullable();
            $table->integer("leasing_period_months")->nullable();
            $table->date("start_date")->nullable();
            $table->date("end_date")->nullable();
            $table->longText("notes")->nullable();
            $table->string("file")->nullable();
            $table->unsignedBigInteger("brand_id")->nullable();
            $table->foreign("brand_id")->references("id")->on("brands")->nullOnDelete();
            $table->unsignedBigInteger("model_id")->nullable();
            $table->foreign("model_id")->references("id")->on("models")->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leasings');
    }
};
