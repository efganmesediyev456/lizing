<?php

namespace App\Http\Controllers;

use App\DataTables\LeasingActiveDatatable;
use App\DataTables\LeasingDatatable;
use App\Models\Brand;
use App\Models\Driver;
use App\Models\Leasing;
use App\Models\LeasingStatus;
use App\Models\Model;
use App\Models\OilChangeType;
use App\Models\OilType;
use App\Models\Payment;
use App\Models\Vehicle;
use App\Services\PermissionService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\DataTables\VehiclesDataTable;

class LeasingActiveController extends Controller
{
    public function index()
    {
        //salam
        $dataTable = new LeasingActiveDatatable(); 
        $filterOptions = $dataTable->getFilterOptions();

        return $dataTable->render('active_leasing.index',['filterOptions'=>$filterOptions]);
    }
}
