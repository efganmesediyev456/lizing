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
        Schema::create('passive_leasings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("leasing_id")->nullable();
            $table->foreign("leasing_id")->references("id")->on("leasings")->nullOnDelete();
            $table->unsignedBigInteger("driver_id")->nullable();
            $table->foreign("driver_id")->references("id")->on("drivers")->nullOnDelete();
            $table->longText("passive_reason");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('passive_leasings');
    }
};
