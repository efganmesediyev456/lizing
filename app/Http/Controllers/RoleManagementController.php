<?php

namespace App\Http\Controllers;

use App\Models\User;
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


    public function form(Role $item)
    {
        $view = view('role-managements.form', compact('item'))->render();

        return response()->json([
            "view" => $view
        ]);
    }


    public function save(Request $request, Role $item)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:roles,name,'.$item->id,
            'status' => 'required'
        ]);

        try {
            DB::beginTransaction();

            if (is_null($item)) {
                $item = new Role($request->all());
            }

            if ($validator->fails()) {
                $view = view('role-managements.form', [
                    'item' => $item,
                    'errors' => $validator->errors(),
                ])->render();

                return response()->json([
                    'view' => $view,
                    'errors' => true,
                ]);
            }

            $data = $request->only(['name', 'status']);
            if ($item->id) {
                $item->update($data);
            } else {
                $item = Role::create($data);
            }

            $view = view('role-managements.form', [
                'item' => $item,
                "success" => false,
                'message' => 'Role idarəetməsi uğurla yadda saxlanıldı.',
            ])->render();

            DB::commit();

            return response()->json([
                'view' => $view,
                'success' => true,
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
