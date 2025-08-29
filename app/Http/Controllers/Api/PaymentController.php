<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DriverResource;
use App\Http\Resources\LeasinPaymentResource;
use App\Http\Resources\MobileSettingResource;
use App\Models\Driver;
use App\Models\MobileSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;


class PaymentController extends Controller
{


    public function index_old()
    {
        $driver = auth('driver')->user();

        // if($driver->passiveReason->first()){
        //     return [];
        // }
        if (!$driver->leasing) {
            return response()->json([]);
        }
        $paymentType = $driver->checkPaymentStatus();
        $leasingPayments = $driver->leasingPayments()->whereHas('leasing', function ($query) {
            $query->whereNotIn('leasing_status_id', [2, 3]);
        })->get();
        // dd($leasingPayments);
        $leasingPayments = $leasingPayments->whereNotIn('leasing_id', $driver->passiveReason->pluck('leasing_id'));
        // $driver->passiveReason->pluck('leasing_id')



        $collection = $leasingPayments->map(function ($payment) use ($paymentType) {
            return new LeasinPaymentResource($payment, $paymentType);
        });
        return response()->json($collection);
    }

    public function payments(Request $request)
    {
        $driver = $request->user();
        $payments = $driver->payments;
        return $payments;
    }

    public function index()
    {
        $driver = auth()->guard('driver')->user();
        $response = [];
        $records = [];


        
     

        foreach ($driver->leasings as $leasing) {


            if($leasing->is_completed){
                continue;
            }
            $start = Carbon::parse($leasing->start_date);
            $end = Carbon::parse($leasing->end_date);
            $today = Carbon::today()->lt($end) ? Carbon::today() : $end;


            // ümumi ödənişləri topla
            $totalPaid = $leasing->leasingPayments->where('status','completed')->sum('price');
            $balance = $totalPaid;


            $records = [];
             $id = 1;

            // ===== DAILY PAYMENT =====
            if ($leasing->payment_type === 'daily') {
                $current = $start->copy();
                while ($current->lte($end)) {
                    $required = $leasing->daily_payment; // gündəlik məbləğ
                    $paid = 0;

                    if ($balance >= $required) {
                        $paid = $required;
                        $balance -= $required;
                        $status = "completed";
                    } elseif ($balance > 0 && $balance < $required) {
                        $paid = $balance;
                        $balance = 0;
                        $status = "partial";
                    } else {
                        $paid = 0;
                        $status = "pending";
                    }

                    $records[] = [
                        'id' => $id++,
                        "payment_date" => $current->toDateString(),
                        "status" => $status,
                        "price" => $required,
                        "remaining_amount" => max(0, $required - $paid),
                        "month_name" =>$current->format('M'),
                        "day_name" =>  $current->format('d'),
                        "week_day_name" =>  $current->format('D'),
                        "paid" => $paid,
                    ];

                    $current->addDay();
                }

                $totalRequired = (Carbon::parse($leasing->start_date)->diffInDays($today) + 1) * $leasing->daily_payment;
            }

            // ===== MONTHLY PAYMENT =====
            elseif ($leasing->payment_type === 'monthly') {
                $current = $start->copy();
                $id = 1;
                while ($current->lte($end)) {
                    $required = $leasing->monthly_payment; // aylıq məbləğ
                    $paid = 0;

                    if ($balance >= $required) {
                        $paid = $required;
                        $balance -= $required;
                        $status = "completed";
                    } elseif ($balance > 0 && $balance < $required) {
                        $paid = $balance;
                        $balance = 0;
                        $status = "partial";
                    } else {
                        $paid = 0;
                        $status = "pending";
                    }

                    $records[] = [
                        "id" => $id++,
                        "payment_date" => $current->format("Y-m-d"),
                         "status" => $status,
                        "price" => $required,
                        "remaining_amount" => max(0, $required - $paid),
                        "month_name" =>$current->format('M'),
                        "day_name" =>  $current->format('d'),
                        "week_day_name" =>  $current->format('D'),
                        "paid" => $paid,
                       
                    ];

                    $current->addMonth();
                }

                $totalRequired = (Carbon::parse($leasing->start_date)->diffInMonths($today) + 1) * $leasing->monthly_payment;
            }

            // ümumi borc
            $totalDebt = max(0, $totalRequired - $totalPaid);

            // $response[] = [
            //     "leasing_id" => $leasing->id,
            //     "vehicle" => $leasing->vehicle?->plate_number,
            //     "payment_type" => $leasing->payment_type,
            //     "amount" => $leasing->amount,
            //     "records" => $records,
            //     "total_debt" => $totalDebt
            // ];

            $response = $records;
        }

        return response()->json($response);
    }

}
