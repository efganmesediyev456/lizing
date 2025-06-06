<?php

namespace App\Http\Controllers;

use App\DataTables\ModelDatatable;
use App\DataTables\OilChangeTypeDatatable;
use App\Models\BanType;
use App\Models\Brand;
use App\Models\Driver;
use App\Models\Model;
use App\Models\OilChangeType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\DataTables\BrandsDataTable;


class OilChangeTypesController extends Controller
{
    public function index()
    {
        $dataTable = new OilChangeTypeDatatable(); 
        return $dataTable->render('oil_change_types.index');
    }

    public function form(OilChangeType $item)
    {
        $view = view('oil_change_types.form', compact('item'))->render();

        return response()->json([
            "view" => $view
        ]);
    }

    public function save(Request $request, OilChangeType $item)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'km' => 'required'
        ]);



        try {
            DB::beginTransaction();

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors(),
                ], 422);
            }

            $data = $request->except('_token');

            if ($item->id) {
                $item->update($data);
            } else {
                $item = OilChangeType::create($data);
            }

            $view = view('oil_change_types.form', [
                'message' => 'Yağın dəyişilmə növü uğurla yadda saxlanıldı.',
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
                'message' => 'System Error: '.$e->getMessage()
            ]);
        }
    }
}
