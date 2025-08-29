<?php

namespace App\Http\Controllers;

use App\DataTables\DriverStatusDatatable;
use App\Models\City;
use App\Models\Driver;
use App\Models\DriverStatus;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\DataTables\CitiesDataTable;


class DriverStatusController extends Controller
{
    public function index()
    {
        $dataTable = new DriverStatusDatatable(); 
        return $dataTable->render('driver_statuses.index');
    }

    public function form(DriverStatus $item, PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'driver_statuses');
        
        $formTitle = $item->id ? 'Sürücü statusu redaktə et' : 'Sürücü statusu əlavə et';

        
        $view = view('driver_statuses.form', compact('item'))->render();

        return response()->json([
            "view" => $view,
            "formTitle" => $formTitle
        ]);
    }

    public function save(Request $request, DriverStatus $item, PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'driver_statuses');
        

        $validator = Validator::make($request->all(), [
            'status' => 'required|string|max:255',
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
                $item = DriverStatus::create($data);
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
