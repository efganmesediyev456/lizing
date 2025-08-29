<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeasingPayment extends Model
{
    use HasFactory, SoftDeletes;

    public $guarded = [];


    public function leasing(){
        return $this->belongsTo(Leasing::class);
    }


     public function getCompletedPendingMonthDiffAttribute()
    {
        $completed = $this;
           

        $pending = $this->leasing?->leasingPayments()
            ->where('status', 'pending')
            ->orderByDesc('payment_date')
            ->first();


        if ($completed && $pending) {
            $completedDate = Carbon::parse($completed->payment_date);
            $pendingDate = Carbon::parse($pending->payment_date);
            return $completedDate->diffInMonths($pendingDate);
        }

        return null;
    }


    public function driver(){
        return $this->belongsTo(Driver::class);
    }
}
