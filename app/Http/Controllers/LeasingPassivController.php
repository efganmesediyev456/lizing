<?php

namespace App\Http\Controllers;

use App\DataTables\LeasingDatatable;
use App\DataTables\LeasingPassivDatatable;
use App\DataTables\LeasingPaymentDatatable;
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

class LeasingPassivController extends Controller
{
    public function index()
    {
        $dataTable = new LeasingPassivDatatable(); 
        $filterOptions = $dataTable->getFilterOptions();
        return $dataTable->render('passiv_leasing.index',['filterOptions'=>$filterOptions]);
    }

    public function show(Leasing $item){
        $leasingPayments = $item->passiveReason()->first()->leasing->leasingPayments();

        $dataTable = new LeasingPaymentDatatable($leasingPayments);
        $driver = $item->passiveReason()->first()->driver;
        return $dataTable->render('passiv_leasing.show', compact('item', 'leasingPayments','driver', 'dataTable'));
    }
}
