<?php

namespace App\Http\Controllers;

use App\Http\Requests\DriverNotificationRequest;
use App\Models\City;
use App\Models\Driver;
use App\Models\DriverNotification;
use App\Models\DriverNotificationTopic;
use App\Services\PermissionService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\DataTables\DriversDataTable;
use App\DataTables\DriverNotificationTopicDatatable;
class DriverNotificationTopicController extends Controller
{


   
    
    public function index()
    {
        $dataTable = new DriverNotificationTopicDatatable(); 
        return $dataTable->render('driver-notification-topics.index');
    }

    public function form(DriverNotificationTopic $item, PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'driver-notification-topic');
        $formTitle = $item->id ? 'Sürücü bildiriş mövzusunu redaktə et' : 'Sürücü bildiriş mövzusu əlavə et';

        $view = view('driver-notification-topics.form', compact('item'))->render();

        return response()->json([
            "view" => $view,
            "formTitle" => $formTitle
        ]);
    }

    public function save(Request $request, DriverNotificationTopic $item, PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'driver-notification-topic');
       
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255'
        ]);

        try {
            DB::beginTransaction();

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors(),
                ], 422);
            }

            $data = $request->except(['_token']);
           
            $message = '';
            if ($item->id) {
                $item->update($data);
                $message = 'Uğurla dəyişiklik edildi';
            } else {
                $item = DriverNotificationTopic::create($data);
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
            ],500);
        }
    }

}
