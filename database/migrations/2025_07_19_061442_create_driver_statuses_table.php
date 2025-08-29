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
        Schema::create('driver_statuses', function (Blueprint $table) {
            $table->id();
            $table->string("status");
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('drivers', function (Blueprint $table) {
           $table->unsignedBigInteger("status_id")->nullable()->after('registered_address');
           $table->foreign("status_id")->references("id")->on("driver_statuses")->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driver_statuses');
        
    }
};
