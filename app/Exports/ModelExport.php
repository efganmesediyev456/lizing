<?php

namespace App\Exports;

use App\Models\Model;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ModelExport implements FromCollection,WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = Model::query();
        $search = request('search');
        if($search){
            $query->where('title','like',"$search")->orWhereHas("brand", function($q) use($search){
                $q->where("title",'like',"%$search%");
            })->orWhereHas("banType", function($q) use($search){
                $q->where("title","like","%$search%");
            });
        }
        return $query->get();
    }


    public function headings():array{
        return [
            "NO",
            "Marka",
            "Model",
            "Ban növü",
            "Status"
        ];
    }

    public function map($model):array{
        return [
            $model->id,
            $model->brand?->title,
            $model->title,
            $model->banType?->title,
            match($model->status){
                1=>"Active",
                0=>"Decative"
            }
        ];
    }
}
