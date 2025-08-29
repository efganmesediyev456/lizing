<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    public $guarded = [];

    public $casts = [
        "updated_at" => "datetime:Y-m-d"
    ];

    public function leasing(){
        return $this->belongsTo(Leasing::class);
    }

    public function driver(){
        return $this->belongsTo(Driver::class);
    }


    public function leasingPayments(){
        return $this->hasMany(LeasingPayment::class);
    }


    public function leasingPayment(){
        return $this->belongsTo(LeasingPayment::class);
    }

    public function getStatusViewAttribute(){
        return match($this->status){
            "completed"=>"Ödəniş edildi",
            'pending'=>"Gözlənilir",
            default => 'Naməlum status',
        };
    }

    public function getPaymentTypeViewAttribute(){
        return match($this->payment_type){
            "daily"=>"Gündəlik",
            "montly"=>"Aylıq",
            "deposit_payment"=>"Ilkin depozit",
            "deposit_debt"=>"depozit",
            "deposit_admin"=>"Admin",
            default=>"Bilinməyən status"
        };
    }


    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }
    
}
