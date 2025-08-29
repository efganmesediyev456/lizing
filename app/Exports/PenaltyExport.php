<?php

namespace App\Exports;

use App\Models\Penalty;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PenaltyExport implements FromCollection,WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = Penalty::query();
        if(request()->search){
            $s=request()->search;
            $query
            ->where('date','like',"$s")
            ->orWhere('penalty_code','like',"$s")
            ->orWhere('amount','like',"$s")
            ->orWhereHas('penaltyType',function($q) use($s){
                $q->where('title','like',"%$s%");
            });
        }
        return $query->get();
    }


    public function headings(): array{
        return [
            "NO",
            "Tarix",
            "Cərimə adı",
            "Cərimə kodu",
            "Məbləğ",
            "Status"
        ];
    }

    public function map($row):array{
        return [
            $row->id,
            $row->date,
            $row->penaltyType?->title,
            $row->penalty_code,
            $row->amount,
            $row->status_view
        ];
    }
}
