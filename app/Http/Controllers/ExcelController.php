<?php

namespace App\Http\Controllers;

use App\Helpers\GoogleSheetsHelper;
use App\Http\Requests\DriverNotificationRequest;
use App\Models\Brand;
use App\Models\City;
use App\Models\Credit;
use App\Models\Driver;
use App\Models\DriverNotification;
use App\Models\DriverNotificationTopic;
use App\Models\Insurance;
use App\Models\Leasing;
use App\Models\Model;
use App\Models\TechnicalReview;
use App\Models\Vehicle;
use App\Services\PermissionService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\DataTables\DriversDataTable;
use App\DataTables\DriverNotificationTopicDatatable;
use Maatwebsite\Excel\Facades\Excel;
use Ramsey\Uuid\Type\Decimal;
class ExcelController extends Controller
{


   
    
    public function index()
    {
        return view('excel.index');
    }


    public function form(Driver $item, PermissionService $permissionService)
    {
        $action = $item->id ? 'edit' : 'create';
        $formTitle = $item->id ? 'Excel redaktə et' : 'Excel əlavə et';
        $permissionService->checkPermission($action, 'excel');
        $view = view('excel.form')->render();
        return response()->json([
            "view" => $view,
            "formTitle" => $formTitle
        ]);
    }


   

    public function store(Request $request){
    //    try{

        set_time_limit(0); // limitsiz edir

        $path = $request->file('file')->getRealPath();
        $data = Excel::toArray([],$request->file('file'));
        $firstSheet = $data[0];
        DB::beginTransaction();

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

       
        // DB::table("brands")->delete();
        // DB::table("models")->delete();
        // DB::table("drivers")->delete();
        // DB::table("vehicles")->delete();
        // DB::table("leasings")->delete();
        // DB::table("leasing_payments")->delete();
        // DB::table("payments")->delete();
        // DB::table("insurances")->delete();
        // DB::table("technical_reviews")->delete();



        foreach ($firstSheet as $index => $row) {
            if ($index === 0) continue;
            if ($index === 1) continue;
            if(is_null($row[0])) continue;
            //brand
            // if (isset($row[2])) {
            //     $column = $row[2];
            //     if(!Brand::where('title',$column)->exists()){
            //         Brand::create([
            //             "title"=>$column
            //         ]);
            //     }
            // }
            // //model
            // if (isset($row[3])) {
            //     $column = $row[3];
            //     if(!Model::where('title',$column)->exists()){
            //         Model::create([
            //             "brand_id"=>Brand::where('title',$row[2])->first()?->id,
            //             "title"=>$column
            //         ]);
            //     }
            // }
            // //drivers
            // if (isset($row[16])) {
            //     $column = $row[16];
            //     $user = explode(' ',$column);
            //     $driver = new Driver([
            //         "name" => $user[1],
            //         "surname"=> $user[0],
            //         "father_name"=> $user[2],
            //         "email"=> strtolower($user[1]).strtolower($user[0]).'@gmail.com',
            //         "password"=>Hash::make("password"),
            //     ]);
            //     $driver->save();
            // }


            // //vehicles
            // if (isset($row[4])) {
            //     $column = $row[4];
            //     $vehicle = new Vehicle([
            //         "state_registration_number" => $column,
            //         "production_year" =>  $row[5],
            //         "table_id_number" => $row[1],
            //         "engine"=> $row[8],
            //         "brand_id"=>Brand::where('title',$row[2])->first()?->id,
            //         "model_id"=>Model::where('title',$row[3])->first()?->id,
            //     ]);
            //     $vehicle->save();
            // }
            // dd("salam");



            //leasingler 
            $column = $row[16];
            $user = explode(' ',$column);

           
            $startDate = Carbon::createFromDate(1899, 12, 30)
                ->addDays($row[17])
                ->format('Y-m-d');
            $endDate = Carbon::createFromDate(1899, 12, 30)->addDays($row[18])->format("Y-m-d");

           

            $data = [
                    "deposit_payment" => $row[19],
                    "deposit_debt" => $row[20],
                    "vehicle_id" => Vehicle::where('state_registration_number', $row[4])->first()?->id,
                    "driver_id" => Driver::where('name', @$user[1])
                                    ->where("surname",@$user[0])
                                    ->where("father_name",@$user[2])
                                    ->first()?->id,
                    "has_advertisement" => $row[11] == 'Reklam icazesi var',
                    "leasing_price" => $row[22]!=0 ? $row[22]*$row[23] : ($row[24]*$row[21]),
                    "daily_payment" => (float)$row[21],
                    "monthly_payment" => (float) $row[22],
                    "leasing_period_days" => $row[24],
                    "leasing_period_months" => $row[23],
                    "start_date" => $startDate,
                    "end_date"=>$endDate,
                    "brand_id" => Brand::where("title", $row[2])->first()?->id,
                    "model_id" => Model::where("title", $row[3])->first()?->id,
                    'leasing_status_id' => 1
                ];

            $request = new Request($data);
            $controller = new \App\Http\Controllers\LeasingController();
            $item = new Leasing();
            $permissionService = app()->make(\App\Services\PermissionService::class);
            $response = $controller->save($request, $item, $permissionService);

            // $insurance = Insurance::create([
            //             "driver_id" => Driver::where('name', @$user[1])
            //                         ->where("surname",@$user[0])
            //                         ->where("father_name",@$user[2])
            //                         ->first()?->id,
            //             "brand_id" => Brand::where("title", $row[2])->first()?->id,
            //             "model_id" => Model::where("title", $row[3])->first()?->id,
            //             "vehicle_id" => Vehicle::where('state_registration_number', $row[4])->first()?->id,
            //             "production_year" =>  $row[5],
            //             "company_name" => $row[14],
            //             "end_date"=>Carbon::createFromDate(1899, 12, 30)->addDays($row[13])->format("Y-m-d")

            // ]);


            // $technicalReview = TechnicalReview::create([
            //             "driver_id" => Driver::where('name', @$user[1])
            //                         ->where("surname",@$user[0])
            //                         ->where("father_name",@$user[2])
            //                         ->first()?->id,
            //             "brand_id" => Brand::where("title", $row[2])->first()?->id,
            //             "model_id" => Model::where("title", $row[3])->first()?->id,
            //             "vehicle_id" => Vehicle::where('state_registration_number', $row[4])->first()?->id,
            //             "production_year" =>  $row[5],
            //             "end_date"=>Carbon::createFromDate(1899, 12, 30)->addDays($row[12])->format("Y-m-d")
            // ]);

            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

           
            DB::commit();
            
        }
        

    //    }catch(\Exception $e){
    //         DB::rollBack();
    //         dd($e->getMessage());
    //    }

        
        dd("oldu");
    }


