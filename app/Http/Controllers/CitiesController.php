<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Driver;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\DataTables\CitiesDataTable;


class CitiesController extends Controller
{
    public function index()
    {
        $dataTable = new CitiesDatatable(); 
        return $dataTable->render('cities.index');
    }

    public function form(City $item, PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'cities');
        
        $formTitle = $item->id ? 'Şəhər redaktə et' : 'Şəhər əlavə et';

        
        $view = view('cities.form', compact('item'))->render();

        return response()->json([
            "view" => $view,
            "formTitle" => $formTitle
        ]);
    }

    public function save(Request $request, City $item, PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'cities');
        

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
                $item = City::create($data);
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
