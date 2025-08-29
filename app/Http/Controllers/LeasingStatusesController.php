<?php

namespace App\Http\Controllers;

use App\DataTables\LeasingStatusesDatatable;
use App\Models\LeasingStatus;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class LeasingStatusesController extends Controller
{
    public function index()
    {
        $dataTable = new LeasingStatusesDatatable(); 
        return $dataTable->render('leasing-statuses.index');
    }

    public function form(LeasingStatus $item, PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'leasing-statuses');
        $formTitle = $item->id ? 'Lizinq statusunu redaktə et' : 'Lizinq statusunu əlavə et';
        
        $view = view('leasing-statuses.form', compact('item'))->render();

        return response()->json([
            "view" => $view,
            "formTitle" => $formTitle
        ]);
    }

    public function save(Request $request, LeasingStatus $item, PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'leasing-statuses');
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
                $item = LeasingStatus::create($data);
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
        return Excel::download(new LeasingStatusExport(),'leasing-statuses.xlsx');
    }
}