    function parseAzPriceToDouble($price)
    {
        $price = str_replace(['₼', ' '], '', $price);

        $price = str_replace(['.', ','], ['', '.'], $price);

        return (double)$price;
    }





    public function credits(){
        $data = GoogleSheetsHelper::readSheet(env('GOOGLE_SPREADSHEET_RANGE'));
        $dataWithoutHeader = array_slice($data, 2);
        DB::table('credits')->delete();
        foreach($dataWithoutHeader as $dd){
            $stateRegistrationId = $dd[3];
            $vehicle = Vehicle::where('state_registration_number', $stateRegistrationId)->first();

            if($dd[0]==''){
                break;
            }

            if(is_null($vehicle)){
                $model = Model::where('title',$dd[2])->first();
                if(is_null($model)){
                    $model = Model::create([
                        "title"=>$dd[2]
                    ]);
                }
                
                 
           
                $vehicle=Vehicle::create([
                    "state_registration_number"=>$stateRegistrationId,
                    "model_id"=>$model->id,
                    "table_id_number"=>$dd[1],
                    "production_year"=>$dd[4]
                ]);
            }
            
            Credit::create([
                "tableId" => $dd[1],
                "date"=>Carbon::parse($dd[5])->format("Y-m-d"),
                "brand_id"=>$vehicle->brand_id,
                "model_id"=>$vehicle->model_id,
                "vehicle_id"=>$vehicle->id,
                "production_year"=>$dd[4],
                "calculation"=>array_key_exists(6, $dd) ? $dd[6] : null,
                "code"=>$dd[7],
                "down_payment"=>$this->parseAzPriceToDouble($dd[8]),
                "total_payable_loan"=>$this->parseAzPriceToDouble($dd[14]),
                "total_months"=>$dd[11],
                "remaining_months"=>$dd[12],
                "remaining_amount"=>$this->parseAzPriceToDouble($dd[13]),
                "monthly_payment"=>$this->parseAzPriceToDouble($dd[9]),
            ]);
        }

        dd( "tamamlandi");
        // return response()->json($data);
    }



    public function technicalReviews(){
         $data = GoogleSheetsHelper::readSheet('Texniki baxişlar ve Sigorta!A:G');
         $dataWithoutHeader = array_slice($data, 2);
         foreach($dataWithoutHeader as $dd){
            $vehicle = $dd[2];
            $vehicle = Vehicle::where('state_registration_number', $vehicle)->first();
            // dd($vehicle);
            $technicalReview = TechnicalReview::where('vehicle_id', $vehicle->id)->first();
            $technicalReview->transmission_oil_suppliers = array_key_exists(5,$dd) ? $dd[5] : null;
            $technicalReview->tableId= $dd[1];
            $technicalReview->save();
         }
        dd("tamamlandi");
    }


    public function insurances(){
         $data = GoogleSheetsHelper::readSheet('Texniki baxişlar ve Sigorta!J:O');
         $dataWithoutHeader = array_slice($data, 2);
         $cleanedData = array_slice($dataWithoutHeader, 0, count($dataWithoutHeader) - 2);

         foreach($cleanedData as $clean){

            $vehicle = Vehicle::where('state_registration_number', $clean[1])->first();
            $insurance = Insurance::where('vehicle_id', $vehicle->id)->first();
            $insurance->tableId = $clean[0];
            $insurance->save();
            // $insurance = Insurance::where('')
         }
        
         dd("tamamlandi");
    }


    public function penalties(){
        $data = GoogleSheetsHelper::readSheet('Faktiki Cerimeler');
        dd($data);
        dd("tamamlandi");
    }


}
