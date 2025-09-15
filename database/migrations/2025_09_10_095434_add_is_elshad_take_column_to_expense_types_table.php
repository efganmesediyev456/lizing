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
        Schema::table('expense_types', function (Blueprint $table) {
            $table->tinyInteger('is_elshad_take')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('expense_types', function (Blueprint $table) {
            $table->dropColumn('is_elshad_take');
        });
    }
};
