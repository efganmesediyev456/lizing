<?php

namespace App\Http\Controllers;

use App\DataTables\CreditDatatable;
use App\DataTables\DebtDatatable;
use App\Events\DriverNotified;
use App\Exports\DebtExport;
use App\Http\Requests\DriverNotificationRequest;
use App\Models\Brand;
use App\Models\City;
use App\Models\Credit;
use App\Models\Debt;
use App\Models\Driver;
use App\Models\DriverNotification;
use App\Models\DriverNotificationTopic;
use App\Models\Model;
use App\Models\Vehicle;
use App\Services\PermissionService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\DataTables\DriversDataTable;
use Maatwebsite\Excel\Facades\Excel;


class DebtController extends Controller
{


   
    
    public function index()
    {
        $dataTable = new DebtDatatable(); 
        return $dataTable->render('debts.index');
    }

    public function form(Debt $item, PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'debts');

        $brands=Brand::get();
        $dqns=Vehicle::get()->pluck('state_registration_number','id');
        $models=Model::get();
        $formTitle = $item->id ? 'Borc redaktə et' : 'Borc əlavə et';
        $vehicles = Vehicle::get();

        $view = view('debts.form', compact('item','brands','dqns','models', 'vehicles'))->render();

        return response()->json([
            "view" => $view,
            "formTitle" => $formTitle
        ]);
    }

    public function save(Request $request, Debt $item, PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'debts');
       
        $validator = Validator::make($request->all(), [
            'tableId' => 'required',
            'date' => 'required',
            'brand_id' => 'required',
            'model_id' => 'required',
            'vehicle_id' => 'required',
            'production_year' => 'required',
            'spare_part_title' => 'required',
            'price' => 'required',
            'price_payment' => 'required',
        ]);

        try {
            DB::beginTransaction();

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors(),
                ], 422);
            }

            $data = $request->all();
            
            $message = '';
            if ($item->id) {
                $item->update($data);
                $message = 'Uğurla dəyişiklik edildi';
            } else {
                $item = Debt::create($data);
                $message = 'Uğurla əlavə olundu';
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message'=> $message
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


    public function show(Debt $item){
        return view('debts.show',compact('item'));
    }

    public function export() 
    {
        return Excel::download(new DebtExport, 'debts.xlsx');
    }

}
