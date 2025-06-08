<?php

namespace App\Http\Controllers;

use App\DataTables\ModelDatatable;
use App\DataTables\TechnicalReviewDatatable;
use App\DataTables\OilTypeDatatable;
use App\Models\BanType;
use App\Models\Brand;
use App\Models\Driver;
use App\Models\Model;
use App\Models\OilType;
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


class OilTypeController extends Controller
{
    public function index()
    {
        $dataTable = new OilTypeDatatable(); 
        return $dataTable->render('oil_types.index');
    }

    public function form(OilType $item, PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'oil-types');

        $view = view('oil_types.form', compact('item'))->render();

        return response()->json([
            "view" => $view
        ]);
    }

    public function save(Request $request, OilType $item, PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'oil-types');
        
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'status' => 'required',
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
                $item = OilType::create($data);
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
}
