<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BanType extends Model
{
    use HasFactory;

    public $guarded = [];

    protected $casts = [
        'date'=>'datetime'
    ];

}
