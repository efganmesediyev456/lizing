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
        Schema::create('penalty_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("penalty_id")->nullable();
            $table->foreign("penalty_id")->references("id")->on("penalties")->nullOnDelete();
            $table->decimal("amount", 10,2)->nullable();
            $table->unsignedTinyInteger("type")->default(1)->comment("1 Nağd ödəniş, 2 Online ödəniş");
            $table->longText("note")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penalty_payments');
    }
};
