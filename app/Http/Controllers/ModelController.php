<?php

namespace App\Http\Controllers;

use App\DataTables\ModelDatatable;
use App\Models\BanType;
use App\Models\Brand;
use App\Models\Driver;
use App\Models\Model;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\DataTables\BrandsDataTable;


class ModelController extends Controller
{
    public function index()
    {
        $dataTable = new ModelDatatable(); 
        return $dataTable->render('models.index');
    }

    public function form(Model $item,PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'models');
        $brands=Brand::get();
        $banTypes=BanType::get();
        $view = view('models.form', compact('item','brands','banTypes'))->render();

        return response()->json([
            "view" => $view
        ]);
    }

    public function save(Request $request, Model $item,PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'models');

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
            'ban_type_id' => 'required|exists:ban_types,id',
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
                $item = Model::create($data);
                $message = 'Uğurla əlavə olundu';
            }


            DB::commit();

            return response()->json([
                'success' => true,
                'message'=>$message
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
