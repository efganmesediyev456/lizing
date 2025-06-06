<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Driver;
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

    public function form(City $item)
    {
        
        $view = view('cities.form', compact('item'))->render();

        return response()->json([
            "view" => $view
        ]);
    }

    public function save(Request $request, City $item)
    {
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

            if ($item->id) {
                $item->update($data);
            } else {
                $item = City::create($data);
            }

            $view = view('cities.form', [
                'item' => $item,
                "success" => false,
                'message' => 'Marka uğurla yadda saxlanıldı.',
            ])->render();

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
