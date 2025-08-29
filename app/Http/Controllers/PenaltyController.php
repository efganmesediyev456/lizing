<?php

namespace App\Http\Controllers;

use App\DataTables\ModelDatatable;
use App\DataTables\OilChangeTypeDatatable;
use App\DataTables\PenaltyDatatable;
use App\Exports\PenaltyExport;
use App\Models\BanType;
use App\Models\Brand;
use App\Models\Driver;
use App\Models\Model;
use App\Models\OilChangeType;
use App\Models\Penalty;
use App\Models\PenaltyPayment;
use App\Models\PenaltyType;
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


class PenaltyController extends Controller
{
    public function index()
    {
        $dataTable = new PenaltyDatatable(); 
        return $dataTable->render('penalties.index');
    }

    public function form(Vehicle $vehicle,Penalty $item, PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'penalties');
        $formTitle = $item->id ? 'Cərimə redaktə et' : 'Cərimə əlavə et';

        $penaltiesTypes = PenaltyType::get();
        $view = view('penalties.form', compact('item', 'penaltiesTypes'))->render();

        return response()->json([
            "view" => $view,
            "formTitle"=>$formTitle
        ]);
    }

    public function payment(Vehicle $vehicle,Penalty $penalty, PermissionService $permissionService)
    {
        // $action = $item->id ? 'edit' : 'create';
        // $permissionService->checkPermission($action, 'penalties.payments');
        $item = $penalty->penaltyPayment;
        $formTitle = $item?->id ? 'Ödəniş redaktə et' : 'Ödəniş əlavə et';


        $view = view('penalties.paymentForm', compact('item', 'penalty'))->render();

        return response()->json([
            "view" => $view,
            "formTitle" =>$formTitle
        ]);
    }

    public function save(Request $request, Vehicle $vehicle, Penalty $item, PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'penalties');
        

        $validator = Validator::make($request->all(), [
            'penalty_type_id' => 'required|exists:penalty_types,id',
            'date' => 'required',
            'penalty_code' => 'required',
            'amount' => 'required',
            'status' => 'required',
            'note' => 'required',
        ]);


        try {
            DB::beginTransaction();

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors(),
                ], 422);
            }

            $data = $request->except('_token');
            $data['vehicle_id']=request()->vehicle?->id;


            $message = '';
            if ($item->id) {
                $item->update($data);
                $message = 'Uğurla dəyişiklik edildi';
            } else {
                $item = Penalty::create($data);
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


     public function savePayment(Request $request, Vehicle $vehicle, Penalty $penalty, PermissionService $permissionService)
    {
        

        // $action = $item->id ? 'edit' : 'create';
        // $permissionService->checkPermission($action, 'penalties.payments');
        
        $item = $penalty->penaltyPayment;

        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'amount' => 'required',
            'note' => 'required'
        ]);

        


        try {
            DB::beginTransaction();

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors(),
                ], 422);
            }

            $data = $request->except('_token');
            $data['penalty_id'] = $penalty->id;

            $message = '';
            if ($item?->id) {
                
                $item->update($data);

                $message = 'Uğurla dəyişiklik edildi';
            } else {
                $item = PenaltyPayment::create($data);
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
    public function show(Vehicle $vehicle,Penalty $item){
        return view('penalties.show',compact('item'));
    }


    public function export(){
        return Excel::download(new PenaltyExport,'penalty_export.xlsx');
    }
}
