<?php

namespace App\Http\Controllers;

use App\DataTables\ModelDatatable;
use App\DataTables\OilChangeDatatable;
use App\DataTables\TechnicalReviewDatatable;
use App\Models\BanType;
use App\Models\Brand;
use App\Models\Driver;
use App\Models\Model;
use App\Models\OilChange;
use App\Models\OilChangeType;
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


class OilChangeController extends Controller
{
    public function index()
    {
        $dataTable = new OilChangeDatatable(); 
        return $dataTable->render('oil_changes.index');
    }

    public function form(OilChange $item, PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'oil-changes');

        $brands=Brand::get();
        $banTypes=BanType::get();
        $drivers=Driver::get();
        $vehicles = Vehicle::get();
        $models=Model::all();
        $oilChangeTypes = OilChangeType::get();
        $view = view('oil_changes.form', compact('item','brands','banTypes', 'drivers','vehicles', 'models', 'oilChangeTypes'))->render();

        return response()->json([
            "view" => $view
        ]);
    }

    public function save(Request $request, OilChange $item, PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'oil-changes');
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'tableId' => 'required',
            'driver_id' => 'required|exists:drivers,id',
            'brand_id' => 'required|exists:brands,id',
            'model_id' => 'required|exists:models,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'oil_change_type_id' => 'required|exists:oil_change_types,id',
            'date' => 'required',
            'change_interval' => 'required',
            'next_change_interval' => 'required',
            'difference_interval' => 'required',
            'oil_price' => 'required',
            'total_price' => 'required',
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
                $path = $file->storeAs('oil_changes', $newFileName, 'public');
                $data['file']=$path;
            }

            $message = '';
            if ($item->id) {
                $item->update($data);
                $message = 'Uğurla dəyişiklik edildi';
            } else {
                $item = OilChange::create($data);
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

     public function show(OilChange $item){
      
        return view('oil_changes.show',compact('item'));
    }
}
