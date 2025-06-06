<?php

namespace App\Http\Controllers;

use App\DataTables\BanTypeDatatable;
use App\Models\BanType;
use App\Models\Brand;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\DataTables\BrandsDataTable;


class BanTypeController extends Controller
{
    public function index()
    {
        $dataTable = new BanTypeDatatable(); 
        return $dataTable->render('ban-types.index');
    }

    public function form(BanType $item)
    {
        
        $view = view('ban-types.form', compact('item'))->render();

        return response()->json([
            "view" => $view
        ]);
    }

    public function save(Request $request, BanType $item)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            if (is_null($item)) {
                $item = new BanType($request->all());
            }

            if ($validator->fails()) {
                $view = view('ban-types.form', [
                    'item' => $item,
                    'errors' => $validator->errors(),
                ])->render();

                return response()->json([
                    'view' => $view,
                    'errors' => true,
                ]);
            }

            $data = $request->only([
                'title','status'
            ]);

            if ($item->id) {
                $item->update($data);
            } else {
                $item = BanType::create($data);
            }

            $view = view('ban-types.form', [
                'item' => $item,
                "success" => false,
                'message' => 'Ban növü uğurla yadda saxlanıldı.',
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
