<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Model as BrandModel;

class Brand extends Model
{
    use HasFactory;

    public $guarded = [];

    protected $casts = [
        'date'=>'datetime'
    ];

    public function models(){
        return $this->hasMany(BrandModel::class);
    }

}
