<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penalty extends Model
{
    use HasFactory;
    public $guarded = [];

    public function penaltyType(){
        return $this->belongsTo(PenaltyType::class);
    }


    public function penaltyPayment(){
        return $this->hasOne(PenaltyPayment::class);
    }

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }


    public function getStatusViewAttribute(){
        return match($this->status){
            1=>"Ödənilməyib",
            2=>"Ödənilib"
        };
    }
}
