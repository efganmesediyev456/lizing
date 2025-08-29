<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Model as LaraModel;

class Credit extends Model
{
    use HasFactory;
    public $guarded = [];

    public $casts = [
        'created_at'=>"datetime:d.m.Y"
    ];

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    public function model(){
        return $this->belongsTo(LaraModel::class);
    }
    public function brand(){
        return $this->belongsTo(Brand::class);
    }
    public function getVehicleNameViewAttribute(){
        return $this->brand?->title.' '.$this->model?->title;
    }
}
