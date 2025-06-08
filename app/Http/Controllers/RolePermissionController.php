<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\DataTables\RolePermissionDatatable;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use DB;

class RolePermissionController extends Controller
{
    public function index()
    {
        $dataTable = new RolePermissionDatatable();
        return $dataTable->render('role-permissions.index');
    }

    public function create(Role $item, PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'role-permissions');

        $roles = Role::all();
        $permissions = Permission::get()->groupBy('group_name');
        return view('role-permissions.create', compact('roles', 'permissions', 'item'));
    }

    public function store(Request $request,  PermissionService $permissionService)
    {
        $this->validate($request, [
            "role_id" => "required",
            "permissions" => "required|array|min:1"
        ]);
        try {
            DB::beginTransaction();
            $role = Role::find($request->role_id);

            $action = $role->id ? 'edit' : 'create';
            $permissionService->checkPermission($action, 'role-permissions');
            

            if ($role) {
                $role->syncPermissions($request->permissions);
            }
            DB::commit();
            return redirect()->route('role-permissions.index')->withSuccess('Rola icazələr əlavə olundu');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withError('System Error: ' . $e->getMessage());
        }
    }


    public function show(Role $item){
        $permissions = $item->permissions->groupBy('group_name');
      
        return view('role-permissions.show',compact('item','permissions'));
    }


   

}
