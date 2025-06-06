<?php

namespace App\Http\Controllers;

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

}
