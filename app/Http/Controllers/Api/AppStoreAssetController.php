<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AppStoreAssetResource;
use App\Http\Resources\DriverResource;
use App\Models\AppStoreAsset;
use App\Models\Driver;
use Illuminate\Http\Request;


class AppStoreAssetController extends Controller
{

    
    public function index()
    {
       $item = AppStoreAsset::first();
       return new AppStoreAssetResource($item);
    }


}
