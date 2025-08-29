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
        Schema::table('app_store_assets', function (Blueprint $table) {
            $table->longText('full_description')->nullable();
            $table->string('feature_graphic_image')->nullable();
            $table->longText('tablets')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('app_store_assets', function (Blueprint $table) {
            //
        });
    }
};
