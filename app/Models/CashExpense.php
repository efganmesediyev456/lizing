<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashExpense extends Model
{
    use HasFactory;

    public $guarded = [];

    


    public function expenseType(){
        return $this->belongsTo(ExpenseType::class);
    }
}
