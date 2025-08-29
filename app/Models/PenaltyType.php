<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Model as BrandModel;

class PenaltyType extends Model
{
    use HasFactory;

    public $guarded = [];

    protected $casts = [
        'date'=>'datetime'
    ];
}
