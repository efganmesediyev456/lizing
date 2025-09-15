<?php

namespace App\Http\Controllers;

use App\DataTables\DriverNotificationDatatable;
use App\Events\DriverNotified;
use App\Exports\DriverExport;
use App\Http\Requests\DriverNotificationRequest;
use App\Models\City;
use App\Models\Driver;
use App\Models\DriverNotification;
use App\Models\DriverNotificationTopic;
use App\Models\DriverStatus;
use App\Services\PermissionService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\DataTables\DriversDataTable;
use Maatwebsite\Excel\Facades\Excel;

class DriverController extends Controller
{




    public function index()
    {
        $dataTable = new DriversDataTable();
        $driverStatuses = DriverStatus::get();
        $filterOptions = $dataTable->getFilterOptions();

        return $dataTable->render('drivers.index', compact("driverStatuses","filterOptions"));
    }

    public function form(Driver $item, PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $formTitle = $item->id ? 'Sürücü redaktə et' : 'Sürücü əlavə et';
        $permissionService->checkPermission($action, 'drivers');

        $cities = City::get();
        $statuses = DriverStatus::get();



        $view = view('drivers.form', compact('item', 'cities', 'statuses','action'))->render();

        return response()->json([
            "view" => $view,
            "formTitle" => $formTitle
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
            'phone' => [
                'required',
                Rule::unique('drivers', 'phone')->ignore(optional($item)->id),
            ],
            // 'phone' => 'required',
            // 'fin' => [
            //     'required',
            //     Rule::unique('drivers', 'fin')->ignore(optional($item)->id),
            // ],
            // 'id_card_serial_code' => [
            //     'required',
            //     Rule::unique('drivers', 'id_card_serial_code')->ignore(optional($item)->id),
            // ],
            // 'id_card_front' => $item?->id ? 'nullable' : 'required',
            // 'id_card_back' => $item?->id ? 'nullable' : 'required',
            // 'tableId'=>'required',
            // 'current_address'=>'required',
            // 'registered_address'=>'required',
            // 'date'=>'required',
            // 'city_id'=>'required|exists:cities,id',
            // 'password'=>$item?->id ? 'sometimes' : 'required',
        ]);



        try {
            DB::beginTransaction();

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors(),
                ], 422);
            }

            $data = $request->except(['id_card_front', 'id_card_back']);

            if ($request->hasFile('id_card_front')) {
                $file = $request->file('id_card_front');
                $newFileName = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('driver_documents', $newFileName, 'public');
                $data['id_card_front'] = $path;
            }

            if ($request->hasFile('id_card_back')) {
                $file = $request->file('id_card_back');
                $newFileName = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('driver_documents', $newFileName, 'public');
                $data['id_card_back'] = $path;
            }


            if ($request->hasFile('drivers_license_front')) {
                $file = $request->file('drivers_license_front');
                $newFileName = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('driver_documents', $newFileName, 'public');
                $data['drivers_license_front'] = $path;
            }


            if ($request->hasFile('drivers_license_back')) {
                $file = $request->file('drivers_license_back');
                $newFileName = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('driver_documents', $newFileName, 'public');
                $data['drivers_license_back'] = $path;
            }


            if ($request->password and trim($request->password) != '') {
                $data['password'] = Hash::make($request->password);
            } else {
                unset($data['password']);
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
                'message' => $message

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


    public function show(Driver $item)
    {
        return view('drivers.show', compact('item'));
    }


    public function notification(Driver $item, PermissionService $permissionService)
    {

        $permissionService->checkPermission('notification', 'drivers');
        $topics = DriverNotificationTopic::get();
        $view = view('drivers.notification', compact('item', 'topics'))->render();

        return response()->json([
            "view" => $view,
            'formTitle' => 'Sürücü bildiriş göndər'
        ]);
    }

    public function sendNotification(DriverNotificationRequest $request, $driverId)
    {
        try {
            $driver = Driver::findOrFail($driverId);
            if (is_null($driver)) {
                throw new Exception("Driver not found");
            }
            $data = $request->except('_token', 'name', 'surname');
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $newFileName = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('driver_notification_', $newFileName, 'public');
                $data['image'] = $path;
            }
            $driver->notification()->create($data);
            event(new DriverNotified($driver));
            return $this->responseMessage("success", "Successfully send notification", null, 200, null);
        } catch (\Exception $e) {
            return $this->responseMessage("error", "System Error " . $e->getMessage(), null, 500, null);
        }
    }

    public function export()
    {
        return Excel::download(new DriverExport, 'drivers.xlsx');
    }


    public function notifications(Request $request)
    {
        $dataTable = new DriverNotificationDatatable();
        return $dataTable->render('notifications.index');
    }

    public function payments(Driver $driver)
    {

        $leasings = $driver->leasings;

        $response = $this->leasingPayments($driver);

        return view('drivers.payments', compact('response','driver'));
    }


    public function leasingPayments($driver)
    {
        Carbon::setLocale('az');

        $response = [];
        $records = [];

        foreach ($driver->leasings as $leasing) {

            if ($leasing->is_completed) {
                continue;
            }
            $start = Carbon::parse($leasing->start_date);
            $end = Carbon::parse($leasing->end_date);
            $today = Carbon::today()->lt($end) ? Carbon::today()->endOfDay() : $end->endOfDay();

           
            


            $totalPaid = $leasing->leasingPayments->where('status', 'completed')->sum('price');
            $balance = $totalPaid;



            $records = [];
            $id = 1;
            $totalRequired=0;


            // ===== DAILY PAYMENT =====
            if ($leasing->payment_type === 'daily') {
                $current = $start->copy();
                while ($current->lte($end)) {
                    $required = $leasing->daily_payment; // gündəlik məbləğ
                    $paid = 0;

                    if ($balance >= $required) {
                        $paid = $required;
                        $balance -= $required;
                        $status = "completed";
                    } elseif ($balance > 0 && $balance < $required) {
                        $paid = $balance;
                        $balance = 0;
                        $status = "partial";
                    } else {
                        $paid = 0;
                        $status = "pending";
                    }

                    $records[] = [
                        'id' => $id++,
                        "payment_date" => $current->toDateString(),
                        "status" => $status,
                        "price" => $required,
                        "remaining_amount" => max(0, $required - $paid),
                        "month_name" => $current->translatedFormat('F'),
                        "day_name" => $current->translatedFormat('d'),
                        "week_day_name" => $current->translatedFormat('D'),
                        "paid" => $paid,
                    ];

                    $current->addDay();
                }

                if (!Carbon::today()->lt($leasing->start_date)) {
                    $totalRequired = (Carbon::parse($leasing->start_date)->diffInDays($today) + 1) * $leasing->daily_payment;
                }

            }

            // ===== MONTHLY PAYMENT =====
            elseif ($leasing->payment_type === 'monthly') {
                $current = $start->copy();
                $id = 1;
                while ($current->lte($end)) {
                    $required = $leasing->monthly_payment; // aylıq məbləğ
                    $paid = 0;

                    if ($balance >= $required) {
                        $paid = $required;
                        $balance -= $required;
                        $status = "completed";
                    } elseif ($balance > 0 && $balance < $required) {
                        $paid = $balance;
                        $balance = 0;
                        $status = "partial";
                    } else {
                        $paid = 0;
                        $status = "pending";
                    }

                    $records[] = [
                        "id" => $id++,
                        "payment_date" => $current->translatedFormat("Y-m-d"),
                        "status" => $status,
                        "price" => $required,
                        "remaining_amount" => max(0, $required - $paid),
                        "month_name" => $current->translatedFormat('F'),
                        "day_name" => $current->translatedFormat('d'),
                        "week_day_name" => $current->translatedFormat('D'),
                        "paid" => $paid,
                    ];

                    $current->addMonth();
                }

                if (!Carbon::today()->lt($leasing->start_date)) {
                    $totalRequired = (Carbon::parse($leasing->start_date)->diffInMonths($today) + 1) * $leasing->monthly_payment;
                }
            }

            // ümumi borc
            $totalDebt = max(0, $totalRequired - $totalPaid);


            $response[] = [
                "leasing" => $leasing,
                "vehicle" => $leasing->vehicle,
                "payment_type" => $leasing->payment_type,
                "records" => $records,
                "total_debt" => $totalDebt,
                "driver_payments"=>$driver->payments()->where('leasing_id', $leasing->id)->get()
            ];

        }


        return $response;
    }
}
