<?php

namespace App\Http\Controllers;

use App\DataTables\PenaltyTypesDatatable;
use App\DataTables\RevenueDatatable;
use App\Exports\BrandExport;
use App\Exports\RevenueExport;
use App\Models\Brand;
use App\Models\Driver;
use App\Models\Payment;
use App\Models\PenaltyType;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\DataTables\BrandsDataTable;
use Maatwebsite\Excel\Facades\Excel;


class RevenueController extends Controller
{
    public function index()
    {
        $dataTable = new RevenueDatatable(); 
        return $dataTable->render('revenues.index');
    }

    public function export(){
        return Excel::download(new RevenueExport(),'revenues.xlsx');
    }

    public function show(Payment $item){
        return view('revenues.show', compact('item'));
    }
}
