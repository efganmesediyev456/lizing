<?php
// app/Services/CashboxService.php
namespace App\Services;

use App\Models\CashExpense;
use App\Models\CashReport;
use App\Models\Payment;
use App\Models\Expense;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CashboxService
{
    public function liveSummaryForDate(string|\DateTimeInterface $date)
    {
        $date = Carbon::parse($date)->startOfDay();

       
        $paymentsQ = Payment::query()
    ->rightJoin('leasings', 'leasings.id', '=', 'payments.leasing_id')
    ->rightJoin('vehicles', 'vehicles.id', '=', 'leasings.vehicle_id')
    ->where(function ($q) use ($date) {
        $q->whereDate('payments.created_at', $date)
          ->orWhereNull('payments.created_at');
    })
    ->whereNull('payments.report_id')
    ->select('vehicles.id', 'vehicles.table_id_number', DB::raw('MAX(payments.id) as payment_id'))
    ->groupBy('vehicles.id', 'vehicles.table_id_number');


        $vehicleRows = $paymentsQ->clone()
            ->selectRaw('vehicles.id as vehicle_id, ANY_VALUE(payments.driver_id) as driver_id, vehicles.table_id_number,
                         payments.payment_back_or_app,
                         SUM(payments.price) as total')
            ->groupBy('vehicles.id','vehicles.table_id_number','payments.payment_back_or_app')
            ->get()
            ->groupBy('vehicle_id')
            ->map(function($rows){
                $plate = $rows->first()->table_id_number;
                $cash = (float)($rows->firstWhere('payment_back_or_app',1)->total ?? 0);
                $online = (float)($rows->firstWhere('payment_back_or_app',0)->total ?? 0);
                return [
                    'table_id_number' => $plate,
                    'vehicle_name'=>$rows->first()->vehicle?->state_registration_number,
                    'driver_name'=>$rows->first()->driver?->fullName,
                    'cash' => $cash,
                    'online' => $online,
                    'total' => $cash + $online,
                    
                ];
            })->values();

        // Ümumi gəlir
        $incomeCash   = (float) Payment::whereDate('created_at',$date)->whereNull('report_id')->where('payment_back_or_app',0)->sum('price');
        $incomeOnline = (float) Payment::whereDate('created_at',$date)->whereNull('report_id')->where('payment_back_or_app',1)->sum('price');
        $incomeTotal  = $incomeCash + $incomeOnline;

        // Xərclər
        $expenseTotal   = (float) CashExpense::whereDate('created_at',$date)->whereNull('cash_report_id')->sum('price');

        return [
            'date' => $date->toDateString(),
            'vehicles' => $vehicleRows,
            'income' => [
                'cash' => $incomeCash,
                'online' => $incomeOnline,
                'total' => $incomeTotal,
            ],
            'expense' => [
                'total' => $expenseTotal,
            ],
            'net_total' => $incomeTotal + $expenseTotal,
        ];
    }

    public function closeDay(string|\DateTimeInterface $date, ?int $userId = null): CashReport
    {
        $date = Carbon::parse($date)->startOfDay();

        return DB::transaction(function() use($date, $userId) {
            $report = CashReport::firstOrCreate(
                ['report_date' => $date->toDateString()],
                ['status'=>'open','opened_at'=>now()]
            );

            $summary = $this->liveSummaryForDate($date);


            $report->fill([
                'income_cash'   => $summary['income']['cash'],
                'income_online' => $summary['income']['online'],
                'income_total'  => $summary['income']['total'],
                'expense_total' => $summary['expense']['total'],
                'net_total'     => $summary['net_total'],
                'status'        => 'closed',
                'closed_at'     => now(),
            ])->save();

            Payment::whereDate('created_at',$date)
                   ->whereNull('report_id')
                   ->update(['report_id'=>$report->id]);

            Expense::whereDate('created_at',$date)
                   ->whereNull('report_id')
                   ->update(['report_id'=>$report->id]);

            CashExpense::where('date', $date)->whereNull('cash_report_id')->update([
                'cash_report_id'=>$report->id
            ]);

            return $report->fresh();
        });
    }
}
