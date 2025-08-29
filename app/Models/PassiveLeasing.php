<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PassiveLeasing extends Model
{
    use HasFactory;

    public $guarded = [];


    public function driver(){
        return $this->belongsTo(Driver::class,'driver_id');
    }

    public function leasing(){
        return $this->belongsTo(Leasing::class);
    }
}
