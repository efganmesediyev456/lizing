<?php

namespace App\Exports;

use App\Models\Driver;
use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DriverExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query =  Driver::orderBy('id','desc');
        $search = request()->search;
        if($search){
            $query=$query->where('tableId', 'like','%'.$search.'%')->orWhere('name','like',"%$search%")
            ->orWhere("surname","like","%$search%")
            ->orWhere("email","like","%$search%")
            ->orWhere("fin","like","%$search%")
            ->orWhere("phone","like","%$search%");
        }
        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Table İD',
            'Ad Soyad',
            'Mail',
            'FİN',
            'Əlaqə nömrəsi'
        ];
    }

    public function map($driver): array
    {
        return [
            $driver->id,
            $driver->tableId,
            $driver->email,
            $driver->fullName,
            $driver->fin,
            $driver->phone
        ];
    }
}
