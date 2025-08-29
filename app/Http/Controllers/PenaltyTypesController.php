<?php

namespace App\Http\Controllers;

use App\DataTables\PenaltyTypesDatatable;
use App\Exports\BrandExport;
use App\Models\Brand;
use App\Models\Driver;
use App\Models\PenaltyType;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\DataTables\BrandsDataTable;
use Maatwebsite\Excel\Facades\Excel;


class PenaltyTypesController extends Controller
{
    public function index()
    {
        $dataTable = new PenaltyTypesDatatable(); 
        return $dataTable->render('penalty-types.index');
    }

    public function form(PenaltyType $item,PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'penalty-types');
        $formTitle = $item->id ? 'Cərimə adı redaktə et' : 'Cərimə adı əlavə et';
        
        $view = view('penalty-types.form', compact('item'))->render();

        return response()->json([
            "view" => $view,
            "formTitle" => $formTitle
        ]);
    }

    public function save(Request $request, PenaltyType $item,PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'penalty-types');
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
                $item = PenaltyType::create($data);
                $message = 'Uğurla əlavə olundu';
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

    public function export(){
        return Excel::download(new PenaltyTypeExport(),'penalty-types.xlsx');
    }
}
