<?php

namespace App\Http\Controllers;

use App\DataTables\LeasingDatatable;
use App\Models\Brand;
use App\Models\Driver;
use App\Models\Leasing;
use App\Models\LeasingStatus;
use App\Models\Model;
use App\Models\OilChangeType;
use App\Models\OilType;
use App\Models\Payment;
use App\Models\Vehicle;
use App\Models\VehicleStatus;
use App\Services\PermissionService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\DataTables\VehiclesDataTable;
use App\Services\ContractService;



class LeasingController extends Controller
{
    public function index()
    {
        $dataTable = new LeasingDatatable();
        return $dataTable->render('leasings.index');
    }



    public function form(Leasing $item, PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'leasing');
        $brands = Brand::get();

        if ($item->id) {
            $drivers = Driver::get();
            $dqns = Vehicle::get()->pluck('state_registration_number', 'id');
            $tableIds = Vehicle::get()->pluck('table_id_number', 'id');

        } else {

            $lastLeasingIds = DB::table('leasings')
                ->select('driver_id', DB::raw('MAX(id) as last_leasing_id'))
                ->groupBy('driver_id');

            $drivers = Driver::leftJoinSub($lastLeasingIds, 'last_leasing', function ($join) {
                $join->on('drivers.id', '=', 'last_leasing.driver_id');
            })
                ->leftJoin('leasings', 'leasings.id', '=', 'last_leasing.last_leasing_id')
                ->where(function ($query) {
                    $query->whereNull('leasings.id')  
                        ->orWhereIn('leasings.leasing_status_id', [2, 3]); 
                })
                ->select('drivers.*')
                ->get();
            $dqns = Vehicle::whereNull('vehicle_status_id')->get()->pluck('state_registration_number', 'id');

            $tableIds = Vehicle::whereNull('vehicle_status_id')->get()->pluck('table_id_number', 'id');

        }


        


        $models = Model::get();

        $formTitle = $item->id ? 'Lizing redaktə et' : 'Lizing əlavə et';
        $leasing_statuses = LeasingStatus::where('status', 1)->get();


        $view = view('leasings.form', compact('item','tableIds', 'action','brands', 'drivers', 'dqns', 'models', 'leasing_statuses'))->render();

