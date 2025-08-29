<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TermAndConditionResource;
use App\Http\Resources\VehicleResource;
use App\Models\Driver;
use App\Models\LeasingDetail;
use App\Models\Vehicle;
use App\Http\Resources\LeasingResource;


class TermsAndConditionController extends Controller
{


    public function index(){
        $term = LeasingDetail::first();
        if (!$term) {
            return $this->responseMessage(null, 'Term and condition page not found', null, 200, null);
        }
        return $this->responseMessage(null, null, new TermAndConditionResource($term), 200, null);
    }

}
