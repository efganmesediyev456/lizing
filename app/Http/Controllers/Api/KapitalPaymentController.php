<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LeasingStatus;
use App\Models\Payment;
use App\Models\SubCategoryPacketItem;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Checkout\Session;
use Stripe\Webhook;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\SubCategory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KapitalPaymentController extends Controller
{
    protected $paymentService;

    public function __construct()
    {
        $this->paymentService = new \App\Services\PaymentService();
    }

    public function createStripeCheckout(Request $request)
    {

        $request->validate([
            'payment_type' => 'required',
        ], [
            'payment_type.required' => 'Payment type is required.',
        ]);


        try {
            // İstifadəçinin alınması
            $driver = Auth::guard('driver')->user();
            if (!$driver) {
                return response()->json(['message' => 'Driver not authenticated'], 401);
            }

            Stripe::setApiKey(env('STRIPE_SECRET'));

            DB::beginTransaction();

            $price = null;
            $payment = null;
            $leasing = $driver->leasing;

            if($request->price){
                $price = $request->price;
            }

            
           

            if ($request->payment_type == 'daily') {

                $price = $price != null ? $price :  $leasing->daily_payment;

                $payment = $driver->payments()->create([
                    "price" => $price,
                    "leasing_id" => $leasing->id,
                    "payment_type" => "daily"
                ]);
            } else if ($request->payment_type == 'monthly') {
                $price = $price != null ? $price :  $leasing->monthly_payment;

                $payment = $driver->payments()->create([
                    "price" => $price,
                    "leasing_id" => $leasing->id,
                    "payment_type" => "monthly"
                ]);
            } else if ($request->payment_type == 'deposit_payment') {
                $price = $price != null ? $price :  $leasing->deposit_payment;
                $payment = $driver->payments()->create([
                    "price" => $price,
                    "leasing_id" => $leasing->id,
                    "payment_type" => "deposit_payment"
                ]);
            } else if ($request->payment_type == 'deposit_debt') {
                $price = $price != null ? $price :  $leasing->deposit_debt;
                $payment = $driver->payments()->create([
                    "price" => $price,
                    "leasing_id" => $leasing->id,
                    "payment_type" => "deposit_debt"
                ]);
            }

            $response = $this->paymentService->createOrder([
                'typeRid' => 'Order_SMS',
                'amount' => $price,
                'currency' => 'AZN',
                'language' => app()->getLocale(),
                'title' => $leasing->driver?->name . ' - ' . $request->payment_type . ' payment',
                'description' => $leasing->driver?->name . ' - ' . $request->payment_type . ' payment'
            ]);

            if ($response && !array_key_exists('order', $response)) {
                return response()->json(['message' => 'Payment creation failed: ' . $response], 500);
            }


            $payment->kapital_order_id = $response['order']['id'];
            $payment->kapital_password = $response['order']['password'];
            $payment->status = $response['order']['status'];
            $payment->save();

            DB::commit();

            Log::info('Kapital Checkout Session Created', [
                'leasing_id' => $leasing->id,
                'driver_id' => $driver->id,
                'leasing_type' => $request->leasing_type
            ]);

            return $this->responseMessage('success', 'Order is successfully created', [
                'payment_id' => $response['order']['id'],
                'url' => $response['order']['hppUrl'] . "?id=" . $response['order']['id'] . '&password=' . $response['order']['password'],
                'session_id' => $response['order']['password']
            ], 200, null);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::info('Kapital payment checkout message', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'message' => 'Kapital payment session creation failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function checkPaymentStatus(Request $request, $orderId)
    {



        Log::info('Order status request', ['headers' => $request->header(), 'order_id' => $orderId]);

        try {
            // throw new \Exception('This method is not implemented yet');

            $orderStatus = $this->paymentService->getOrderDetail($orderId);

            Log::info('Order status response', ['headers' => $request->header(), 'order_id' => $orderId, 'orderStatus' => json_encode($orderStatus)]);


            if (is_array($orderStatus) && array_key_exists('errorCode', $orderStatus)) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            $payment = Payment::where('kapital_order_id', $orderId)->where('status','Preparing')->first();
            if (!$payment) {
                return response()->json(['message' => 'Payment not found'], 404);
            }
            if (in_array($payment->payment_type, ['daily', 'monthly'])) {
                $payment->status = 'completed';

                $leasing = $payment->leasing;
                $payment->save();

                
                $leasing->leasingPayments()->create([
                    'driver_id'=>$payment->driver_id,
                    'payment_date'=>now(),
                    'status'=>"completed",
                    "price"=>$payment->price
                ]);

                if ($leasing->is_completed) {
                    //leasingin statusu bagli edirik
                    $leasingCloseStatus = LeasingStatus::where('is_closed', 1)->first();
                    $leasing->leasing_status_id = $leasingCloseStatus->id;
                    $leasing->save();

                    //leasing vehicle status null edek ki yenisi goture bilsin

                    $leasing->vehicle?->update(['vehicle_status_id' => null]);
                }

            }

            if($payment->payment_type == 'deposit_payment') {
                $leasing = $payment->leasing;
                $leasing->deposit_payment = $leasing->deposit_payment - $payment->price;
                $payment->status = 'completed';
                $leasing->save();
                $payment->save();
            }

            if($payment->payment_type == 'deposit_debt') {
                $leasing = $payment->leasing;
                $leasing->deposit_debt = $leasing->deposit_debt - $payment->price;
                $payment->status = 'completed';
                $leasing->save();
                $payment->save();
            }

            DB::commit();



            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while checking payment status: ' . $e->getMessage()], 500);
        }
    }





}