        return response()->json([
            "view" => $view,
            "formTitle" => $formTitle
        ]);
    }


    // public function leasingPayments($request, $item, $periodType, $periodTypeValue, $type)
    // {

    //     $leasing_price = $request->leasing_price;
    //     $now = Carbon::parse($request->start_date);


        

    //     for ($i = 1; $i <= ($request->$periodType+1); $i++) {
    //         if ($periodTypeValue < $leasing_price) {
    //             $leasing_price = $leasing_price - $periodTypeValue;
    //         } else {
    //             $periodTypeValue = $leasing_price;
    //         }

            

    //         // $status = $now->lt(Carbon::today()) ? 'completed' : 'pending';
    //         $status = 'pending';


    //         $item->leasingPayments()->create([
    //             'driver_id' => $request->driver_id,
    //             'payment_date' => $now->format('Y-m-d'),
    //             'price' => $periodTypeValue,
    //             'remaining_amount' => $leasing_price,
    //             'status' => $status
    //         ]);


    //         if ($type == 'daily') {
    //             $now = $now->addDays(1);
    //         } elseif ($type == 'monthly') {
    //             // $now = $now->addMonths(1);
    //             $now = $now->addMonthNoOverflow(1);
    //         }
    //     }

    // }

    public function save(Request $request, Leasing $item, PermissionService $permissionService)
    {
        set_time_limit(0);

        $contractService = new ContractService;

        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'leasing');
        $leasingProcessCreate = $item->id ? false : true;
        $validator = Validator::make($request->all(), [
            'tableId' => 'required',
            'fin' => 'required',
            'driver_id' => 'required|exists:drivers,id',
            // 'has_advertisement' => 'required',
            // 'deposit_payment' => 'required',
            // 'deposit_price' => 'required',
            // 'deposit_debt' => 'required',
            // 'vehicle_id' => 'required|exists:vehicles,id',
            // 'leasing_price' => 'required',
            // 'daily_payment' => 'required_with:leasing_period_days',
            // 'monthly_payment' => 'required_with:leasing_period_months',
            // 'leasing_period_days' => 'required_with:daily_payment',
            // 'leasing_period_months' => 'required_with:monthly_payment',
            // 'start_date' => 'required',
            // 'end_date' => 'required',
            // 'file' => 'required',
            'brand_id' => 'required|exists:brands,id',
            'model_id' => 'required|exists:models,id',
        ]);

        // try {
            DB::beginTransaction();

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors(),
                ], 422);
            }

            // $driver = Driver::find($request->driver_id);
            // if($driver){
            //     $driver->leasing()->delete();
            // }


            $data = $request->except('_token', 'fin', 'status', 'file', 'passive_reason');

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $newFileName = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('leasings', $newFileName, 'public');
                $data['file'] = $path;
            }



            $message = '';
            if ($item->id) {
                $item->update($data);
                $message = 'Uğurla dəyişiklik edildi';
            } else {
                $item = Leasing::create($data);
                $message = 'Uğurla əlavə olundu';
            }

            $contractService->generate($item);



            // dd($leasingProcessCreate);



            if ($request->has('passive_reason') and $request->filled('passive_reason')) {
                $item->passiveReason()->create([
                    "driver_id" => $request->driver_id,
                    "passive_reason" => $request->passive_reason
                ]);

                

                $item->vehicle->update([
                    'vehicle_status_id'=>null
                ]);

                // $item->driver_id = null;
                $item->save();
            } else {
                $item->passiveReason()->delete();
                $onLeasingStatus = VehicleStatus::where('is_leasing', 1)->first();
                $vehicle = Vehicle::find($request->vehicle_id);
                $vehicle->vehicle_status_id = $onLeasingStatus->id;
                $vehicle->save();
            }



            


            // if ($leasingProcessCreate && $request->daily_payment and $request->leasing_period_days) {
            //     $this->leasingPayments($request, $item, 'leasing_period_days', $request->daily_payment, 'daily');
            // }

            // if ($leasingProcessCreate && $request->monthly_payment and $request->leasing_period_months) {
            //     $this->leasingPayments($request, $item, 'leasing_period_months', $request->monthly_payment, 'monthly');
            // }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $message

            ]);
        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     return response()->json([
        //         'view' => '',
        //         'errors' => true,
        //         'message' => 'System Error: ' . $e->getMessage()
        //     ]);
        // }
    }

    public function show(Leasing $item)
    {
        return view('leasings.show', compact('item'));
    }




    public function payment(Request $request)
    {
        $this->validate($request, [
            "price" => "required|numeric|min:1",
            "payment_status" => "required",
            "leasing_id" => "required|exists:leasings,id"
        ]);

        try {
            DB::beginTransaction();

            $leasing = Leasing::findOrFail($request->leasing_id);

            if ($request->payment_status == 'daily_payment') {
                if ($leasing->daily_payment > 0) {
                    $leasingPrice = $leasing->daily_payment;

                    
                
                    $payment = $leasing->leasingPayments()->create([
                        'driver_id'=>$leasing->driver_id,
                        'payment_date'=>now(),
                        'status'=>"completed",
                        "price"=>$request->price
                    ]);

                    Payment::create([
                            "leasing_id" => $leasing->id,
                            "payment_type" => "daily",
                            "price" => $request->price,
                            "leasing_payment_id" => $payment->id,
                            "payment_back_or_app" => 1,
                            "status" => 'completed',
                            'driver_id' => $leasing->driver_id
                    ]);



                    if ($leasing->is_completed) {
                        $leasingCloseStatus = LeasingStatus::where('is_closed', 1)->first();
                        $leasing->leasing_status_id = $leasingCloseStatus->id;
                        $leasing->save();

                        $leasing->vehicle?->update(['vehicle_status_id' => null]);

                    }

                } else {
                    throw new Exception('Bu lizinq üçün gündəlik ödəniş təyin edilməyib');
                }
            }
            if ($request->payment_status == 'monthly_payment') {
                if ($leasing->monthly_payment > 0) {


                    
                    $payment = $leasing->leasingPayments()->create([
                        'driver_id'=>$leasing->driver_id,
                        'payment_date'=>now(),
                        'status'=>"completed",
                        "price"=>$request->price
                    ]);

                    Payment::create([
                            "leasing_id" => $leasing->id,
                            "payment_type" => "monthly",
                            "price" => $request->price,
                            "leasing_payment_id" => $payment->id,
                            "payment_back_or_app" => 1,
                            "status" => 'completed',
                            'driver_id' => $leasing->driver_id
                    ]);



                    if ($leasing->is_completed) {
                        $leasingCloseStatus = LeasingStatus::where('is_closed', 1)->first();
                        $leasing->leasing_status_id = $leasingCloseStatus->id;
                        $leasing->save();

                        $leasing->vehicle?->update(['vehicle_status_id' => null]);

                    }


                } else {
                    throw new Exception('Bu lizinq üçün aylıq ödəniş təyin edilməyib');
                }
            }
            if ($request->payment_status == 'deposit_price') {
                if ($leasing->deposit_price > 0) {
                    $depositPrice = $leasing->deposit_payment;

                    if($depositPrice<=0){
                        throw new Exception('Ilkin deposit ödənişi ödənilib!');
                    }
                    // if ($request->price != $depositPrice) {
                    //     throw new Exception('Tam ilkin depozit məbləği ödənilməlidir. Ödəniş məbləği: ' . $depositPrice . ' olmalıdır');
                    // }
                    if ($request->price > $depositPrice) {
                        throw new Exception('Ödəniş məbləği ilkin depozit məbləğindən böyük ola bilməz. Maksimum ödəniş: ' . $depositPrice);
                    }

                    $remainingDepositPrice = $depositPrice - $request->price;

                    $leasing->deposit_payment = $remainingDepositPrice;
                    $leasing->save();

                    $depositPayment = Payment::create([
                        "leasing_id" => $leasing->id,
                        "payment_type" => "deposit_payment",
                        "price" => $request->price,
                        "payment_back_or_app" => 1,
                        "status" => 'completed',
                        'driver_id' => $leasing->driver_id ?? null
                    ]);

                } else {
                    throw new Exception('Bu lizinq üçün ilkin depozit ödənişi təyin edilməyib');
                }
            }
            if ($request->payment_status == 'deposit_debt') {
                if ($leasing->deposit_debt > 0) {
                    $depositDebtPrice = $leasing->deposit_debt;

                    // if ($request->price != $depositDebtPrice) {
                    //     throw new Exception('Tam depozit borc məbləği ödənilməlidir. Ödəniş məbləği: ' . $depositDebtPrice . ' olmalıdır');
                    // }

                    if ($request->price > $depositDebtPrice) {
                        throw new Exception('Ödəniş məbləği depozit borc məbləğindən böyük ola bilməz. Maksimum ödəniş: ' . $depositDebtPrice);
                    }

                    $remainingDepositDebtPrice = $depositDebtPrice - $request->price;

                    $leasing->deposit_debt = $remainingDepositDebtPrice;
                    $leasing->save();

                    $depositDebtPayment = Payment::create([
                        "leasing_id" => $leasing->id,
                        "payment_type" => "deposit_debt",
                        "price" => $request->price,
                        "payment_back_or_app" => 1,
                        "status" => 'completed',
                        'driver_id' => $leasing->driver_id ?? null
                    ]);

                } else {
                    throw new Exception('Bu lizinq üçün depozit borcu yoxdur');
                }
            }










            DB::commit();

            return $this->responseMessage('success', 'Ödəniş uğurla əlavə olundu');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->responseMessage('error', $e->getMessage(), null, 500);
        }
    }



}
