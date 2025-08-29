<?php

namespace App\Http\Controllers;

use App\DataTables\ModelDatatable;
use App\DataTables\TechnicalReviewDatatable;
use App\DataTables\OilTypeDatatable;
use App\Exports\PaymentExport;
use App\Models\BanType;
use App\Models\Brand;
use App\Models\Driver;
use App\Models\Model;
use App\Models\OilType;
use App\Models\Payment;
use App\Models\TechnicalReview;
use App\Models\Vehicle;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\DataTables\PaymentsDatatable;
use Maatwebsite\Excel\Facades\Excel;


class PaymentController extends Controller
{
    public function index()
    {
        $dataTable = new PaymentsDatatable(); 
        $filterOptions = $dataTable->getFilterOptions();
        return $dataTable->render('payments.index', compact('filterOptions'));
    }



    public function show(Payment $item){
      
        return view('payments.show',compact('item'));
    }

    public function export(Request $request) 
    {
        
        return Excel::download(new PaymentExport, 'payments.xlsx');
    }

}
