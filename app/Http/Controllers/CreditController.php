<?php

namespace App\Http\Controllers;

use App\DataTables\CreditDatatable;
use App\Events\DriverNotified;
use App\Http\Requests\DriverNotificationRequest;
use App\Models\Brand;
use App\Models\City;
use App\Models\Credit;
use App\Models\Driver;
use App\Models\DriverNotification;
use App\Models\DriverNotificationTopic;
use App\Models\Model;
use App\Models\Vehicle;
use App\Services\PermissionService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\DataTables\DriversDataTable;

class CreditController extends Controller
{


   
    
    public function index()
    {
        $dataTable = new CreditDatatable(); 
        return $dataTable->render('credits.index');
    }

    public function form(Credit $item, PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'credits');

        $brands=Brand::get();
        $dqns=Vehicle::get()->pluck('state_registration_number','id');
        $models=Model::get();
        $formTitle = $item->id ? 'Kredit redaktə et' : 'Kredit əlavə et';
        
        $view = view('credits.form', compact('item','brands','dqns','models'))->render();

        return response()->json([
            "view" => $view,
            "formTitle" => $formTitle
        ]);
    }

    public function save(Request $request, Credit $item, PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'drivers');
       
        $validator = Validator::make($request->all(), [
            'tableId' => 'required',
            'date' => 'required',
            // 'brand_id' => 'required',
            'model_id' => 'required',
            'vehicle_id' => 'required',
            'production_year' => 'required',
            // 'calculation' => 'required',
            // 'code' => 'required',
            'down_payment' => 'required',
            'monthly_payment' => 'required',
            'total_months' => 'required',
            'total_payable_loan' => 'required',
            'remaining_months' => 'required',
            'remaining_amount' => 'required',
        ]);

        try {
            DB::beginTransaction();

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors(),
                ], 422);
            }

            $data = $request->all();
            
            $message = '';
            if ($item->id) {
                $item->update($data);
                $message = 'Uğurla dəyişiklik edildi';
            } else {
                $item = Credit::create($data);
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


    public function show(Credit $item){
        return view('credits.show',compact('item'));
    }


    public function notification(Driver $item, PermissionService $permissionService)
    {
       
        $permissionService->checkPermission('notification', 'drivers');
        $topics = DriverNotificationTopic::get();
        $view = view('drivers.notification', compact('item','topics'))->render();

        return response()->json([
            "view" => $view
        ]);
    }

    public function sendNotification(DriverNotificationRequest $request, $driverId){
            try{
                $driver = Driver::findOrFail($driverId);  
                if(is_null($driver)){
                    throw new Exception("Driver not found");
                }
                $data = $request->except('_token','name','surname');
                if($request->hasFile('image')){
                    $file = $request->file('image');
                    $newFileName = time() . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs('driver_notification_', $newFileName, 'public');
                    $data['image'] = $path;
                }
                $driver->notification()->create($data);
                event(new DriverNotified($driver));
                return $this->responseMessage("success","Successfully send notification",null, 200, null);
            }  catch(\Exception $e) {
                return $this->responseMessage("error","System Error ".$e->getMessage(),null, 500, null);
            }
    }
}
