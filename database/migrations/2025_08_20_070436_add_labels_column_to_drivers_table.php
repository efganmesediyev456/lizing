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
        Schema::table('drivers', function (Blueprint $table) {
            $table->string("phone2_label")->nullable();
            $table->string("phone3_label")->nullable();
            $table->string("phone4_label")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('drivers', function (Blueprint $table) {
            $table->dropColumn("phone2_label");
            $table->dropColumn("phone3_label");
            $table->dropColumn("phone4_label");
        });
    }
};
