<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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

            $price = 0;
            $payment = null;
            $leasing = $driver->leasing;
            if ($request->payment_type == 'daily') {

                $price = $leasing->daily_payment;

                $payment = $driver->payments()->create([
                    "price" => $price,
                    "leasing_id" => $leasing->id,
                    "payment_type" => "daily"
                ]);
            } else if ($request->payment_type == 'monthly') {
                $price = $leasing->monthly_payment;
                $payment = $driver->payments()->create([
                    "price" => $price,
                    "leasing_id" => $leasing->id,
                    "payment_type" => "monthly"
                ]);
            } else if ($request->payment_type == 'deposit_payment') {
                $price = $leasing->deposit_payment;
                $payment = $driver->payments()->create([
                    "price" => $price,
                    "leasing_id" => $leasing->id,
                    "payment_type" => "deposit_payment"
                ]);
            } else if ($request->payment_type == 'deposit_debt') {
                $price = $leasing->deposit_debt;
                $payment = $driver->payments()->create([
                    "price" => $price,
                    "leasing_id" => $leasing->id,
                    "payment_type" => "deposit_debt"
                ]);
            }

            




            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'azn',
                            'product_data' => [
                                'name' => $leasing->driver?->name . ' - ' . ' ' . $request->leasing_type . ' payment',
                                // 'description' => $subcategory->description ?? 'Subscription for ' . $durationMonths . ' months',
                            ],
                            'unit_amount' => round($price * 100), // Sentlərə çevirme
                        ],
                        'quantity' => 1,
                    ],
                ],
                'mode' => 'payment',
                'success_url' => url(env('ORDER_SUCCESS_URL') . '?session_id={CHECKOUT_SESSION_ID}'),
                'cancel_url' => url(env('ORDER_CANCEL_URL') . '?session_id={CHECKOUT_SESSION_ID}'),
                'metadata' => [
                    'leasing_id' => $leasing->id,
                    'driver_id' => $driver->id,
                    'payment_id' => $payment->id,
                    'leasing_type' => $request->leasing_type
                ],
            ]);


            // Sifarişin Stripe sessiya ID ilə yenilənməsi
            $payment->stripe_session_id = $session->id;
            $payment->save();

            DB::commit();

            Log::info('Stripe Checkout Session Created', [
                'leasing_id' => $leasing->id,
                'driver_id' => $driver->id,
                'leasing_type' => $request->leasing_type
            ]);

            return $this->responseMessage('success', 'Order is successfully created', [
                'payment_id' => $payment->id,
                'url' => $session->url,
                'session_id' => $session->id
            ], 200, null);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::info('Stripe Checkout message', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'message' => 'Payment session creation failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function handleWebhook(Request $request)
    {
        Log::info('Stripe Webhook Received', ['headers' => $request->header()]);

        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $webhookSecret = env('STRIPE_WEBHOOK_SECRET');

        try {
            // Webhook imzasının yoxlanılması
            $event = Webhook::constructEvent($payload, $sigHeader, $webhookSecret);


            Log::info('Stripe Webhook Event', [
                'type' => $event->type,
                'id' => $event->id
            ]);


            // Müxtəlif hadisə növlərinin idarə edilməsi
            switch ($event->type) {
                case 'checkout.session.completed':
                    return $this->handleCheckoutSessionCompleted($event->data->object);

                case 'payment_intent.succeeded':
                    return $this->handlePaymentIntentSucceeded($event->data->object);

                case 'payment_intent.payment_failed':
                    return $this->handlePaymentIntentFailed($event->data->object);

                default:
                    Log::info('Unhandled Stripe event type: ' . $event->type);
            }

            return response()->json(['status' => 'success']);
        } catch (\UnexpectedValueException $e) {
            Log::message('Invalid Stripe webhook payload', [
                'message' => $e->getMessage()
            ]);
            return response()->json(['message' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            Log::message('Invalid Stripe webhook signature', [
                'message' => $e->getMessage()
            ]);
            return response()->json(['message' => 'Invalid  salam signature'], 400);
        } catch (\Exception $e) {
            Log::message('Stripe webhook message', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['message' => 'Webhook processing message'], 500);
        }
    }

    private function handleCheckoutSessionCompleted($session)
    {
        Log::info('Checkout Session Completed', [
            'session_id' => $session->id,
            'payment_status' => $session->payment_status,
            'metadata' => $session->metadata
        ]);



        $paymentId = $session->metadata->payment_id ?? null;

        if (!$paymentId) {
            Log::message('No payment ID in session metadata', ['session_id' => $session->id]);
            return response()->json(['message' => 'Payment ID not found'], 400);
        }

        $payment = Payment::find($paymentId);

        if (!$payment) {
            Log::message('Order not found', ['payment_id' => $paymentId]);
            return response()->json(['message' => 'Payment not found'], 404);
        }

        if ($session->payment_status === 'paid') {
            DB::beginTransaction();
            try {
                // Sifariş statusunun yenilənməsi
                $payment->status = 'completed';
                $payment->stripe_payment_intent_id = $session->payment_intent;
                // $payment->leasing_payment_id = $payment->id;

                // Bitmə tarixinin hesablanması
                // $expiresAt = Carbon::now()->addMonths($order->duration_months);
                // $order->expires_at = $expiresAt;
                $leasingPayment = $payment->leasing?->leasingPaymentsRemanings()?->first();

                $leasingPayment->status = 'completed';
                $leasingPayment->save();
                $payment->save();

                // Burada abunəliyi aktivləşdirmək və ya giriş vermək üçün əlavə məntiq əlavə edə bilərsiniz
                // Məsələn, user_subcategory qeydi yarada bilər və ya istifadəçi icazələrini yeniləyə bilərsiniz

                DB::commit();



                return response()->json(['status' => 'success']);
            } catch (\Exception $e) {
                DB::rollBack();
                // echo $e->getMessage();
                // exit;

                return response()->json(['message' => 'Order processing failed'], 500);
            }
        }

        Log::warning('Checkout session not paid', [
            'session_id' => $session->id,
            'payment_status' => $session->payment_status
        ]);

        return response()->json(['status' => 'pending']);
    }

    private function handlePaymentIntentSucceeded($paymentIntent)
    {
        Log::info('Payment Intent Succeeded', [
            'payment_intent_id' => $paymentIntent->id,
            'amount' => $paymentIntent->amount / 100, // Sentlərdən çevirmə
            'currency' => $paymentIntent->currency
        ]);

        // Ödəmə intent ID ilə sifarişi tapmaq
        $order = Payment::where('stripe_payment_intent_id', $paymentIntent->id)->first();

        if ($order) {
            Log::info('Found order for payment intent', ['order_id' => $order->id]);

            // Əgər sifariş statusu hələ də gözləyirsə, onu yeniləyin
            if ($order->status === 'pending') {
                $order->status = 'completed';

                // Bitmə tarixi təyin edilməyibsə onu təyin edin
                if (!$order->expires_at) {
                    $order->expires_at = Carbon::now()->addMonths($order->duration_months);
                }

                $order->save();

                Log::info('Updated order status to completed', ['order_id' => $order->id]);
            }
        } else {
            Log::warning('No order found for payment intent', ['payment_intent_id' => $paymentIntent->id]);
        }

        return response()->json(['status' => 'success']);
    }

    private function handlePaymentIntentFailed($paymentIntent)
    {
        Log::warning('Payment Intent Failed', [
            'payment_intent_id' => $paymentIntent->id,
            'message' => $paymentIntent->last_payment_message
        ]);

        $order = Payment::where('stripe_payment_intent_id', $paymentIntent->id)->first();

        if ($order) {
            $order->status = 'failed';
            $order->save();

            Log::info('Updated order status to failed', ['order_id' => $order->id]);
        } else {
            Log::warning('No order found for failed payment intent', ['payment_intent_id' => $paymentIntent->id]);
        }

        return response()->json(['status' => 'payment_failed']);
    }

    public function checkPaymentStatus(Request $request)
    {
        $request->validate([
            'session_id' => 'required|string'
        ]);

        $sessionId = $request->session_id;

        $order = Payment::where('stripe_session_id', $sessionId)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json([
            'order_id' => $order->id,
            'status' => $order->status,
            'leasing_id' => $order->leasing?->id,
            'driver_id' => $order->driver?->id,
        ]);
    }
}