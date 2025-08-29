<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VehicleResource;
use App\Models\Driver;
use App\Models\Vehicle;
use App\Http\Resources\LeasingResource;


class VehicleController extends Controller
{

    
    public function index()
    {
       $vehicles = Vehicle::all();
       return VehicleResource::collection($vehicles);
    }

}
