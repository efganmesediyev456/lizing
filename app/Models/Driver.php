<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Driver extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'date'=>'datetime',
        'password' => 'hashed',
    ];


    protected $hidden = [
        'password',
       
    ];

    public function city(){
        return $this->belongsTo(City::class);
    }

}
