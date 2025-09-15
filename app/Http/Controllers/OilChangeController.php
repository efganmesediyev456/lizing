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
use Carbon\Carbon;
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
        $formTitle = $item->id ? 'Yağın dəyişilməsi redaktə et' : 'Yağın dəyişilməsi əlavə et';

        $brands = Brand::get();
        $banTypes = BanType::get();
        $drivers = Driver::get();
        $vehicles = Vehicle::get();
        $models = Model::all();
        $oilChangeTypes = OilChangeType::get();
        $view = view('oil_changes.form', compact('item', 'brands', 'banTypes', 'drivers', 'vehicles', 'models', 'oilChangeTypes'))->render();

        return response()->json([
            "view" => $view,
            "formTitle" => $formTitle
        ]);
    }

    public function save(Request $request, OilChange $item, PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'oil-changes');
        // dd($request->all());
        // $validator = Validator::make($request->all(), [
        //     'tableId' => 'required',
        //     'driver_id' => 'required|exists:drivers,id',
        //     'brand_id' => 'required|exists:brands,id',
        //     'model_id' => 'required|exists:models,id',
        //     'vehicle_id' => 'required|exists:vehicles,id',
        //     'oil_change_type_id' => 'required|exists:oil_change_types,id',
        //     'date' => 'required',
        //     'change_interval' => 'required',
        //     'next_change_interval' => 'required',
        //     'difference_interval' => 'required',
        //     'oil_price' => 'required',
        //     'total_price' => 'required',
        // ]);
        try {
            DB::beginTransaction();

            // if ($validator->fails()) {
            //     return response()->json([
            //         'errors' => $validator->errors(),
            //     ], 422);
            // }


            // $type = OilChangeType::findOrFail($request->oil_change_type_id);

            // // Sonuncu oil change
            // $lastChange = OilChange::where('vehicle_id', $request->vehicle_id)
            //     ->orderByDesc('id')
            //     ->first();

            // $nextChange = $request->change_interval + $type->km;
            // $difference = 0;
            // $penalty = 0;

            // if ($lastChange) {
            //     // əslində dəyişməli olduğu km
            //     $requiredNext = $lastChange->next_change_interval;

            //     if ($request->change_interval > $requiredNext) {
            //         $difference = $request->change_interval - $requiredNext;

            //         // hər 1000 km üçün 100 AZN
            //         $penalty = floor($difference / 1000) * 100;
            //     }
            // }

            // $oilPrice = 80; // sabit
            // $totalPrice = $oilPrice + $penalty;

            // $oilChange = OilChange::create([
            //     'driver_id' => $request->driver_id,
            //     'vehicle_id' => $request->vehicle_id,
            //     'brand_id' => $request->brand_id,
            //     'model_id' => $request->model_id,
            //     'oil_change_type_id' => $type->id,
            //     'date' => now(),
            //     'status' => $request->status,
            //     'change_interval' => $request->change_interval,
            //     'next_change_interval' => $nextChange,
            //     'difference_interval' => $difference,
            //     'oil_price' => $oilPrice,
            //     'total_price' => $totalPrice,
            //     'note' => $request->note,
            //     'file' => $request->file?->store('oil_changes', 'public'),
            // ]);


            if($action=='create'){
                $oilChange = OilChange::create([
                                'driver_id' => $request->driver_id,
                                'vehicle_id' => $request->vehicle_id,
                                'brand_id' => $request->brand_id,
                                'model_id' => $request->model_id,
                                'oil_change_type_id' => $request->oil_change_type_id,
                                'date' => now(),
                                'status' => $request->status,
                                'change_interval' => $request->change_interval,
                                'next_change_interval' => $request->next_change_interval,
                                'difference_interval' => $request->difference_interval,
                                'oil_price' => $request->oil_price,
                                'total_price' => $request->total_price,
                                'note' => $request->note,
                                'file' => $request->file?->store('oil_changes', 'public'),
                            ]);
            }else{
                $item->update(
                    [
                                'driver_id' => $request->driver_id,
                                'vehicle_id' => $request->vehicle_id,
                                'brand_id' => $request->brand_id,
                                'model_id' => $request->model_id,
                                'oil_change_type_id' => $request->oil_change_type_id,
                                'date' => now(),
                                'status' => $request->status,
                                'change_interval' => $request->change_interval,
                                'next_change_interval' => $request->next_change_interval,
                                'difference_interval' => $request->difference_interval,
                                'oil_price' => $request->oil_price,
                                'total_price' => $request->total_price,
                                'note' => $request->note,
                                'file' => $request->file?->store('oil_changes', 'public'),
                            ]
                    );
            }

            

            // return response()->json([
            //     'success' => true,
            //     'data' => $oilChange
            // ]);

            // if($request->hasFile('file')){
            //     $file = $request->file('file');
            //     $newFileName = time() . '_' . $file->getClientOriginalName();
            //     $path = $file->storeAs('oil_changes', $newFileName, 'public');
            //     $data['file']=$path;
            // }

            $message = '';

            $message = 'Uğurla əlavə olundu';


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

    public function show(OilChange $item)
    {

        return view('oil_changes.show', compact('item'));
    }


    public function changeOil(Request $request)
    {
        $driver = Driver::find($request->driver_id);
        $change_interval = $request->change_interval;
        $oil_change_type = OilChangeType::find($request->oil_change_type_id);
        $oilChange = $driver->oilChanges()->where('oil_change_type_id', $request->oil_change_type_id)->latest()->first();
        $data = $request->change_interval - $oilChange->next_change_interval;
        if ($request->change_interval != $oilChange->next_change_interval) {
            return response()->json([
                "difference_interval" => $data,
                "next_change_interval" => $request->change_interval + $oil_change_type->km
            ]);
        }
    }


    public function preview(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'oil_change_type_id' => 'required|exists:oil_change_types,id',
            'change_interval' => 'required|integer',
        ]);

        $type = OilChangeType::whereStatus(1)->findOrFail($request->oil_change_type_id);

        $lastChange = OilChange::where('vehicle_id', $request->vehicle_id)
            ->orderByDesc('id')
            ->first();

            

        $nextChange = $request->change_interval + $type->km;
        $difference = 0;
        $penalty = 0;


        if ($lastChange) {
            $requiredNext = $lastChange->next_change_interval;

            if ($request->change_interval > $requiredNext) {
                $difference = $request->change_interval - $requiredNext;
                $penalty = floor($difference / 1000) * 100;
            }
        }

        $oilPrice = 80;
        $totalPrice = $oilPrice + $penalty;

        return response()->json([
            'oil_price' => $oilPrice,
            'next_change_interval' => $nextChange,
            'difference_interval' => $difference,
            'penalty' => $penalty,
            'total_price' => $totalPrice,
        ]);
    }

}
