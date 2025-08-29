<?php

namespace App\Exports;

use App\Models\Brand;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BrandExport implements FromCollection,WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query=Brand::orderBy('id','desc');
        $search = request('search');
        if($search){
            $query->where('title',"like","%$search%");
        }
        return $query->get();
    }

    public function headings():array{
        return [
            "No",
            "Marka",
            "Status"
        ];
    }

    public function map($brand):array{
        return [
            $brand->id,
            $brand->title,
            match($brand->status){
                1=>"Active",
                0=>"Deactive",
            }
        ];
    }
}
