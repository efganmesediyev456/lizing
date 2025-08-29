<?php

namespace App\Http\Controllers;

use App\DataTables\ModelDatatable;
use App\DataTables\OilChangeTypeDatatable;
use App\Models\BanType;
use App\Models\Brand;
use App\Models\Driver;
use App\Models\Model;
use App\Models\OilChangeType;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\DataTables\BrandsDataTable;


class OilChangeTypesController extends Controller
{
    public function index()
    {
        $dataTable = new OilChangeTypeDatatable(); 
        return $dataTable->render('oil_change_types.index');
    }

    public function form(OilChangeType $item, PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'oil_change_types');

        $view = view('oil_change_types.form', compact('item'))->render();
        $formTitle = $item->id ? 'Yağın dəyişilmə növü redaktə et' : 'Yağın dəyişilmə növü əlavə et';

        return response()->json([
            "view" => $view,
            "formTitle" => $formTitle
        ]);
    }

    public function save(Request $request, OilChangeType $item, PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'oil_change_types');
        

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'km' => 'required'
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
                $item = OilChangeType::create($data);
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
