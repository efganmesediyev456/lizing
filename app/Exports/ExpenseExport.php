<?php

namespace App\Exports;

use App\Helpers\CashboxHelper;
use App\Models\Brand;
use App\Models\Expense;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExpenseExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Expense::orderBy('id', 'desc')->get();
        $query2= CashboxHelper::onlyInsurancesAndTechnicalReviews();
        $merged = $query->merge($query2); 

        if ($search = request()->search) {
            $merged = $merged->filter(function ($item) use ($search) {
                $stateRegNum = $item->vehicle?->state_registration_number ?? '';
                $totalExpense = $item->vehicle?->state_registration_number ?? '';

                return stripos($item->tableId, $search) !== false
                    || stripos($stateRegNum, $search) !== false
                    || stripos($item->total_expense, $search) !== false
                    || stripos($item->note, $search) !== false;
            });
        }
        return $merged;

    }

    public function headings(): array
    {
        return [
            "No",
            "Tarix",
            "Table İD",
            "D.Q.N.",
            "Ümumi xərc",
            "Məlumat",
            "Ehtiyyat hissesi odənişi",
            "Usta odənişi"
        ];
    }

    public function map($item): array
    {
        return [
            $item->id,
            $item->created_at?->format('Y-m-d') ,
            $item->tableId,
            $item->vehicle?->state_registration_number,
            $item->total_expense,
            $item->note,
            $item->spare_part_payment,
            $item->master_payment
        ];
    }
}
