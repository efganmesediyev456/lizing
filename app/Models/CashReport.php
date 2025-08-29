<?php
// app/Models/CashReport.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashReport extends Model
{
    protected $fillable = [
      'report_date','status','opened_at','closed_at',
      'income_cash','income_online','income_total',
      'expense_cash','expense_online','expense_total',
      'net_total','created_by','closed_by'
    ];

    protected $casts = [
      'report_date' => 'date',
      'opened_at'   => 'datetime',
      'closed_at'   => 'datetime',
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class, 'report_id');
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class, 'report_id');
    }
}
