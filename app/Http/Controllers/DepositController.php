<?php

namespace App\Http\Controllers;

use App\DataTables\CreditDatatable;
use App\DataTables\DepositDatatable;
use App\Events\DriverNotified;
use App\Exports\DepositExport;
use App\Http\Requests\DriverNotificationRequest;
use App\Models\Brand;
use App\Models\City;
use App\Models\Credit;
use App\Models\Driver;
use App\Models\DriverNotification;
use App\Models\DriverNotificationTopic;
use App\Models\Leasing;
use App\Models\LeasingStatus;
use App\Models\Model;
use App\Models\Payment;
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

class DepositController extends Controller
{


   
    
    public function index()
    {
        $dataTable = new DepositDatatable(); 
        $filterOptions = $dataTable->getFilterOptions();
        return $dataTable->render('deposits.index',['filterOptions'=>$filterOptions]);
    }

    public function form(Credit $item, PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'credits');
        $formTitle = $item->id ? 'Depozit redaktə et' : 'Depozit əlavə et';

     
        $brands=Brand::get();
        $dqns=Vehicle::get()->pluck('state_registration_number','id');
        $models=Model::get();
        

        $view = view('deposits.form', compact('item','brands','dqns','models'))->render();

        return response()->json([
            "view" => $view,
            "formTitle" => $formTitle
        ]);
    }

    public function save(Request $request, Payment $item, PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'drivers');
       
        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'name' => 'required',
            'vehicle_id' => 'required',
            'brand_id' => 'required',
            'model_id' => 'required',
            'tableId' => 'required',
            'price' => 'required',
            'deposit_debt' => 'required',
            'notes' => 'required',
            'leasing_id'=>'required'
        ]);

        try {
            DB::beginTransaction();

            $leasing = Leasing::find($request->leasing_id);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors(),
                ], 422);
            }

            if($leasing->deposit_payment>0 and $leasing->deposit_payment > $request->price){
                $leasing->deposit_payment=$leasing->deposit_payment-$request->price;
            }elseif($leasing->deposit_payment>0 and $leasing->deposit_payment <= $request->price){
                $dec = $request->price - $leasing->deposit_payment;
                $leasing->deposit_payment=0;
                $leasing->deposit_debt=$leasing->deposit_debt-$dec;
            }elseif($leasing->deposit_payment==0 and $leasing->deposit_debt>0){
                $leasing->deposit_debt=$leasing->deposit_debt-$request->price;
            }
            $leasing->save();

            $data = $request->except('date','vehicle_id','name','brand_id','model_id','tableId','deposit_debt');
            $data['payment_type']='deposit_admin';
            $message = '';

            if ($item->id) {
                $item->update($data);
                $message = 'Uğurla dəyişiklik edildi';
            } else {
                $item = Payment::create($data);
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


    public function show(Payment $item){
        return view('deposits.show',compact('item'));
    }



    public function export()
    {
        return Excel::download(new DepositExport(), 'deposits.xlsx');
    }



   
}
