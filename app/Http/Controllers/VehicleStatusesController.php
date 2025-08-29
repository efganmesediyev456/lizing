<?php

namespace App\Http\Controllers;

use App\DataTables\VehicleStatusesDatatable;
use App\Models\VehicleStatus;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class VehicleStatusesController extends Controller
{
    public function index()
    {
        $dataTable = new VehicleStatusesDatatable(); 
        return $dataTable->render('vehicle-statuses.index');
    }

    public function form(VehicleStatus $item, PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'vehicle-statuses');
        $formTitle = $item->id ? 'Nəqliyyat vasitəsi statusunu redaktə et' : 'Nəqliyyat vasitəsi statusunu əlavə et';
        
        $view = view('vehicle-statuses.form', compact('item'))->render();

        return response()->json([
            "view" => $view,
            "formTitle" => $formTitle
        ]);
    }

    public function save(Request $request, VehicleStatus $item, PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'vehicle-statuses');
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
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
                $item = VehicleStatus::create($data);
                $message = 'Uğurla əlavə olundu';
            }

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
                'message' => 'System Error: '.$e->getMessage()
            ]);
        }
    }

    public function export(){
        return Excel::download(new VehicleStatusExport(),'vehicle-statuses.xlsx');
    }
}
