<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as LaravelModel;

class Leasing extends LaravelModel
{
    use HasFactory;
    public $guarded = [];

    public function driver(){
        return $this->belongsTo(Driver::class);
    }
    public function model(){
        return $this->belongsTo(Model::class);
    }
    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

}
