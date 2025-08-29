<?php

namespace App\Exports;

use App\Helpers\CashboxHelper;
use App\Models\Brand;
use App\Models\Expense;
use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RevenueExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $items = Payment::where('status','completed')->get();

        if ($search = request()->search ?? null) {
            $items = $items->filter(function($item) use ($search) {
                $fullName = $item->leasing->driver?->fullName ?? '';
                $state_registration_number = $item->leasing?->vehicle?->state_registration_number;
                return stripos($fullName, $search) !== false
                    || stripos($item->updated_at, $search) !== false
                    || stripos($state_registration_number, $search) !== false;
            });
        }
        return $items;

    }

    public function headings(): array
    {
        return [
            "No",
            "Tarix",
            "Ad soyad",
            "D.Q.N.",
            "Gəlir",
        ];
    }

    public function map($item): array
    {
        return [
            $item->id,
            $item->updated_at?->format('Y-m-d') ,
            $item->leasing->driver?->fullName,
            $item->leasing?->vehicle?->state_registration_number,
            $item->price,
        ];
    }
}
