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

    public function oilType(){
        return $this->belongsTo(OilType::class);
    }

    public function leasing(){
        return $this->hasOne(Leasing::class);
    }

    


    public function vehicleStatus(){
        return $this->belongsTo(VehicleStatus::class);
    }


    public function technicalReview()
    {
        return $this->hasOne(TechnicalReview::class)->latest();
    }

    public function insurance()
    {
        return $this->hasOne(Insurance::class)->latest();
    }


    public function color(){
        return $this->belongsTo(Color::class);
    }
}
