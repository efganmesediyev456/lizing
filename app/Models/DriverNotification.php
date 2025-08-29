<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverNotification extends Model
{
    use HasFactory;

    public $guarded = [];

    public function driverNotificationTopic(){
        return $this->belongsTo(DriverNotificationTopic::class);
    }

    public function driver(){
        return $this->belongsTo(Driver::class);
    }

    public function drivers(){
        return $this->hasMany(DriverNotificationList::class);
    }
}
