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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string("stripe_session_id")->nullable();
            $table->string("stripe_payment_intent_id")->nullable();
            $table->unsignedBigInteger('leasing_id')->nullable();
            $table->unsignedBigInteger("driver_id")->nullable();
            $table->foreign('leasing_id')->references('id')->on('leasings')->nullOnDelete();
            $table->foreign('driver_id')->references('id')->on('drivers')->nullOnDelete();
            $table->string('payment_type')->nullable();
            $table->double('price', 10, 2 )->nullable();
            $table->string('status')->default('pending');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
