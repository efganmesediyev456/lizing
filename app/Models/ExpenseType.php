<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseType extends Model
{
    use HasFactory;

    public $guarded = [];

    protected $casts = [
        'date'=>'datetime'
    ];


    public function todayValue(){
         $date = request()->date
            ? Carbon::parse(request()->date)->toDateString()
            : Carbon::today()->toDateString();
        return $this->hasMany(CashExpense::class,'expense_type_id')->whereDate('date',$date)->first();
    }

    public function getTypeShowAttribute(){
        return match($this->type){
             0 => '-',
            1 => '+'
        };
    }

     public function getTypeTextAttribute(){
        return match($this->type){
             0 => 'Xərc',
            1 => 'Gəlir'
        };
    }
}
