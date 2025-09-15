<?php

namespace App\Http\Controllers;

use App\DataTables\ModelDatatable;
use App\DataTables\NotificationDatatable;
use App\Exports\ModelExport;
use App\Models\BanType;
use App\Models\Brand;
use App\Models\Driver;
use App\Models\DriverNotification;
use App\Models\DriverNotificationTopic;
use App\Models\DriverStatus;
use App\Models\Model;
use App\Notifications\NewSampleNotification;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\DataTables\BrandsDataTable;
use Maatwebsite\Excel\Facades\Excel;


class NotificationController extends Controller
{
    public function index()
    {
        $dataTable = new NotificationDatatable(); 
        $statuses = DriverStatus::get();
        $drivers= Driver::get();
        $notificationTopics = DriverNotificationTopic::get();
        $filterOptions = $dataTable->getFilterOptions();

        return $dataTable->render('notification_all.index', compact('statuses', 'drivers','notificationTopics','filterOptions'));
    }

 

    public function save(Request $request, DriverNotification $item,PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'notifications');

        $validator = Validator::make($request->all(), [
            'driver_notification_topic_id' => 'required',
            'note' => 'required',
        ]);

        try {
            DB::beginTransaction();

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors(),
                ], 422);
            }

            $data = $request->except('_token');

            
            $message = 'Uğurla bildiriş göndərildi!';
            

            $notify = DriverNotification::create([
                "note"=>$request->note,
                "driver_notification_topic_id" => $request->driver_notification_topic_id,
                "type" => $request->type
            ]);

            $driverNotification = DriverNotificationTopic::find($request->driver_notification_topic_id);
            foreach($request->drivers as $driv){
                $notify->drivers()->create([
                    "driver_id"=>$driv
                ]);
                $driver = Driver::find($driv);
                if ($driver->expo_token) {
                    $driver->notify(new NewSampleNotification($driverNotification->title, $request->note));
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message'=>$message
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

    public function export(){
        return Excel::download(new ModelExport(),'models.xlsx');
    }


    public function show(DriverNotification $item){
        $status = ''; 
        if($item->type=='all'){
            $status = 'Hamısı';
        }else{
            $status = DriverStatus::where('id',$item->type)?->first()?->status;
        }
        return view('notification_all.show', compact('item','status'));
    }


    
    public function users($status)
    {
        $users = Driver::where('status_id', $status)->get();

        if($status=='all'){
            $users = Driver::all();
        }

        $drivers = $users->pluck('id');

        $maps = $users->map(function ($user) {
            return '<div class="selectedItem">
                    <p>' . htmlspecialchars($user->fullname ?? $user->name ?? 'Naməlum') . '</p>
                    <button data-id="'.$user->id.'" class="remoceSelectItem" type="button">
                        <svg width="11" height="10" viewBox="0 0 11 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 0.5L10 9.5M1 9.5L10 0.5" stroke="white"></path>
                        </svg>
                    </button>
                    </div>';
        });

        return response()->json(['html' => $maps->implode(''),'drivers'=>$drivers]);
    }

}
