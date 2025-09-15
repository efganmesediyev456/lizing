<?php

namespace App\Http\Controllers;

use App\DataTables\CashboxDatatable;
use App\Exports\BrandExport;
use App\Exports\CashboxExport;
use App\Helpers\CashboxHelper;
use App\Models\Brand;
use App\Models\CashExpense;
use App\Models\Driver;
use App\Models\Expense;
use App\Models\ExpenseType;
use App\Models\Vehicle;
use App\Services\PermissionService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\DataTables\BrandsDataTable;
use Maatwebsite\Excel\Facades\Excel;


class CashboxController extends Controller
{
    public function index()
    {
        $dataTable = new CashboxDatatable();
        $elshadGoturen = ExpenseType::where('is_elshad_take', 1)->first();

        $date = request()->date
            ? Carbon::parse(request()->date)->toDateString()
            : Carbon::today()->toDateString();

        CashExpense::where('date', $date)->where('expense_type_id', $elshadGoturen->id)->delete();

        $expenseTypes = ExpenseType::orderBy('position')->whereStatus(1)->orderBy('id', 'asc')->get();

        $generalPaymentPriceOnlayn = CashboxHelper::cashboxPayments()->where('payment_back_or_app', 0)->sum(function ($item) {
            return $item->getRawOriginal('price');
        });

        //online odenis elave etme
        $onlineExpense = ExpenseType::where('is_online', 1)->first();

        CashExpense::updateOrCreate([
            'date' => $date,
            'expense_type_id' => $onlineExpense->id
        ], [
            'date' => $date,
            'expense_type_id' => $onlineExpense->id,
            'price' => $generalPaymentPriceOnlayn
        ]);

        //online odenis elave etme



        $generalPaymentPriceOffline = CashboxHelper::cashboxPayments()->where('payment_back_or_app', 1)->sum(function ($item) {
            return $item->getRawOriginal('price');
        });


        // offline odenis elave etme
        $offlineExpense = ExpenseType::where('is_offline_payment', 1)->first();

        CashExpense::updateOrCreate([
            'date' => $date,
            'expense_type_id' => $offlineExpense->id
        ], [
            'date' => $date,
            'expense_type_id' => $offlineExpense->id,
            'price' => $generalPaymentPriceOffline
        ]);

        // offline odenis elave etme


        
        $autoExpenses = Expense::whereDate('created_at', $date)->sum('total_expense');



        $expenseTypesPrices = $expenseTypes->filter(fn($type) => $type->type == 0)->mapWithKeys(function ($type) use ($date) {
            $price = CashExpense::where('expense_type_id', $type->id)
                ->whereDate('date', $date)
                ->sum('price');
            return [$type->id => $price];
        })->sum();





        $insurancePrices = $expenseTypes->filter(fn($type) => $type->type == 1)->mapWithKeys(function ($type) use ($date, $offlineExpense, $onlineExpense, $elshadGoturen) {
            $price = CashExpense::where('expense_type_id', $type->id)
                ->whereDate('date', $date)->
                whereNotIn('expense_type_id', [$offlineExpense->id, $onlineExpense->id, $elshadGoturen->id])
                ->sum('price');
            return [$type->id => $price];
        })->sum();







        $totalExpense = $autoExpenses + $expenseTypesPrices;
        $totalInsurance = $insurancePrices + $generalPaymentPriceOnlayn + $generalPaymentPriceOffline;
        $totalCashboxPrice = $totalInsurance - $totalExpense;

        $elshadGoturenPrice = $totalInsurance - $totalExpense;





        if ($elshadGoturenPrice > 0) {
            CashExpense::updateOrCreate(
                [
                    'date' => $date,
                    'expense_type_id' => $elshadGoturen->id
                ],
                [
                    'price' => $elshadGoturenPrice
                ]
            );
        }




        $elshadVeren = ExpenseType::where('is_elshad_given', 1)->first();
        $elshadVeren = $elshadVeren->todayValue()?->price;
        $tam = $insurancePrices + $generalPaymentPriceOnlayn + $generalPaymentPriceOffline;


        $autoExpenses = Expense::whereDate('created_at', $date)->sum('total_expense');


        $expenseTypesPrices = $expenseTypes->filter(fn($type) => $type->type == 0)
            ->mapWithKeys(function ($type) use ($date) {
                $price = CashExpense::where('expense_type_id', $type->id)
                    ->whereDate('date', $date)
                    ->sum('price');
                return [$type->id => $price];
            })->sum();



        $insurancePrices = $expenseTypes->filter(fn($type) => $type->type == 1)
            ->mapWithKeys(function ($type) use ($date, $offlineExpense, $onlineExpense) {
                $price = CashExpense::where('expense_type_id', $type->id)
                    ->whereDate('date', $date)
                    ->whereNotIn('expense_type_id', [$offlineExpense->id, $onlineExpense->id])
                    ->sum('price');
                return [$type->id => $price];
            })->sum();



        $totalExpense = $autoExpenses + $expenseTypesPrices;
        $totalInsurance = $insurancePrices + $generalPaymentPriceOnlayn + $generalPaymentPriceOffline;
        $totalCashboxPrice = $totalInsurance - $totalExpense;


        return $dataTable->render('cashbox.index', compact('expenseTypes', 'tam', 'generalPaymentPriceOnlayn', 'generalPaymentPriceOffline', 'totalCashboxPrice', 'totalExpense', 'totalExpense', 'autoExpenses', 'autoExpenses', 'totalInsurance'));
    }



    public function export()
    {
        return Excel::download(new CashboxExport(), 'cashbox.xlsx');
    }

    public function show($item, Request $request)
    {
        $model = app($request->model);
        $item = $model::find($item);
        return view('cashbox.show', compact('item'));
    }


    public function form(CashExpense $item, PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $formTitle = $item->id ? 'Redaktə et' : 'Əlavə et';
        $permissionService->checkPermission($action, 'cashbox');
        $expenseTypes = ExpenseType::where('status', 1)->orderBy('id', 'asc')->get();

        $view = view('cashbox.form', compact('item', 'expenseTypes'))->render();

        return response()->json([
            "view" => $view,
            "formTitle" => $formTitle,
        ]);
    }


    public function save(Request $request, CashExpense $item, PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'cashbox');
        $validator = Validator::make($request->all(), [
            'expense_type_id' => 'required',
            'price' => 'required'
        ]);

        try {
            DB::beginTransaction();

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors(),
                ], 422);
            }

            $data = $request->except('_token');

            $data['date'] = now();




            $item->updateOrCreate(['date' => now()->toDateString(), 'expense_type_id' => $request->expense_type_id], $data);

            $message = 'Uğurlu əməliyyat!';

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'view' => '',
                'errors' => true,
                'message' => 'System Error: ' . $e->getMessage()
            ]);
        }
    }
}
