<?php

namespace App\Http\Controllers;

use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function login(){
        return view("login");
    }
    public function attempt(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json(['success' => 'Login successful.'], 200);
        }

        return response()->json(['error' => 'Invalid credentials.'], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return redirect()->route('login');
    }


    public function profile(){
        $user = auth()->user();
        return view('profile', compact("user"));
    }


    public function updateProfile(Request $request){
        $user = auth()->user();
        $this->validate($request,[
            "name"=>"required",
            "surname"=>"required",
            "email"=>"required",
            "password"=>"sometimes|confirmed",
        ]);

        $data = $request->except(['_token','password','password_confirmation', 'image']);
        if($request->has("password") and $request->passworrd){
            $data['password']=Hash::make($request->password);
        }


        if($request->hasFile('image')){
                $file = $request->file('image');
                $newFileName = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('users', $newFileName, 'public');
                $data['image']=$path;
        }
        
        $user->fill($data);
        $user->save();
        return response()->json([
            "success"=>true,
            "message"=>"Successfuly Updated"
        ]);
    }
}
