<?php

namespace App\Exports;

use App\Models\OilChange;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OilChangeExport implements FromCollection,WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return OilChange::all();
    }

    public function headings(): array{
        return [
            "No",
            "Table İD",
            "D.Q.N.",
            "Y.D. km",
            "N.Y.D.",
            "Status"
        ];
    }
}
