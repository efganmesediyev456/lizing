<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\EmailVerifyRequest;
use App\Http\Requests\Api\Auth\LoginUserRequest;
use App\Http\Requests\Api\Auth\RegisterUserRequest;
use App\Http\Resources\DriverResource;
use App\Models\Driver;
use App\Models\DriverStatus;
use App\Models\PasswordReset;
use App\Models\User;
use App\Models\UserTemp;
use App\Models\UserVerify;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Api\UserAuthService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Lang;

class AuthController extends Controller
{

    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }



    public function login(LoginUserRequest $request)
    {
        try {
            $username = $request->email ?? $request->phone;
            $driver = Driver::where(function ($query) use ($request) {
                $query->when($request->email, function ($q) use ($request) {
                    $q->where('email', $request->email);
                })->when($request->phone, function ($q) use ($request) {
                    $q->orWhere('phone', $request->phone);
                });
            })->first();

            

            $activeStatus = DriverStatus::where('is_active', 1)->first();

           
            if (
                !$driver || !Hash::check($request->password, $driver->password)

                || ($driver->status_id != 0 && $driver->status_id != $activeStatus->id)


            ) {
                return $this->responseMessage('error', __('api.Password incorrect'), [], 401);
            }
            $url = app()->environment('production')
                ? url('oauth/token')
                : 'http://localhost:8001/oauth/token';
            $response = Http::asForm()->post($url, [
                'grant_type' => 'password',
                'client_id' => (int) env('CLIENT_ID'),
                'client_secret' => env('CLIENT_SECRET'),
                'username' => $username,
                'password' => $request->password,
                'scope' => ''
            ]);
            $response = $response->json();
            if ($response && array_key_exists('error', $response)) {
                return $this->responseMessage('error', $response['error_description'], [], 400);
            }
            $data['user'] = new DriverResource($driver);
            $data['token'] = $response['access_token'];
            $data['refresh_token'] = $response['refresh_token'];
            return $this->responseMessage('success', __('api.Login is successfully'), $data, 200);
        } catch (\Exception $e) {
            return $this->responseMessage('error', 'System Error: ' . $e->getMessage(), [], 500);
        }
    }



    public function user(Request $request)
    {
        return $request->user();
    }


    public function refreshToken(Request $request)
    {
        $request->validate([
            'token' => 'required',
        ], [
            'token.required' => __('api.token.required'),
        ]);

        try {

            $url = app()->environment('production')
                ? url('oauth/token')
                : 'http://localhost:8001/oauth/token';


            $response = Http::asForm()->post($url, [
                'grant_type' => 'refresh_token',
                'client_id' => env('CLIENT_ID'),
                'client_secret' => env('CLIENT_SECRET'),
                'refresh_token' => $request->token,
                'scope' => ''
            ]);
            $response = $response->json();

            if ($response and array_key_exists('error', $response)) {
                return $this->responseMessage('error', __('api.refresh_token_invalid'), [], 400);
            }
            if ($response and array_key_exists('access_token', $response) and array_key_exists('refresh_token', $response)) {
                $data['token'] = $response['access_token'];
                $data['refresh_token'] = $response['refresh_token'];
                return $this->responseMessage('success', __('api.Token was successfully changed'), $data, 200);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'System Error: ' . $e->getMessage()], 400);
        }
    }


    public function logout(Request $request)
    {
        try {
            $token =auth()->guard('driver')->user()->token();

            $token->revoke();

            return $this->responseMessage('success', 'Logout successful', [], 200);
        } catch (\Exception $e) {
            return $this->responseMessage('error', 'System Error: ' . $e->getMessage(), [], 500);
        }
    }
}
