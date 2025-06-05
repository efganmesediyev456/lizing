<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'surname', 
        'email', 
        'phone', 
        'tableId',
        'fin', 
        'id_card_serial_code', 
        'current_address', 
        'registered_address', 
        'date', 
        'gender', 
        'id_card_front', 
        'id_card_back',
        'status'
    ];

    protected $casts = [
        'date'=>'datetime'
    ];

}
