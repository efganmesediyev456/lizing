<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use DB;
use App\DataTables\RoleManagementDatatable;
use Spatie\Permission\Models\Role;

class RoleManagementController extends Controller
{
    public function index()
    {
        $dataTable = new RoleManagementDatatable(); 
        return $dataTable->render('role-managements.index');
    }


    public function form(Role $item, PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'role-managements');

        $view = view('role-managements.form', compact('item'))->render();

        return response()->json([
            "view" => $view
        ]);
    }


    public function save(Request $request, Role $item, PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'role-managements');


        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:roles,name,'.$item->id,
            'status' => 'required'
        ]);

        try {
            DB::beginTransaction();

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors(),
                ], 422);
            }

            $data = $request->only(['name', 'status']);
            $message = '';
            if ($item->id) {
                $item->update($data);
                $message = 'Uğurla dəyişiklik edildi';
            } else {
                $item = Role::create($data);
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
                    'message'=>'System Error: '.$e->getMessage()
            ]);
        }
    }
}
