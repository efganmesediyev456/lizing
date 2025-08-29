<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as LaravelModel;

class Leasing extends LaravelModel
{
    use HasFactory;
    public $guarded = [];

    public $casts = [
        'start_date'=>'datetime:Y-m-d H:i:s',
        'end_date'=>'datetime:Y-m-d H:i:s',
    ];

    public function driver(){
        return $this->belongsTo(Driver::class);
    }
    public function model(){
        return $this->belongsTo(Model::class);
    }
    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    public function leasingPayments(){
        return $this->hasMany(LeasingPayment::class);
    }



    public function leasingPaymentsRemanings(){
        return $this->leasingPayments?->where('status','pending');
    }

    public function leasingPaymentsRemaningsOne(){
        return $this->hasOne(LeasingPayment::class)->where('status','<>','completed');
    }


    public function leasingStatus()
    {
        return $this->belongsTo(LeasingStatus::class, 'leasing_status_id');
    }


    public function passiveReason(){
        return $this->hasMany(PassiveLeasing::class);
    }


    protected static function booted()
    {
        static::deleting(function ($leasing) {
            $leasing->leasingPayments()->delete();
        });
    }



      public function getIsCompletedAttribute()
    {
        $start = \Carbon\Carbon::parse($this->start_date);
        $end   = \Carbon\Carbon::parse($this->end_date);

        if ($this->payment_type === 'daily') {
            $periods = $start->diffInDays($end) + 1;
        } else {
            $periods = $start->diffInMonths($end) + 1;
        }

        $key = $this->payment_type == 'daily' ? 'daily_payment' : ($this->payment_type=='monthly' ? 'monthly_payment':'');

        $totalRequired = $periods * $this->$key;
        $totalPaid     = $this->leasingPayments()->sum('price');

        return $totalPaid >= $totalRequired;
    }

   
}
