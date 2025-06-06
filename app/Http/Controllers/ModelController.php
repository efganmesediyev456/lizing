<?php

namespace App\Http\Controllers;

use App\DataTables\ModelDatatable;
use App\Models\BanType;
use App\Models\Brand;
use App\Models\Driver;
use App\Models\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\DataTables\BrandsDataTable;


class ModelController extends Controller
{
    public function index()
    {
        $dataTable = new ModelDatatable(); 
        return $dataTable->render('models.index');
    }

    public function form(Model $item)
    {
        $brands=Brand::get();
        $banTypes=BanType::get();
        $view = view('models.form', compact('item','brands','banTypes'))->render();

        return response()->json([
            "view" => $view
        ]);
    }

    public function save(Request $request, Model $item)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
            'ban_type_id' => 'required|exists:ban_types,id',
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
                $item = Model::create($data);
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
}
