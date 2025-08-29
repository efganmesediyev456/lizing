<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DriverResource;
use App\Models\Driver;
use Illuminate\Http\Request;


class DriverController extends Controller
{

    
    public function index()
    {
       $drivers = Driver::all();
       return DriverResource::collection($drivers);
    }

    public function paymentTypes(Request $request){
       $driver = $request->user();
       $checkPaymentStatus = $driver->checkPaymentStatus();
       $checkDepositPayment = $driver->checkDepositPayment();
       $checkDepositDept = $driver->checkDepositDept();

       $leasing = $driver->leasings->filter(function($fn){
          return !$fn->is_completed and $fn->leasing_status_id==1;
       })?->first();
       $data = [
            'daily'=>   $leasing?->payment_type=='daily',
            'monthly'=>  $leasing?->payment_type=='monthly',
            'deposit_payment'=>   $driver?->leasing?->deposit_payment >0 ,
            'deposit_debt'=>  $driver?->leasing?->deposit_debt > 0
       ];
       return response()->json($data);
    }


    public function userDetails(Request $request){
      return $this->responseMessage("success","Successfully fetched",new DriverResource($request->user()), 200, null);
    }

}
