<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeasingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'vehicle'=>new VehicleResource($this->vehicle),
            'hasAdvertisement'=>(bool)$this->has_advertisement,
            'deposit_payment'=>$this->deposit_payment,
            'deposit_price'=>$this->deposit_price,
            'deposit_debt'=>$this->deposit_debt,
            'leasing_price'=>$this->leasing_price,
            'daily_payment'=>$this->daily_payment,
            'monthly_payment'=>$this->monthly_payment,
            'leasing_period_days'=>$this->leasing_period_days,
            'leasing_period_months'=>$this->leasing_period_months,
            'start_date'=>$this->start_date?->format('Y-m-d'),
            'end_date'=>$this->end_date?->format('Y-m-d'),
            'notes'=>$this->notes,
            'debt'=>$this->driver?->debt,
            'payment_type' => $this->payment_type
            

        ];
    }
}
