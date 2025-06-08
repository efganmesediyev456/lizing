<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as LaravelModel;

class Insurance extends LaravelModel
{
    use HasFactory;

    public $guarded = [];

    public function brand(){
        return $this->belongsTo(Brand::class);
    }

     public function model(){
        return $this->belongsTo(Model::class);
    }
     public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

       public function driver(){
        return $this->belongsTo(Driver::class);
    }


    protected $casts = [
        'start_date'=>'datetime:d.m.Y',
        'end_date'=>'datetime:d.m.Y',
    ];
}
