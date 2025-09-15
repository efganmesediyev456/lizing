<?php

namespace App\Http\Controllers;

use App\DataTables\ModelDatatable;
use App\DataTables\TechnicalReviewDatatable;
use App\Exports\TechnicalReviewExport;
use App\Models\BanType;
use App\Models\Brand;
use App\Models\Driver;
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
use Maatwebsite\Excel\Facades\Excel;


class TechnicalReviewController extends Controller
{
    public function index()
    {
        $dataTable = new TechnicalReviewDatatable(); 
        return $dataTable->render('technical_reviews.index');
    }

    public function form(TechnicalReview $item, PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'technical-reviews');
        $formTitle = $item->id ? 'Texniki baxış redaktə et' : 'Texniki baxış əlavə et';

        $brands=Brand::get();
        $banTypes=BanType::get();
        $drivers=Driver::get();
        $vehicles = Vehicle::get();
        $models=Model::all();
        $view = view('technical_reviews.form', compact('item','brands','banTypes', 'drivers','vehicles', 'models'))->render();

        return response()->json([
            "view" => $view,
            "formTitle" => $formTitle
        ]);
    }

    public function save(Request $request, TechnicalReview $item, PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'technical-reviews');
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            // 'tableId' => 'required',
            // 'driver_id' => 'required|exists:drivers,id',
            // 'brand_id' => 'required|exists:brands,id',
            // 'model_id' => 'required|exists:models,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            // 'production_year' => 'required',
            'technical_review_fee' => 'required',
            'status' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            // 'file'=>$item?->id ? 'nullable':'required',
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
                $path = $file->storeAs('technical_reviews', $newFileName, 'public');
                $data['file']=$path;
            }

            if ($item->id) {
                $item->update($data);
            } else {
                $item = TechnicalReview::create($data);
            }

            DB::commit();

            return response()->json([
                'success' => true,
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

    public function show(TechnicalReview $item){
      
        return view('technical_reviews.show',compact('item'));
    }

    public function export(){
        return Excel::download(new TechnicalReviewExport, 'technical_review_exports.xlsx');
    }
}
