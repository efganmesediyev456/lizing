<?php

namespace App\Http\Controllers;

use App\DataTables\InsurancesDatatable;
use App\DataTables\ModelDatatable;
use App\DataTables\TechnicalReviewDatatable;
use App\Models\BanType;
use App\Models\Brand;
use App\Models\Driver;
use App\Models\Insurance;
use App\Models\Model;
use App\Models\TechnicalReview;
use App\Models\Vehicle;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\DataTables\BrandsDataTable;


class InsuranceController extends Controller
{
    public function index()
    {
        $dataTable = new InsurancesDatatable(); 
        return $dataTable->render('insurances.index');
    }

    public function form(Insurance $item, PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'insurances');

        $brands=Brand::get();
        $banTypes=BanType::get();
        $drivers=Driver::get();
        $vehicles = Vehicle::get();
        $models=Model::all();
        $view = view('insurances.form', compact('item','brands','banTypes', 'drivers','vehicles', 'models'))->render();

        return response()->json([
            "view" => $view
        ]);
    }

    public function save(Request $request, Insurance $item, PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'insurances');
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'tableId' => 'required',
            'driver_id' => 'required|exists:drivers,id',
            'brand_id' => 'required|exists:brands,id',
            'model_id' => 'required|exists:models,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'production_year' => 'required',
            'insurance_fee' => 'required',
            'company_name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'file'=>$item?->id ? 'nullable':'required',
        ]);
        try {
            DB::beginTransaction();

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors(),
                ], 422);
            }

            $data = $request->except('_token', 'file');

             if($request->hasFile('file')){
                $file = $request->file('file');
                $newFileName = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('insurances', $newFileName, 'public');
                $data['file']=$path;
            }

            $message = '';
            if ($item->id) {
                $item->update($data);
                $message = 'Uğurla dəyişiklik edildi';
            } else {
                $item = Insurance::create($data);
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

     public function show(Insurance $item){
      
        return view('insurances.show',compact('item'));
    }
}
