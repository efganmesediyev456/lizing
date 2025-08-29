<?php

use App\Models\LeasingDetail;
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
         Schema::create('leasing_details', function (Blueprint $table) {
            $table->id();
            $table->string("image")->nullable();
            $table->longText("name")->nullable();
            $table->longText("description")->nullable();
            $table->timestamps();
        });

        LeasingDetail::create([
            
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leasing_details');
    }
};
