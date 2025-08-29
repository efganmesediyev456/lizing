<?php

namespace App\Http\Controllers;

use App\DataTables\BanTypeDatatable;
use App\DataTables\ExpenseTypeDatatable;
use App\Exports\BanTypeExport;
use App\Models\BanType;
use App\Models\Brand;
use App\Models\Driver;
use App\Models\ExpenseType;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\DataTables\BrandsDataTable;
use Maatwebsite\Excel\Facades\Excel;


class ExpenseTypeController extends Controller
{

    
    public function index()
    {
        $dataTable = new ExpenseTypeDatatable(); 
        return $dataTable->render('expense-types.index');
    }

    public function form(ExpenseType $item,PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $formTitle = $item->id ? 'Xərc növü redaktə et' : 'Xərc növü əlavə et';

        $permissionService->checkPermission($action, 'expense-types');
        
        $view = view('expense-types.form', compact('item'))->render();

        return response()->json([
            "view" => $view,
            "formTitle" => $formTitle
        ]);
    }

    public function save(Request $request, ExpenseType $item, PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'expense-types');

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

            $data = $request->except(['id_card_front','id_card_back']);

            $message = '';
            if ($item->id) {
                $item->update($data);
                $message = 'Uğurla dəyişiklik edildi';
            } else {
                $item = ExpenseType::create($data);
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

    public function export() 
    {
        return Excel::download(new BanTypeExport, 'ban-types.xlsx');
    }
}
