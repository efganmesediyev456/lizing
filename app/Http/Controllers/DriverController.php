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
use App\DataTables\DriversDataTable;

class DriverController extends Controller
{


   
    
    public function index()
    {
        $dataTable = new DriversDataTable(); 
        return $dataTable->render('drivers.index');
    }

    public function form(Driver $item, PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'drivers');

        $cities=City::get();
        $view = view('drivers.form', compact('item', 'cities'))->render();

        return response()->json([
            "view" => $view
        ]);
    }

    public function save(Request $request, Driver $item, PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'drivers');
       
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('drivers', 'email')->ignore(optional($item)->id),
            ],
            'phone' => 'required',
            'fin' => [
                'required',
                Rule::unique('drivers', 'fin')->ignore(optional($item)->id),
            ],
            'id_card_serial_code' => [
                'required',
                Rule::unique('drivers', 'id_card_serial_code')->ignore(optional($item)->id),
            ],
            'id_card_front' => $item?->id ? 'nullable' : 'required',
            'id_card_back' => $item?->id ? 'nullable' : 'required',
            'tableId'=>'required',
            'current_address'=>'required',
            'registered_address'=>'required',
            'date'=>'required',
            'city_id'=>'required|exists:cities,id',
            'password'=>$item?->id ? 'sometimes' : 'required',
        ]);

        try {
            DB::beginTransaction();

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors(),
                ], 422);
            }

            $data = $request->except(['id_card_front','id_card_back']);

            if($request->hasFile('id_card_front')){
                $file = $request->file('id_card_front');
                $newFileName = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('driver_documents', $newFileName, 'public');
                $data['id_card_front'] = $path;
            }

            if($request->hasFile('id_card_back')){
                $file = $request->file('id_card_back');
                $newFileName = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('driver_documents', $newFileName, 'public');
                $data['id_card_back'] = $path;
            }

            $message = '';
            if ($item->id) {
                $item->update($data);
                $message = 'Uğurla dəyişiklik edildi';
            } else {
                $item = Driver::create($data);
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


    public function show(Driver $item){
        return view('drivers.show',compact('item'));
    }
}
