<?php

namespace App\Exports;

use App\Models\Driver;
use App\Models\Leasing;
use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LeasingExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    private int $index = 0;

    public function collection()
    {
        $query = Leasing::with([
            'driver',
            'vehicle',
            'leasingStatus'
        ])->orderBy('id', 'desc');


        if (request()->filled('brand_id')) {
            $query->where('brand_id', request()->brand_id);
        }
        if (request()->filled('model_id')) {
            $query->where('model_id', request()->model_id);
        }
        if (request()->filled('status_id')) {
            $query->where('leasing_status_id', request()->status_id);
        }
        if (request()->filled('driver_id')) {
            $query->where('driver_id', request()->driver_id);
        }

        if (request()->filled('table_id_number')) {
            $query->where('tableId', request()->table_id_number);
        }
        if (request()->filled('state_registration_number')) {
            $query->where('vehicle_id', request()->state_registration_number);
        }
        if (request()->filled('has_advertisement')) {
            $query->where('has_advertisement', request()->has_advertisement);
        }

        if (request()->filled('payment_type')) {
            $query->where('payment_type', request()->payment_type);
        }

        if (request()->filled('start_date')) {
            $query->where('start_date', '>=', request()->start_date);
        }

        if (request()->filled('end_date')) {
            $query->where('end_date', '<=', request()->end_date);
        }

        $query->orderByRaw('CAST(tableId AS UNSIGNED) ASC');
        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No:',
            'Table İD',
            'Ad soyad',
            'Model',
            'Marka',
            'D.Q.N.',
            'FİN',
            'Lizinq Statusu',
            'Reklam',
            'Depozit qiyməti',
            'Depozit ilkin ödənişi',
            'Depozit borcu',
            'Lizing qiyməti',
            'Ödəniş tipi',
            'Günlük ödəniş',
            'Aylıq ödəniş',
            'Lizing müddəti (gün)',
            'Lizing müddəti (ay)',
            'Başlama tarixi',
            'Bitmə tarixi'
        ];
    }

    public function map($item): array
    {
        return [
            ++$this->index,
           $item->tableId,
           $item->driver?->name.' '.$item->driver?->surname,
           $item->model?->title,
           $item->brand?->title,
           $item->vehicle?->state_registration_number,
           $item->driver?->fin,
           $item->leasingStatus?->title,
           match($item->has_advertisement){
                    0 =>'Xeyr',
                    1=>'Bəli',
                    default=>'N/A'
            },
            $item->deposit_price,
            $item->deposit_payment,
            $item->deposit_debt,
            $item->leasing_price,
            match($item->payment_type){
                    "daily" =>'Gündəlik',
                    "monthly"=>'Aylıq',
                    default=>'N/A'
            },
            $item->daily_payment,
            $item->monthly_payment,
            $item->leasing_period_days,
            $item->leasing_period_months,
            $item->start_date,
            $item->end_date
        ];
    }
}
