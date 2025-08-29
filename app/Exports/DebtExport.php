<?php

namespace App\Exports;

use App\Models\Debt;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DebtExport implements FromCollection,WithMapping,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = Debt::query();
        $search = request()->search;
        if($search){
            $query->where('date', 'like',"%$search%")
            ->orWhere("tableId","like","%$search%")
            ->orWhereHas("vehicle", function($qq)use($search){
                $qq->where("state_registration_number","like","%$search%");
            })
            ->orWhere("spare_part_title","like","%$search%")
            ->orWhere("price","like","%$search%");
        }
        return $query->get();
    }

    public function headings(): array{
      return [
          "No",
          "Tarix",
          "Table İD",
          "D.Q.N.",
          "Ehtiyyat hissəsinin adı",
          "Qiymət"
      ];
    }

    public function map($row): array{
        return [
            $row->id,
            $row->date,
            $row->tableId,
            $row->vehicle?->state_registration_number,
            $row->spare_part_title,
            $row->price
        ];
    }
}
