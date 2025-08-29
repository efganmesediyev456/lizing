<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PaymentService
{
    protected $apiUrl;
    protected $hppRedirectUrl;

    protected $orderData;
    protected $username;
    protected $password;

    public function __construct()
    {
        $this->apiUrl = config('payment.kapitalbank.api_url', 'https://txpgtst.kapitalbank.az/api/order');
        $this->hppRedirectUrl = config('payment.kapitalbank.hpp_redirect_url', 'https://carleasing.166tech.com/success-payment');
        $this->username = config('payment.kapitalbank.username', 'TerminalSys/kapital');
        $this->password = config('payment.kapitalbank.password', 'kapital123');
    }


    public function createOrder($orderData)
    {

        try {

            $orderData = [
                "typeRid" => array_key_exists('typeRid', $orderData) ? $orderData['typeRid'] : "Order_SMS",
                "amount" => array_key_exists('amount', $orderData) ? $orderData['amount'] : 0,
                "currency" => array_key_exists('currency', $orderData) ? $orderData['currency'] : "AZN",
                "language" => array_key_exists('language', $orderData) ? $orderData['language'] : "az",
                "title" => array_key_exists('title', $orderData) ? $orderData['title'] : "",
                "description" => array_key_exists('description', $orderData) ? $orderData['description'] : "",
                "hppRedirectUrl" => $this->hppRedirectUrl
            ];
            $payload = [
                'order' => $orderData
            ];

            $response = Http::withBasicAuth($this->username, $this->password)->post($this->apiUrl, $payload);

            $data = $response->json();
            if (array_key_exists('errorCode', $data)) {
                throw new \Exception($data['errorDescription']);
            }

            if ($response->successful()) {
                return $response->json();
            }


        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }



      public function getOrderDetail($orderId)
    {
        try {

            $response = Http::withBasicAuth($this->username, $this->password)->get($this->apiUrl . '/' . $orderId);

            $data = $response->json();
            if (isset($data['errorCode'])) {
                throw new \Exception($data['errorDescription']);
            }

            if ($response->successful()) {
                return $data;
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
