<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverResource extends JsonResource
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
            "name"=> $this->name,
            "surname"=> $this->surname,
            "email"=> $this->email,
            "phone"=> $this->phone,
            "tableId"=> $this->tableId,
            "finCode"=> $this->fin,
            "idCardSerialCode"=> $this->id_card_serial_code,
            "currentAddress"=> $this->current_address,
            "registeredAddress"=> $this->registered_address,
            "birthday"=> $this->date?->format("Y-m-d H:i:s"),
            "gender"=> $this->gender,
            "genderText"=> $this->gender===0 ? 'Kişi':"Qadın",
            "cityId"=> $this->city_id,
            "cityText"=> $this->city?->title,
            "idCardFrontImage"=> $this->id_card_front ? url('storage/'.$this->id_card_front) : null,
            "idCardBackImage"=> $this->id_card_back ? url('storage/'.$this->id_card_back) : null,
            "driversLicenseFront"=> $this->drivers_license_front ? url('storage/'.$this->drivers_license_front) : null,
            "driversLicenseBack"=> $this->drivers_license_back ? url('storage/'.$this->drivers_license_back) : null,
        ];
    }
}
