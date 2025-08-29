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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('oil_type_id')->nullable();
            $table->foreign('oil_type_id')->references('id')->on('oil_types')->nullOnDelete();
            $table->unsignedBigInteger("brand_id")->nullable();
            $table->foreign("brand_id")->references("id")->on("brands")->nullOnDelete();
            $table->unsignedBigInteger("model_id")->nullable();
            $table->foreign("model_id")->references("id")->on("models")->nullOnDelete();
            $table->string('table_id_number')->unique();
            $table->string('vin_code')->nullable();
            $table->string('state_registration_number')->unique();
            $table->integer('production_year');
            $table->decimal('purchase_price', 10, 2)->nullable();
            $table->integer('mileage')->nullable();
            $table->string('engine');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
