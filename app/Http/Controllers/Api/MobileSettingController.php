<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DriverResource;
use App\Http\Resources\MobileSettingResource;
use App\Models\Driver;
use App\Models\MobileSetting;


class MobileSettingController extends Controller
{

    
    public function index()
    {
       $item = MobileSetting::first();
       return new MobileSettingResource($item);
    }

}
