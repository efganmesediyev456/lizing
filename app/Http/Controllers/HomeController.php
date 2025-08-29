<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Driver;
use App\Models\Leasing;
use App\Models\LeasingPayment;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\DataTables\DriversDataTable;

class HomeController extends Controller
{
    public function dashboard()
    {
        $today = Carbon::today();

    
        $newUsersCount = User::whereDate('created_at', '>=', now()->subDays(30))->count();
        $oldUsersCount = User::whereDate('created_at', '<', now()->subDays(30))->count();
        $userDiff = $this->calculateChange($newUsersCount, $oldUsersCount);



        $activeLeasingsCount = Leasing::count();
        $newUsersCount = Leasing::whereDate('created_at', '>=', now()->subDays(30))->count();
        $oldUsersCount = Leasing::whereDate('created_at', '<', now()->subDays(30))->count();
        $leasingDiff = $this->calculateChange($newUsersCount, $oldUsersCount);



    

        $currentTotalPayment = Payment::whereBetween('created_at', [
            $today->copy()->subDays(6), $today->copy()->endOfDay()
        ])->sum('price');
        $currentAvgDailyPayment = round($currentTotalPayment / 7, 2);

        $previousTotalPayment = Payment::whereBetween('created_at', [
            $today->copy()->subDays(13), $today->copy()->subDays(7)->endOfDay()
        ])->sum('price');
        $prevAvgDailyPayment = round($previousTotalPayment / 7, 2);

        $averagePaymentDiff = $this->calculateChange($currentAvgDailyPayment, $prevAvgDailyPayment);






        $paymentQuery = Payment::whereDate('created_at', $today);
        $todayPayments = $paymentQuery->sum('price');
        $yesterdayPayments = Payment::whereDate('created_at', $today->copy()->subDay())->sum('price');
        $todayPaymentDiff = $this->calculateChange($todayPayments, $yesterdayPayments);


        $paymentDrivers = $paymentQuery->get()->unique('driver_id')->map(function($dr){
            return $dr->driver;
        });





         $stats = [
            [
                'title' => 'Yeni istifadəçilər(sürücülər)',
                'count' => $newUsersCount,
                'diff' => $userDiff,
                'icon' => 'dashboard-box1.svg',
            ],
            [
                'title' => 'Aktiv Lizing Sayı',
                'count' => $activeLeasingsCount,
                'diff' => $leasingDiff,
                'icon' => 'dashboard-box2.svg',
            ],
            [
                'title' => 'Orta Gündəlik Ödəniş',
                'count' => number_format($currentAvgDailyPayment, 2) . ' AZN',
                'diff' => $averagePaymentDiff,
                'icon' => 'dashboard-box3.svg',
            ],
            [
                'title' => 'Bu Günün Ödənişləri',
                'count' => number_format($todayPayments, 2) . ' AZN',
                'diff' => $todayPaymentDiff,
                'icon' => 'dashboard-box4.svg',
            ],
        ];
        

        $paymentsDueTodays = Driver::get()->filter(function($driver){
            return $driver->leasing && $driver->debt > 0;
        });


        $paymentsOverdues = LeasingPayment::whereDate('payment_date', '<', $today)
        ->where('status', 'pending')
        ->get()->unique('driver_id');

      
        $documentIsPendings = Driver::
        where('drivers_license_front')->
        orWhere('drivers_license_back')->
        orWhere('id_card_front')->
        orWhere('id_card_back')->get();

        return view('dashboard', compact('stats', 'paymentsDueTodays', 'paymentDrivers','documentIsPendings', 'paymentsOverdues'));
    }


    private function calculateChange($current, $previous)
    {
        if ($previous == 0) return ['status' => 'static', 'percent' => 0];

        $diff = $current - $previous;
        $percent = round(($diff / $previous) * 100, 2);

        if ($diff > 0) return ['status' => 'increase', 'percent' => $percent];
        elseif ($diff < 0) return ['status' => 'decrease', 'percent' => abs($percent)];
        else return ['status' => 'static', 'percent' => 0];
    }


    public function getMonthlyPayments(Request $request)
    {
        $year = $request->year ?? now()->year;

        $monthlyPayments = Payment::selectRaw('MONTH(created_at) as month, SUM(price) as total')
            ->whereYear('created_at', $year)
            ->groupByRaw('MONTH(created_at)')
            ->pluck('total', 'month');

        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $data[] = round($monthlyPayments[$i] ?? 0, 2);
        }

        return response()->json($data);
    }

}
