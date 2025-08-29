<?php

// database/migrations/2025_08_18_000002_alter_expenses_for_cashbox.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::table('expenses', function (Blueprint $table) {
      if (!Schema::hasColumn('expenses','report_at')) {
        $table->dateTime('report_at')->nullable()->index();
      }
      if (!Schema::hasColumn('expenses','method')) {
        $table->enum('method',['cash','online'])->default('cash')->index();
      }
      if (!Schema::hasColumn('expenses','report_id')) {
        $table->unsignedBigInteger('report_id')->nullable();
      }
    });


    Schema::table('payments', function (Blueprint $table) {
      if (!Schema::hasColumn('payments','report_id')) {
        $table->unsignedBigInteger('report_id')->nullable();
      }
      if (!Schema::hasColumn('payments','report_at')) {
        $table->dateTime('report_at')->nullable()->index();
      }
    });


    Schema::create('cash_reports', function (Blueprint $table) {
      $table->id();
      $table->date('report_date')->index();                
      $table->enum('status',['open','closed'])->default('open')->index();
      $table->dateTime('opened_at')->nullable();
      $table->dateTime('closed_at')->nullable();

      $table->decimal('income_cash',   12,2)->default(0);
      $table->decimal('income_online', 12,2)->default(0);
      $table->decimal('income_total',  12,2)->default(0);

      $table->decimal('expense_cash',   12,2)->default(0);
      $table->decimal('expense_online', 12,2)->default(0);
      $table->decimal('expense_total',  12,2)->default(0);

      $table->decimal('net_total',      12,2)->default(0);  

      $table->timestamps();
      $table->unique(['report_date']); 
    });

  }
  public function down(): void {
    Schema::table('expenses', function (Blueprint $table) {
      if (Schema::hasColumn('expenses','report_id')) $table->dropConstrainedForeignId('report_id');
      if (Schema::hasColumn('expenses','method')) $table->dropColumn('method');
      if (Schema::hasColumn('expenses','paid_at')) $table->dropColumn('paid_at');
    });
  }
};
