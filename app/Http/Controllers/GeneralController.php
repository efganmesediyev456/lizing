<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\City;
use App\Models\Driver;
use App\Models\Vehicle;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\DataTables\DriversDataTable;

class GeneralController extends Controller
{
    public function getSerialCard(Request $request)
    {
       try{

        $vehicle = Vehicle::find( $request->value );
        if(is_null($vehicle)){
            throw new \Exception("Vehicle doesnt find");
        }

        return response()->json([
            'brand_id'=>$vehicle->brand_id,
            'model_id'=>$vehicle->model_id,
            'production_year'=>$vehicle->production_year,
        ] ,200);



       }catch(\Exception $e){
        return response()->json([
            "error"=> $e->getMessage()
            ], 500);
        }
    }


    public function getBrand(Request $request)
    {
       try{

        $brand = Brand::find( $request->value );
        if(is_null($brand)){
            throw new \Exception("Brand doesnt find");
        }

       $view = $brand->models?->map(fn($model)=>'<option value="'.$model->id.'">'.$model->title.'</option>')?->implode("");

       $view='<option value="">Secin</option>'.$view;
       return response()->json([
        'view'=>$view
       ],200);


       }catch(\Exception $e){
        return response()->json([
            "error"=> $e->getMessage()
            ], 500);
        }
    }


    public function delete(Request $request,PermissionService $permissionService)
    {
        $action ='delete';
        $permissionService->checkPermission($action,$request->permission);
        

         try{
            $model=$request->model;
            $item = app($model)->find($request->id);
            if(is_null($item)){
                throw new \Exception("Item doesnt find");
            }
            $item->delete();

      
            return response()->json([
                'success'=>'Successfully deleted'
            ],200);


       }catch(\Exception $e){
        return response()->json([
            "error"=> $e->getMessage()
            ], 500);
        }
    }

}
