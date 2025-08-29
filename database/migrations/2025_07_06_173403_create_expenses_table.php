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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string("date")->nullable();
            $table->string("tableId")->nullable();
            $table->unsignedBigInteger("vehicle_id")->nullable();
            $table->foreign("vehicle_id")->references("id")->on("vehicles")->nullOnDelete();
            $table->decimal("total_expense", 10,2)->nullable();
            $table->decimal("spare_part_payment", 10,2)->nullable()->comment('ehtiyat hissesi odenisi');
            $table->decimal("master_payment", 10,2)->nullable();
            $table->longText("note")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
