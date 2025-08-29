<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    use HasFactory;
    public $guarded = [];

    public $casts = [
        "date"=>"datetime:d.m.Y"
    ];


    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }
}
