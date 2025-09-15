<?php

namespace App\Exports;

use App\Models\Vehicle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class VehicleExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    private int $index = 0;

    public function collection()
    {
        $query = Vehicle::query();
        $search = request('search');
        if($search){
            $query
            ->where('table_id_number','like',"%$search%")
            ->orWhere('state_registration_number','like',"%$search%")
            ->orWhereHas('brand',function($q) use($search){
                return $q->where('title','like',"%$search%");
            })
             ->orWhereHas('model',function($q) use($search){
               return $q->where('title','like',"%$search%");
            });
        }
        $query->orderByRaw('CAST(table_id_number AS UNSIGNED) ASC');

        return $query->get();
    }


    public function headings(): array{
        return [
            "No",
            "Table İD",
            "Marka",
            "Model",
            "D.Q.N",
            "İli",
            "Mühərrik",
            "Reklam",
            "Texniki baxışın bitdiyi vaxt",
            "Sığortanın bitəcəyi vaxt",
            'Sığorta Şirkəti',
            'Başlama tarixi',
            'Bitmə tarixi',
            'Depozit',
            'Depozit borcu',
            'Gündəlik İcarəsi',
            'Aylıq İcarəsi',
            'Ay',
            'Gün',
            'Ümumi',
            'Status'
        ];
    }

    public function map($vehicle): array{
        return [
            ++$this->index, 
            $vehicle->table_id_number,
            $vehicle->brand?->title,
            $vehicle->model?->title,
            $vehicle->state_registration_number,
            $vehicle->production_year,
            $vehicle->engine,
            $vehicle->leasing?->has_advertisement ? 'Bəli' : 'Xeyr',
            $vehicle->technicalReview?->end_date?->format('Y-m-d'),
            $vehicle->insurance?->end_date?->format('Y-m-d'),
            $vehicle->insurance?->company_name,
            $vehicle->leasing?->start_date?->format('Y-m-d'),
            $vehicle->leasing?->end_date?->format('Y-m-d'),
            $vehicle->leasing?->deposit_payment,
            $vehicle->leasing?->deposit_debt,
            $vehicle->leasing?->daily_payment . ' AZN',
            $vehicle->leasing?->monthly_payment . ' AZN',
            $vehicle->leasing?->leasing_period_months . ' Ay',
            $vehicle->leasing?->leasing_period_days . ' Gün',
            $vehicle->leasing?->leasing_price . ' AZN',
            $vehicle->vehicleStatus?->title
            
        ];
    }
}
