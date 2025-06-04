<?php

namespace App\Http\Controllers;

use App\DataTables\DriverDatatable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use DB;
use App\DataTables\RoleManagementDatatable;
use Spatie\Permission\Models\Role;
use App\Models\Driver;

class DriverController extends Controller
{
    public function index()
    {
        $dataTable = new DriverDatatable();
        return $dataTable->render('drivers.index');
    }


    public function form(Driver $item)
    {
        $view = view('drivers.form', compact('item'))->render();

        return response()->json([
            "view" => $view
        ]);
    }


    public function save(Request $request, Driver $item)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'surname' => 'required|string',
            'email' => 'required',
            'phone' => 'required',
            'status' => 'required',
            'tableId' => 'required',
            'fin' => 'required',
            'id_card_serial_code' => 'required',
            'current_address' => 'required',
            'registered_address' => 'required',
            'date' => 'required',
            'gender' => 'required',
            'id_card_front' => $item->id ? 'nullable' : 'required',
            'id_card_back' => $item->id ? 'nullable' : 'required',
        ]);

        try {
            DB::beginTransaction();

            if (is_null($item)) {
                $item = new Driver($request->all());
            }

            if ($validator->fails()) {
                $view = view('drivers.form', [
                    'item' => $item,
                    'errors' => $validator->errors(),
                ])->render();

                return response()->json([
                    'view' => $view,
                    'errors' => true,
                ]);
            }

            $data = $request->all();

             if($request->hasFile('id_card_front')){
                $file = $request->file('id_card_front');
                $newFileName = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('documents', $newFileName, 'public');
                $data['id_card_front']=$path;
            }
             if($request->hasFile('id_card_back')){
                $file = $request->file('id_card_back');
                $newFileName = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('documents', $newFileName, 'public');
                $data['id_card_back']=$path;
            }

            if ($item->id) {
                $item->update($data);
            } else {
                $item = Role::create($data);
            }

            $view = view('drivers.form', [
                'item' => $item,
                "success" => false,
                'message' => 'Sürücü uğurla yadda saxlanıldı.',
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
                'message' => 'System Error: ' . $e->getMessage()
            ]);
        }
    }
}
