<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DriverResource;
use App\Http\Resources\MobileSettingResource;
use App\Http\Resources\SuccessPageResource;
use App\Models\Driver;
use App\Models\MobileSetting;
use App\Models\SuccessPage;


class SuccessPageController extends Controller
{

    
    public function index()
    {
       $item = SuccessPage::first();
       return new SuccessPageResource($item);
    }

}
