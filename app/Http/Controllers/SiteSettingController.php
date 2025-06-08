<?php

namespace App\Http\Controllers;

use App\DataTables\ModelDatatable;
use App\DataTables\TechnicalReviewDatatable;
use App\DataTables\OilTypeDatatable;
use App\Models\BanType;
use App\Models\Brand;
use App\Models\Driver;
use App\Models\Model;
use App\Models\OilType;
use App\Models\SiteSetting;
use App\Models\TechnicalReview;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\DataTables\BrandsDataTable;


class SiteSettingController extends Controller
{
    public function index()
    {
        $item = SiteSetting::first(); 
        return view('site_settings.index',compact('item'));
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
            $item=SiteSetting::first();

            $data = $request->except('_token','file');

            if($request->hasFile('logo')){
                $file = $request->file('logo');
                $newFileName = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('site_settings', $newFileName, 'public');
                $data['logo']=$path;
            }
            
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
