<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    public $guarded = [];


    public $casts = [
        "date"=>"datetime:Y-m-d"
    ];
    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }
  
}
