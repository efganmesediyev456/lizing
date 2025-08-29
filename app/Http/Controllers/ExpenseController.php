<?php

namespace App\Http\Controllers;

use App\DataTables\ExpenseDatatable;
use App\Exports\BrandExport;
use App\Exports\ExpenseExport;
use App\Models\Brand;
use App\Models\CashExpense;
use App\Models\Driver;
use App\Models\Expense;
use App\Models\Vehicle;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\DataTables\BrandsDataTable;
use Maatwebsite\Excel\Facades\Excel;


class ExpenseController extends Controller
{
    public function index()
    {
        $dataTable = new ExpenseDatatable(); 
        return $dataTable->render('expenses.index');
    }

    public function form(Expense $item,PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $formTitle = $item->id ? 'Xərc redaktə et' : 'Xərc əlavə et';
        $permissionService->checkPermission($action, 'brands');
        $vehicles = Vehicle::select(['id','state_registration_number'])->get();
        
        $view = view('expenses.form', compact('item','vehicles'))->render();

        return response()->json([
            "view" => $view,
            "formTitle"=>$formTitle,
            
        ]);
    }

    public function save(Request $request, Expense $item,PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'expenses');
        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'tableId' => 'required',
            'vehicle_id' => 'required|exists:vehicles,id',
            'total_expense' => 'required',
            'spare_part_payment' => 'required',
            'master_payment' => 'required',
        ]);

        try {
            DB::beginTransaction();

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors(),
                ], 422);
            }

            $data = $request->except('_token');

            $message = '';
            if ($item->id) {
                $item->update($data);
                $message = 'Uğurla dəyişiklik edildi';
            } else {
                $item = Expense::create($data);
                $message = 'Uğurla əlavə olundu';
            }

        
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
                'message' => 'System Error: '.$e->getMessage()
            ]);
        }
    }

    public function export(){
        return Excel::download(new ExpenseExport(),'expenses.xlsx');
    }


    public function show(Expense $item){
        return view('expenses.show',compact('item'));
    }


     public function expenseCreate(Request $request, PermissionService $permissionService)
    {
       
        // $validator = Validator::make($request->all(), [
        //     'date' => 'required',
        //     'tableId' => 'required',
        //     'vehicle_id' => 'required|exists:vehicles,id',
        //     'total_expense' => 'required',
        //     'spare_part_payment' => 'required',
        //     'master_payment' => 'required',
        // ]);

        
        try {
            DB::beginTransaction();

            // if ($validator->fails()) {
            //     return response()->json([
            //         'errors' => $validator->errors(),
            //     ], 422);
            // }

            $data = $request->except('_token');




            foreach ($data['expense'] as $id => $value) {
                $price = ($value !== null && $value !== '') ? $value : 0;

                CashExpense::updateOrCreate(
                    [
                        'expense_type_id' => $id,
                        'date' => now()->toDateString()
                    ],
                    [
                        'price' => $price
                    ]
                );
            }



           

        
            DB::commit();

            return redirect()->back()->withSuccess('Uğurla yaradıldı!');
        } catch (\Exception $e) {
            DB::rollBack();
                        return redirect()->back()->withErrors($e->getMessage());

        }
    }


}
