<?php

namespace App\Http\Controllers;

use App\Exports\VehicleExport;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Model;
use App\Models\OilChangeType;
use App\Models\OilType;
use App\Models\Vehicle;
use App\Models\VehicleStatus;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\DataTables\VehiclesDataTable;
use Maatwebsite\Excel\Facades\Excel;

class VehicleController extends Controller
{
    public function index()
    {
        $dataTable = new VehiclesDataTable(); 

        // filterOptions-ları datatable-dən çəkirik
        $filterOptions = $dataTable->getFilterOptions();

        return $dataTable->render('vehicles.index', compact('filterOptions'));
    }


    public function form(Vehicle $item,PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'vehicles');
        $formTitle = $item->id ? 'Avtomobil redaktə et' : 'Avtomobil əlavə et';
        $colors = Color::get();

        $brands= Brand::get();
        $models=Model::get();
        $oilTypes = OilType::all();
        $vehicleStatuses = VehicleStatus::get();
        $vehicleStatuses = VehicleStatus::get();
        
        
        $vehicleStatuses = VehicleStatus::get()
        ->toBase()
        ->merge([
            (object)[
                'id' => 'custom_null',
                'title' => 'Bizdə'
            ]
        ]);



        


        $view = view('vehicles.form', compact('item','colors', 'brands','models','oilTypes', 'vehicleStatuses'))->render();


        return response()->json([
            "view" => $view,
            "formTitle"=>$formTitle
        ]);
    }

    public function save(Request $request, Vehicle $item, PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'vehicles');

        $validator = Validator::make($request->all(), [
            // 'table_id_number' => [
            //     'required',
            //     'string',
            //     Rule::unique('vehicles', 'table_id_number')->ignore(optional($item)->id),
            // ],
            // 'vin_code' => [
            //     'required',
            //     'string',
            //     Rule::unique('vehicles', 'vin_code')->ignore(optional($item)->id),
            // ],
            // 'state_registration_number' => [
            //     'required',
            //     'string',
            //     Rule::unique('vehicles', 'state_registration_number')->ignore(optional($item)->id),
            // ],
            // 'production_year' => 'required|integer|min:1900|max:' . date('Y'),
            // 'purchase_price' => 'required|numeric|min:0',
            // 'mileage' => 'required|integer|min:0',
            // 'engine' => 'required|string|max:255',
            // 'oil_type_id' => 'required|exists:oil_types,id',
            // 'brand_id' => 'required|exists:brands,id',
            // 'model_id' => 'required|exists:models,id',
            // 'image'=>optional($item)->id ? 'sometimes':'required'
        ]);

        try {
            DB::beginTransaction();

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors(),
                ], 422);
            }

            $data = $request->except('_token',
            'insurance_end_date','insurance_company_name',
            'insurance_start_date','technical_start_date',
            'technical_end_date','technical_transmission_oil_suppliers',
            'insurance_fee','technical_review_fee'
        );


        if($request->vehicle_status_id=='custom_null'){
            $data['vehicle_status_id']=null;
        }else{
            $data['vehicle_status_id']=$request->vehicle_status_id;
        }
           

            if($request->hasFile('image')){
                $file = $request->file('image');
                $newFileName = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('vehicles', $newFileName, 'public');
                $data['image'] = $path;
            }

            

            $message = '';
            if ($item->id) {
                $item->update($data);
                $message = 'Uğurla dəyişiklik edildi';
            } else {
                $item = Vehicle::create($data);
                $message = 'Uğurla əlavə olundu';
            }


            
            $item->technicalReview()->updateOrCreate(
                ['vehicle_id' => $item->id], 
                [
                    'start_date' => $request->technical_start_date,
                    'end_date'   => $request->technical_end_date,
                    'transmission_oil_suppliers' => $request->technical_transmission_oil_suppliers,
                    'technical_review_fee'=>$request->technical_review_fee
                ]
            );


             $item->insurance()->updateOrCreate(
                ['vehicle_id' => $item->id], 
                [
                    'start_date' => $request->insurance_start_date,
                    'end_date'   => $request->insurance_end_date,
                    'company_name' => $request->insurance_company_name,
                    'insurance_fee'=>$request->insurance_fee

                ]
            );


            

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

    public function export(){
        return Excel::download(new VehicleExport,'vehicles.xlsx');
    }
}
