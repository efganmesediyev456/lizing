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
        Schema::create('app_store_assets', function (Blueprint $table) {
            $table->id();
            $table->string('app_name')->nullable();
            $table->text('description')->nullable();
            $table->string('icon_path')->nullable();
            $table->json('screenshot_paths')->nullable();
            $table->string('app_category')->nullable();
            $table->string('privacy_policy_url')->nullable();
            $table->unsignedBigInteger('user_id')->nullable(); // Kullanıcıya bağlama opsiyonel
            $table->timestamps();
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_store_assets');
    }
};
