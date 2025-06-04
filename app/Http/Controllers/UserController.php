<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use DB;
use App\DataTables\UsersDataTable;


class UserController extends Controller
{
    public function index()
    {
        $dataTable = new UsersDataTable(); 
        return $dataTable->render('users.index');
    }


    public function form(User $item)
    {
        if ($item) {
            $item->password = null;
        }
        $view = view('users.form', compact('item'))->render();

        return response()->json([
            "view" => $view
        ]);
    }


    public function save(Request $request, User $item)
    {

        
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
        ]);

        try {
            DB::beginTransaction();

            if (is_null($item)) {
                $item = new User($request->all());
            }

            if ($validator->fails()) {
                $view = view('users.form', [
                    'item' => $item,
                    'errors' => $validator->errors(),
                ])->render();

                return response()->json([
                    'view' => $view,
                    'errors' => true,
                ]);
            }

            $data = $request->only(['name', 'email', 'surname', 'fin', 'status']);
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

            if ($item->id) {
                $item->update($data);
            } else {
                $item = User::create($data);
            }

            $view = view('users.form', [
                'item' => $item,
                "success" => false,
                'message' => 'İstifadəçi uğurla yadda saxlanıldı.',
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
                    'message'=>'System Error: '.$e->getMessage()
            ]);
        }
    }
}
