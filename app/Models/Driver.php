<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Driver extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'date' => 'datetime',
    ];


    protected $hidden = [
        'password'
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function notification()
    {
        return $this->hasMany(DriverNotificationList::class, 'driver_id');
    }

    public function leasing()
    {
        return $this->hasOne(Leasing::class, 'driver_id')
            ->whereNotIn('leasing_status_id', [2, 3])->latest('id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'driver_id');
    }

    public function leasingPayments()
    {
        return $this->hasMany(LeasingPayment::class, 'driver_id');
    }

    public function checkLastPayment()
    {
        return $this->leasingPayments()->where('status', 'pending')->exists();
    }

    public function checkDepositPayment()
    {
        return $this->payments()->where('payment_type', 'deposit_payment')->where('status', 'completed');
    }

    public function checkDepositDept()
    {
        return $this->payments()->where('payment_type', 'deposit_debt')->where('status', 'completed');
    }



    public function checkPaymentStatus()
    {
        if ($this->leasing?->monthly_payment and $this->leasing?->leasing_period_months) {
            return "monthly";
        } elseif ($this->leasing?->daily_payment and $this->leasing?->leasing_period_days) {
            return "daily";
        }
        return null;
    }


    public function getFullNameAttribute()
    {
        return $this->name . ' ' . $this->surname;
    }


    public function findForPassport($username)
    {
        return $this->where('email', $username)
            ->orWhere('phone', $username)
            ->first();
    }

    public function passiveReason()
    {
        return $this->hasMany(PassiveLeasing::class);
    }

    public function oilChanges()
    {
        return $this->hasMany(OilChange::class);
    }



    public function leasings()
    {
        return $this->hasMany(Leasing::class);
    }


    public function getDebtAttribute()
    {

        $debts = 0;

        foreach ($this->leasings as $leasing) {
            if($leasing->is_completed){
                continue;
            }
            
            $start = Carbon::parse($leasing->start_date);
            $end = Carbon::parse($leasing->end_date);
            $today = Carbon::today()->lt($end) ? Carbon::today() : $end;

            

            if (Carbon::today()->lt($start)) {
                continue;
            }

            $totalPaid = $leasing->leasingPayments->where('status', 'completed')->sum('price');
           
            $totalRequired = 0;

            // ===== DAILY PAYMENT =====
            if ($leasing->payment_type === 'daily') {
               
                $totalRequired = (Carbon::parse($leasing->start_date)->diffInDays($today) + 1) * $leasing->daily_payment;
            }

            // ===== MONTHLY PAYMENT =====
            elseif ($leasing->payment_type === 'monthly') {
               
                $totalRequired = (Carbon::parse($leasing->start_date)->diffInMonths($today) + 1) * $leasing->monthly_payment;
            }


            // ümumi borc
            $totalDebt = max(0, $totalRequired - $totalPaid);
            $debts+=$totalDebt;

        }
        return $debts;
    }


    public function routeNotificationForExpo()
    {
        return $this->expo_token;
    }
    

}
