<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as LaravelModel;

class Model extends LaravelModel
{
    use HasFactory;
    public $guarded = [];

    public function brand(){
        return $this->belongsTo(Brand::class);
    }
     public function banType(){
        return $this->belongsTo(BanType::class);
    }
}
