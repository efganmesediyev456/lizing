<?php

namespace App\Exports;

use App\Models\Driver;
use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DepositExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private int $index = 0;

    public function collection()
    {
        $query = Payment::whereIn('payment_type',['deposit_payment','deposit_debt','deposit_admin'])->orderBy('id', 'desc');
        
        if (request()->filled('brand_id')) {
            $brandId = request('brand_id');
            $query = $query->whereHas('leasing.vehicle', function ($q) use ($brandId) {
                $q->where('brand_id', $brandId);
            });
        }
        if (request()->filled('model_id')) {
            $modelId = request('model_id');
            $query = $query->whereHas('leasing.vehicle', function ($q) use ($modelId) {
                $q->where('model_id', $modelId);
            });
        }

        if (request()->filled('status_id')) {
            $query = $query->where('payment_type', request()->status_id);
        }


        if (request()->has('driver_id')) {
            $driverId = request('driver_id');
            $query = $query->where('driver_id', $driverId);
        }

        if (request()->filled('state_registration_number')) {
            $stateRegNumber = request('state_registration_number');
            $query = $query->whereHas('leasing.vehicle', function ($q) use ($stateRegNumber) {
                $q->where('id', "$stateRegNumber");
            });
        }
        
        if (request()->filled('start_created_at')) {
            $query->where('created_at', '>=', request()->start_created_at);
        }

        if (request()->filled('end_created_at')) {
            $query->where('created_at', '<=', request()->end_created_at);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No:',
            'Ad soyad',
            'Marka',
            'Model',
            'DQN',
            'Depozit',
            'Yaradılma tipi',
            'Tarix',
            'Şəxsiyyət FİN',
            'Şəxsiyyətin seriya nömrəsi',
            'Ödəniş statusu'
        ];
    }

    public function map($item): array
    {
        return [
            ++$this->index, 
            $item->driver?->fullName,
            $item->leasing?->vehicle?->brand?->title,
            $item->leasing?->vehicle?->model?->title,
            $item->leasing?->vehicle?->state_registration_number,
            $item->price.' AZN',
            match($item->payment_type){
                    "deposit_admin"=>"Admin",
                    "deposit_debt"=>"Depozit borcu",
                    "deposit_payment"=>"Ilkin Depozit",
                    default=>"Bilinməyən status"
                },
            $item->created_at->format('Y-m-d'),
            $item->driver?->fin,
            $item->driver?->id_card_serial_code,
            $item->statusView
        ];
    }
}
