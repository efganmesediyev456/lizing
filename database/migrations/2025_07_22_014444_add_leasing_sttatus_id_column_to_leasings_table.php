<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('leasings', function (Blueprint $table) {
            $table->foreignId('leasing_status_id')
                ->nullable()
                ->constrained('leasing_statuses')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('leasings', function (Blueprint $table) {
            $table->dropForeign(['leasing_status_id']);
            $table->dropColumn('leasing_status_id');
        });
    }
};
