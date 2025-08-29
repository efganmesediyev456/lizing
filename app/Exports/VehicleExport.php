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
        return $query->get();
    }


    public function headings(): array{
        return [
            "No",
            "Table İD",
            "Marka",
            "Model",
            "D.Q.N",
        ];
    }

    public function map($model): array{
        return [
            $model->id,
            $model->table_id_number,
            $model->brand?->title,
            $model->model?->title,
            $model->state_registration_number
        ];
    }
}
