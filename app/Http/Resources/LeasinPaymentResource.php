<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeasinPaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    protected $paymentType;

    public function __construct($resource, $paymentType = null)
    {
        parent::__construct($resource);
        $this->paymentType = $paymentType;
    }

    public function toArray(Request $request): array
    {


        return [
            "id"=> $this->id,
            "payment_date"=>$this->payment_date,
            "status"=>$this->status,
            "price"=>$this->price,
            "remaining_amount"=>$this->remaining_amount,
            "month_name" =>Carbon::parse($this->payment_date)->format('M'),
            "day_name" =>  Carbon::parse($this->payment_date)->format('d'),
            "week_day_name" =>  Carbon::parse($this->payment_date)->format('D'),
        ];
    }
}
