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
        Schema::create('penalties', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("vehicle_id")->nullable();
            $table->foreign("vehicle_id")->references("id")->on("vehicles")->nullOnDelete();
            $table->unsignedBigInteger("penalty_type_id")->nullable();
            $table->foreign("penalty_type_id")->references("id")->on("penalty_types")->nullOnDelete();
            $table->date("date")->nullable();
            $table->string("penalty_code")->nullable();
            $table->decimal("amount", 10,2)->nullable();
            $table->tinyInteger("status")->default(1)->comment("1 ödənilməyib, 2 ödənilib");
            $table->longText("note")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penalties');
    }
};
