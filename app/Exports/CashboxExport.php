<?php

namespace App\Exports;

use App\Helpers\CashboxHelper;
use App\Models\Brand;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CashboxExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $cashboxes = CashboxHelper::all();
        $search = request('search');
        if ($search) {
            $cashboxes = $cashboxes->filter(function ($item) use ($search) {
                $state_registration_number = $item->leasing?->vehicle?->state_registration_number;
                if (is_null($state_registration_number)) {
                    $state_registration_number = $item->vehicle?->state_registration_number;
                }
                return str_contains(strtolower($item->tableId), strtolower($search))
                    || str_contains(strtolower($item->category), strtolower($search))
                    || str_contains(strtolower($item->type), strtolower($search))
                    || str_contains(strtolower($item->price), strtolower($search))
                    || str_contains(strtolower($state_registration_number), strtolower($search))
                    || str_contains(strtolower($item->created_at->format('d.m.Y')), strtolower($search));
            });
        }
        return $cashboxes;
    }

    public function headings(): array
    {
        return [
            "No",
            "Tarix",
            "Table İD",
            "D.Q.N.",
            "Kateqoriya",
            "Növ",
            "Məbləğ"
        ];
    }

    public function map($item): array
    {
        return [
            $item->id,
            $item->created_at->format('Y-m-d'),
            $item->tableId,
            $item->leasing?->vehicle?->state_registration_number ?? $item->vehicle?->state_registration_number,
            $item->category,
            $item->type,
            $item->price ?? $item->technical_review_fee ?? $item->insurance_fee,
            $item->note
        ];
    }
}
