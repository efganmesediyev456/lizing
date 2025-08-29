<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeasingStatus extends Model
{
    use HasFactory;

    public $guarded = [];

    protected $casts = [
        'date' => 'datetime'
    ];
}
