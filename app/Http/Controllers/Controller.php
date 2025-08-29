<?php

namespace App\Http\Controllers;

use App\Services\MainService;
use App\Services\NotificationService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public $mainService;
    public function __construct()
    {
    }

    protected function responseMessage($status, $message, $data = null, $statusCode = 200, $route = null)
    {
        if(is_null($message)){
            $message = "Uğurlu əməliyyat";
        }
        if(is_null($status)){
            $status = "success";
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
            'route' => $route
        ], $statusCode);
    }
}
