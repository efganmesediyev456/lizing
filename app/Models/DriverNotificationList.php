<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverNotificationList extends Model
{
    use HasFactory;

    public $guarded = [];

    public $table= 'driver_notification_lists';


    public function driver(){
        return $this->belongsTo(Driver::class);
    }


    public function notification(){
        return $this->belongsTo(DriverNotification::class,'driver_notification_id');
    }
}
