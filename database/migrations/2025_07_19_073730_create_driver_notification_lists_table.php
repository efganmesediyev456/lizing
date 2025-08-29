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
        Schema::create('driver_notification_lists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("driver_id")->nullable();
            $table->foreign("driver_id")->references("id")->on("drivers")->nullOnDelete();
            $table->unsignedBigInteger("driver_notification_id")->nullable();
            $table->foreign("driver_notification_id")->references("id")->on("driver_notifications")->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driver_notification_lists');
    }
};
