<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as LaravelModel;


class Vehicle extends LaravelModel
{
    use HasFactory;

    protected $guarded = [];

    public function getPurchasePriceAttribute($value)
    {
        return number_format($value, 2);
    }

    public function brand(){
        return $this->belongsTo(Brand::class);
    }

     public function model(){
        return $this->belongsTo(Model::class);
    }
}
