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
        Schema::table('driver_notifications', function (Blueprint $table) {
            $table->unsignedBigInteger("driver_notification_topic_id")->nullable();
            $table->foreign("driver_notification_topic_id")->references("id")->on("driver_notification_topics")->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('driver_notifications', function (Blueprint $table) {
            //
        });
    }
};
