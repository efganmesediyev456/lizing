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
            $table->string('table_id_number')->unique();
            $table->string('vin_code')->unique();
            $table->string('state_registration_number')->unique();
            $table->integer('production_year');
            $table->decimal('purchase_price', 10, 2);
            $table->integer('mileage');
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
