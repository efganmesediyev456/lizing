<?php

namespace App\Http\Controllers;

use App\DataTables\ModelDatatable;
use App\DataTables\TechnicalReviewDatatable;
use App\DataTables\OilTypeDatatable;
use App\Http\Controllers\Controller;
use App\Models\BanType;
use App\Models\Brand;
use App\Models\Driver;
use App\Models\LeasingDetail;
use App\Models\MobileSetting;
use App\Models\Model;
use App\Models\OilType;
use App\Models\SiteSetting;
use App\Models\SuccessPage;
use App\Models\TechnicalReview;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\DataTables\BrandsDataTable;


class LeasingDetailController extends Controller
{
    public function index()
    {
        $item = LeasingDetail::first(); 

        return view('leasing_detail_pages.index',compact('item'));
    }


    public function save(Request $request)
    {
        
        // dd($request->all());
        // $validator = Validator::make($request->all(), [
        //     'logo' => 'required',
        // ]);
        try {
            DB::beginTransaction();

            // if ($validator->fails()) {
            //     return response()->json([
            //         'errors' => $validator->errors(),
            //     ], 422);
            // }
            $item=LeasingDetail::first();

            $data = $request->except('_token','image');

            
            $item->update($data);
           
            $message = 'Uğurla dəyişiklik edildi';


            DB::commit();

            return response()->json([
                'success' => true,
                'message'=> $message
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'view' => '',
                'errors' => true,
                'message' => 'System Error: '.$e->getMessage()
            ]);
        }
    }
}
