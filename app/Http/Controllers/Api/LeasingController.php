<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VehicleResource;
use App\Models\Driver;
use App\Models\Vehicle;
use App\Http\Resources\LeasingResource;


class LeasingController extends Controller
{


    public function getLeasing(){
        $driver = auth('driver')->user();
        $leasing = $driver->leasing;

        if (!$leasing) {
            return $this->responseMessage(null, 'Leasing not found', null, 200, null);
        }
        return $this->responseMessage(null, null, new LeasingResource($leasing), 200, null);
    }

}
