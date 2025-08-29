<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use DB;
use App\DataTables\UsersDataTable;
use Spatie\Permission\Models\Role;


class UserController extends Controller
{
    public function index()
    {
        $dataTable = new UsersDataTable(); 
        return $dataTable->render('users.index');
    }


    public function form(User $item , PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'users');
        $formTitle = $item->id ? 'İstifadəçi redaktə et' : 'İstifadəçi əlavə et';


        if ($item) {
            $item->password = null;
        }
        $roles= Role::get();
        $view = view('users.form', compact('item','roles'))->render();

        return response()->json([
            "view" => $view,
            "formTitle" => $formTitle
        ]);
    }


    public function save(Request $request, User $item, PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $permissionService->checkPermission($action, 'users');
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore(optional($item)->id),
            ],
            'password' => $item?->id ? 'nullable|min:6' : 'required|min:6|confirmed',
            'password_confirmation'=>$item?->id ? 'nullable':'required|min:6',
            'id_card_front'=>$item?->id ? 'nullable':'required',
            'id_card_back'=>$item?->id ? 'nullable':'required',
            'fin'=>'required',
            'role'=>'required',
        ]);

        try {
            DB::beginTransaction();

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors(),
                ], 422);
            }

            $data = $request->except('_token', 'id_card_front','id_card_back', 'role', 'password');
        
            if($request->hasFile('id_card_front')){
                $file = $request->file('id_card_front');
                $newFileName = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('documents', $newFileName, 'public');
                $data['id_card_front']=$path;
            }
             if($request->hasFile('id_card_back')){
                $file = $request->file('id_card_back');
                $newFileName = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('documents', $newFileName, 'public');
                $data['id_card_back']=$path;
            }
            if ($request->filled('password')) {
                $data['password'] = bcrypt($request->password);
            }

            $message = '';
            if ($item->id) {
                $item->update($data);
                $message = 'Uğurla dəyişiklik edildi';
            } else {
                $item = User::create($data);
                $message = 'Uğurla əlavə olundu';
            }

            $item->syncRoles([$request->role]);

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
                    'message'=>'System Error: '.$e->getMessage()
            ]);
        }
    }


    public function show(User $item){
      
        return view('users.show',compact('item'));
    }
}
