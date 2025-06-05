<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\DataTables\VehiclesDataTable;

class VehicleController extends Controller
{
    public function index()
    {
        $dataTable = new VehiclesDataTable(); 
        return $dataTable->render('vehicles.index');
    }

    public function form(Vehicle $item)
    {
        $view = view('vehicles.form', compact('item'))->render();

        return response()->json([
            "view" => $view
        ]);
    }

    public function save(Request $request, Vehicle $item)
    {
        $validator = Validator::make($request->all(), [
            'table_id_number' => [
                'required',
                'string',
                Rule::unique('vehicles', 'table_id_number')->ignore(optional($item)->id),
            ],
            'vin_code' => [
                'required',
                'string',
                Rule::unique('vehicles', 'vin_code')->ignore(optional($item)->id),
            ],
            'state_registration_number' => [
                'required',
                'string',
                Rule::unique('vehicles', 'state_registration_number')->ignore(optional($item)->id),
            ],
            'production_year' => 'required|integer|min:1900|max:' . date('Y'),
            'purchase_price' => 'required|numeric|min:0',
            'mileage' => 'required|integer|min:0',
            'engine' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            if (is_null($item)) {
                $item = new Vehicle($request->all());
            }

            if ($validator->fails()) {
                $view = view('vehicles.form', [
                    'item' => $item,
                    'errors' => $validator->errors(),
                ])->render();

                return response()->json([
                    'view' => $view,
                    'errors' => true,
                ]);
            }

            $data = $request->only([
                'table_id_number',
                'vin_code',
                'state_registration_number',
                'production_year',
                'purchase_price',
                'mileage',
                'engine',
                'status'
            ]);

            if ($item->id) {
                $item->update($data);
            } else {
                $item = Vehicle::create($data);
            }

            $view = view('vehicles.form', [
                'item' => $item,
                "success" => false,
                'message' => 'Nəqliyyat vasitəsi uğurla yadda saxlanıldı.',
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
