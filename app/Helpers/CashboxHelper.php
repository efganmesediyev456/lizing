<?php

namespace App\Helpers;

use App\Models\CashExpense;
use App\Models\Expense;
use App\Models\Insurance;
use App\Models\Payment;
use App\Models\TechnicalReview;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CashboxHelper
{
    public static function cashboxPayments()
    {
        $date = request()->date
            ? Carbon::parse(request()->date)->toDateString()
            : Carbon::today()->toDateString();

        $payments = Payment::with('leasing')
            ->whereDate('created_at', $date)
            ->get()
            ->map(function ($payment) {
                $clone = clone $payment;
                return $clone->forceFill([
                    'tableId' => $payment->leasing->tableId ?? null,
                    'category' => 'Ödəniş',
                    'type' => 'Gəlir',
                    'price' => '+' . $payment->price . ' azn',
                    'model' => 'payment'
                ]);
            });

        return $payments;
    }

    public static function all(): Collection
    {
        $date = request()->date
            ? Carbon::parse(request()->date)->toDateString()
            : Carbon::today()->toDateString();

        $insurances = Insurance::select(
            'id',
            'tableId',
            'vehicle_id',
            'id as amount',
            'created_at',
            DB::raw("'Siğorta' as category"),
            DB::raw("'insurance' as model"),
            DB::raw("'Xərc' as type"),
            DB::raw("concat('-',insurance_fee,' azn') as price"),
        )
            ->whereDate('updated_at', $date)
            ->whereDate('start_date', $date)
            ->get();

        $technicalReviews = TechnicalReview::select(
            'id',
            'tableId',
            'vehicle_id',
            'id as amount',
            'created_at',
            DB::raw("'Texniki baxış' as category"),
            DB::raw("'technical' as model"),
            DB::raw("'Xərc' as type"),
            DB::raw("concat('-',technical_review_fee,' azn') as price"),
        )
            ->whereDate('updated_at', $date)
            ->whereDate('start_date', $date)
            ->get();

        $payments = Payment::with('leasing')
            ->whereDate('created_at', $date)
            ->get()
            ->map(function ($payment) {
                $clone = clone $payment;
                return $clone->forceFill([
                    'tableId' => $payment->leasing->tableId ?? null,
                    'category' => 'Ödəniş',
                    'type' => 'Gəlir',
                    'price' => '+' . $payment->price . ' azn',
                    'model' => 'payment'
                ]);
            });


        $casboxses = CashExpense::whereDate('date', $date)
            ->get()
            ->map(function ($payment) {
                $clone = clone $payment;
                return $clone->forceFill([
                    'tableId' => '',
                    'category' => $payment->expenseType?->title,
                    'type' => $payment->expenseType?->type_text,
                    'price' => $payment->expenseType?->type_show . $payment->price . ' azn',
                    'model' => 'cashbox_expense'
                ]);
            });



        $autoExpenseTotal = Expense::whereDate('created_at', $date)->sum('total_expense');

        return $casboxses
            ->concat($insurances)
            ->concat($technicalReviews)
            ->concat($payments)
            ->when($autoExpenseTotal > 0, function ($collection) use ($autoExpenseTotal) {
                return $collection->concat([
                    (new CashExpense())->forceFill([
                        'tableId' => '',
                        'category' => 'Avtomobil Xərcləri',
                        'type' => 'Xərc',
                        'price' => '-' . $autoExpenseTotal . ' azn',
                        'model' => 'auto_expense',
                        'created_at' => now()
                    ])
                ]);
            })
            ->sortByDesc('created_at')
            ->values();

    }



    public static function onlyInsurancesAndTechnicalReviews()
    {
        $insurances = Insurance::select(
            'id',
            'tableId',
            'vehicle_id',
            'id as amount',
            'created_at',
            'created_at as date',
            DB::raw("'Siğorta' as category"),
            DB::raw("'insurance' as model"),
            DB::raw("'Xərc' as type"),


            DB::raw("concat('Siğorta', ' Xərc') as note"),

            DB::raw("concat(insurance_fee,' azn') as total_expense"),
        )->get();

        $technicalReviews = TechnicalReview::select(
            'id',
            'tableId',
            'vehicle_id',
            'id as amount',
            'created_at',
            'created_at as date',
            DB::raw("'Texniki baxış' as category"),
            DB::raw("'technical' as model"),
            DB::raw("'Xərc' as type"),
            DB::raw("concat(technical_review_fee,' azn') as total_expense"),
            DB::raw("concat('Texniki baxış', ' Xərc') as note"),

        )->get();

        return $insurances
            ->concat($technicalReviews)
            ->sortByDesc('created_at')
            ->values();
    }
}
