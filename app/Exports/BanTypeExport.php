<?php

namespace App\Exports;

use App\Models\BanType;
use App\Models\Driver;
use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BanTypeExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = BanType::orderBy('id','desc');
        $search = request('search');
        if($search){
            $query->where('title','like',"%$search%");
        }
        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Ban növü',
            'Status',
        ];
    }

    public function map($banType): array
    {
        return [
            $banType->id,
            $banType->title,
            match($banType->status){
                1 =>'Active',
                0 => 'Deactive'
            }
        ];
    }
}
