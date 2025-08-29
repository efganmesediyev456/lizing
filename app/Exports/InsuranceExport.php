<?php

namespace App\Exports;

use App\Models\Insurance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class InsuranceExport implements FromCollection,WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = Insurance::query();
        $search = request('search');
        if($search){
            $query
            ->where('tableId','like',"%$search%")
            ->orWhereHas('brand',function($q) use($search){
                $q->where('title','like','%'.$search.'%');
            })
             ->orWhereHas('model',function($q) use($search){
                $q->where('title','like','%'.$search.'%');
            })
            ->orWhereHas('vehicle',function($q) use($search){
                $q->where('state_registration_number','like','%'.$search.'%');
            })
            ;
        }
        return $query->get();
    }

    public function headings(): array{
        return [
            "No",
            "Table İD",
            "Marka",
            "Model",
            "D.Q.N.",
            "Başlama tarixi",
            "Bitmə tarixi"
        ];
    }

    public function map($row): array{
        return [
            $row->id,
            $row->tableId,
            $row->brand?->title,
            $row->model?->title,
            $row->vehicle?->state_registration_number,
            $row->start_date,
            $row->end_date
        ];
    }
}
