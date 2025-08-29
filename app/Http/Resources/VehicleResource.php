<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            "image"=>url('storage/'.$this->image),
            "tableId"=> $this->table_id_number,
            "vinCode"=> $this->vin_code,
            "brand_id"=> $this->brand_id,
            "brandText"=> $this->brand?->title,
            "model_id"=> $this->model_id,
            "modelText"=> $this->model?->title,
            "stateRegistrationNumber"=> $this->state_registration_number,
            "productionYear"=> $this->production_year,
            "purchasePrice"=> $this->purchase_price,
            "mileage"=> $this->mileage,
            "oilTypeId"=> $this->oil_type_id,
            "oilTypeText"=> $this->oilType?->title,
            "engine"=> $this->engine,          
            "has_insurance" => $this->insurance?->end_date->gte(now()),
            "insurance_name" => $this->insurance?->company_name,
        ];
    }
}
