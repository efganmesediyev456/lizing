<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'table_id_number',
        'vin_code',
        'state_registration_number',
        'production_year',
        'purchase_price',
        'mileage',
        'engine',
        'status'
    ];

    public function getPurchasePriceAttribute($value)
    {
        return number_format($value, 2);
    }
}
