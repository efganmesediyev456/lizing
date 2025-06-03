<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'fin' => 'required|string|max:20|unique:users',
            'role_id' => 'required|exists:roles,id',
            'password' => 'required|string|min:8|confirmed',
            'status' => 'required|in:active,deactive',
            'id_card_front' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'id_card_back' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $frontPath = $request->file('id_card_front')->store('public/id_cards');
        $backPath = $request->file('id_card_back')->store('public/id_cards');

        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'fin' => $request->fin,
            'role_id' => $request->role_id,
            'password' => Hash::make($request->password),
            'status' => $request->status,
            'id_card_front' => $frontPath,
            'id_card_back' => $backPath,
        ]);

        return response()->json(['success' => 'User created successfully', 'user' => $user]);
    }

    public function show(User $user)
    {
        return view('users.view', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return response()->json(['user' => $user, 'roles' => $roles]);
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'fin' => 'required|string|max:20|unique:users,fin,' . $user->id,
            'role_id' => 'required|exists:roles,id',
            'password' => 'nullable|string|min:8|confirmed',
            'status' => 'required|in:active,deactive',
            'id_card_front' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'id_card_back' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = [
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'fin' => $request->fin,
            'role_id' => $request->role_id,
            'status' => $request->status,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('id_card_front')) {
            Storage::delete($user->id_card_front);
            $data['id_card_front'] = $request->file('id_card_front')->store('public/id_cards');
        }

        if ($request->hasFile('id_card_back')) {
            Storage::delete($user->id_card_back);
            $data['id_card_back'] = $request->file('id_card_back')->store('public/id_cards');
        }

        $user->update($data);

        return response()->json(['success' => 'User updated successfully', 'user' => $user]);
    }

    public function destroy(User $user)
    {
        Storage::delete([$user->id_card_front, $user->id_card_back]);
        $user->delete();
        return response()->json(['success' => 'User deleted successfully']);
    }


    public function form(User $item = null)
    {
        if($item){
            $item->password=null;
        }
        $view = view('users.form', compact('item'))->render();

        return response()->json([
            "view" => $view
        ]);
    }


    public function save(Request $request, User $item = null)
    {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore(optional($item)->id),
            ],
            'password' => $item ? 'nullable|min:6' : 'required|min:6',
        ]);

        if(is_null($item)){
            $item=new User($request->all());
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

        $data = $request->only(['name', 'email','surname', 'fin']);
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
                "success"=>false,
                'message' => 'İstifadəçi uğurla yadda saxlanıldı.',
            ])->render();

        return response()->json([
                'view' => $view,
                'success' => true,

            ]);
    }
}
