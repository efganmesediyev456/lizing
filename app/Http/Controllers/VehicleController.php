<?php

namespace App\Http\Controllers;

use App\Models\Brand;
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

class VehicleController extends Controller
{
    public function index()
    {
        $dataTable = new VehiclesDataTable(); 
        return $dataTable->render('vehicles.index');
    }

    public function form(Vehicle $item,PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'vehicles');

        $brands= Brand::get();
        $models=Model::get();
        $oilTypes = OilType::all();
        $view = view('vehicles.form', compact('item', 'brands','models','oilTypes'))->render();


        return response()->json([
            "view" => $view
        ]);
    }

    public function save(Request $request, Vehicle $item, PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'vehicles');

        $validator = Validator::make($request->all(), [
            'table_id_number' => [
                'required',
                'string',
                Rule::unique('vehicles', 'table_id_number')->ignore(optional($item)->id),
            ],
            'vin_code' => [
                'required',
                'string',
                Rule::unique('vehicles', 'vin_code')->ignore(optional($item)->id),
            ],
            'state_registration_number' => [
                'required',
                'string',
                Rule::unique('vehicles', 'state_registration_number')->ignore(optional($item)->id),
            ],
            'production_year' => 'required|integer|min:1900|max:' . date('Y'),
            'purchase_price' => 'required|numeric|min:0',
            'mileage' => 'required|integer|min:0',
            'engine' => 'required|string|max:255',
            'oil_type_id' => 'required|exists:oil_types,id',
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

            $data = $request->except('_token');


            $message = '';
            if ($item->id) {
                $item->update($data);
                $message = 'Uğurla dəyişiklik edildi';
            } else {
                $item = Vehicle::create($data);
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

     public function show(Vehicle $item){
      
        return view('vehicles.show',compact('item'));
    }
}
