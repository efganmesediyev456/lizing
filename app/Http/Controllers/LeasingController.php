<?php

namespace App\Http\Controllers;

use App\DataTables\LeasingDatatable;
use App\Models\Brand;
use App\Models\Driver;
use App\Models\Leasing;
use App\Models\Model;
use App\Models\OilChangeType;
use App\Models\OilType;
use App\Models\Vehicle;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\DataTables\VehiclesDataTable;

class LeasingController extends Controller
{
    public function index()
    {
        $dataTable = new LeasingDatatable(); 
        return $dataTable->render('leasings.index');
    }

    public function form(Leasing $item,PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'leasing');
        $brands=Brand::get();
        $drivers=Driver::get();
        $dqns=Vehicle::get()->pluck('state_registration_number','id');
        $models=Model::get();

        $view = view('leasings.form', compact('item','brands','drivers','dqns','models'))->render();

        return response()->json([
            "view" => $view
        ]);
    }

    public function save(Request $request, Leasing $item, PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'leasing');

        $validator = Validator::make($request->all(), [
            'tableId' => 'required',
            'fin' => 'required',
            'driver_id' => 'required|exists:drivers,id',
            'has_advertisement' => 'required',
            'deposit_payment' => 'required',
            'deposit_price' => 'required',
            'deposit_debt' => 'required',
            'vehicle_id' => 'required|exists:vehicles,id',
            'leasing_price' => 'required',
            'daily_payment' => 'required',
            'monthly_payment' => 'required',
            'leasing_period_days' => 'required',
            'leasing_period_months' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'upload' => 'required',
            'brand_id' => 'required|exists:brands,id',
            'model_id' => 'required|exists:models,id',
        ]);

        try {
            DB::beginTransaction();

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors(),
                ], 422);
            }

            $data = $request->except('_token','fin','status','upload');


            $message = '';
            if ($item->id) {
                $item->update($data);
                $message = 'Uğurla dəyişiklik edildi';
            } else {
                $item = Leasing::create($data);
                $message = 'Uğurla əlavə olundu';
            }


            if($request->hasFile('upload')){
                $file = $request->file('upload');
                $newFileName = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('leasings', $newFileName, 'public');
                $data['file']=$path;
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

     public function show(Leasing $item){
      
        return view('leasings.show',compact('item'));
    }
}
