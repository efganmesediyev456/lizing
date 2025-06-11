<?php

use App\Http\Controllers\DriverController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleManagementController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\BanTypeController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ModelController;
use App\Http\Controllers\OilChangeTypesController;
use App\Http\Controllers\CitiesController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TechnicalReviewController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\InsuranceController;
use App\Http\Controllers\OilChangeController;
use App\Http\Controllers\OilTypeController;
use App\Http\Controllers\SiteSettingController;
use App\Http\Controllers\LeasingController;













/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/





Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'attempt']);


Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [HomeController::class,'dashboard'])->name('dashboard')->middleware('permission:dashboard.index');
    Route::get('/', [HomeController::class,'dashboard'])->name('dashboard')->middleware('permission:dashboard.index');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');


    Route::get('users', [UserController::class, 'index'])->name('users.index')->middleware("permission:users.index");
    Route::post('users/form/{item?}', [UserController::class, 'form'])->name('users.form');
    Route::post('users/save/{item?}', [UserController::class, 'save'])->name('users.save');
    Route::get('users/{item?}', [UserController::class, 'show'])->name('users.show');


    //role-managements
    Route::get('role-managements', [RoleManagementController::class, 'index'])->name('role-managements.index')->middleware("permission:role-managements.index");
    Route::post('role-managements/form/{item?}', [RoleManagementController::class, 'form'])->name('role-managements.form');
    Route::post('role-managements/save/{item?}', [RoleManagementController::class, 'save'])->name('role-managements.save');

    //role-permission
    Route::get('role-permissions', [RolePermissionController::class, 'index'])->name('role-permissions.index')->middleware("permission:role-permissions.index");
    Route::get('role-permissions/create/{item?}', [RolePermissionController::class, 'create'])->name("role-permissions.create");
    Route::post('role-permissions/store/{item?}', [RolePermissionController::class, 'store'])->name("role-permissions.store");
    Route::get('role-permissions/show/{item}', [RolePermissionController::class, 'show'])->name("role-permissions.show");

    //drivers
    Route::get('drivers', [DriverController::class, 'index'])->name('drivers.index')->middleware('permission:drivers.index');

    Route::post('drivers/form/{item?}', [DriverController::class, 'form'])->name('drivers.form');
    Route::post('drivers/save/{item?}', [DriverController::class, 'save'])->name('drivers.save');
    Route::get('drivers/{item?}', [DriverController::class, 'show'])->name('drivers.show');



    //vehicles
    Route::get('vehicles', [VehicleController::class, 'index'])->name('vehicles.index')->middleware('permission:vehicles.index');
    Route::post('vehicles/form/{item?}', [VehicleController::class, 'form'])->name('vehicles.form');
    Route::post('vehicles/save/{item?}', [VehicleController::class, 'save'])->name('vehicles.save');
    Route::get('vehicles/{item?}', [VehicleController::class, 'show'])->name('vehicles.show');


    //brands
    Route::get('brands', [BrandController::class, 'index'])->name('brands.index')->middleware("permission:brands.index");
    Route::post('brands/form/{item?}', [BrandController::class, 'form'])->name('brands.form');
    Route::post('brands/save/{item?}', [BrandController::class, 'save'])->name('brands.save');


    //ban types
    Route::get('ban-types', [BanTypeController::class, 'index'])->name('ban-types.index')->middleware('permission:ban-types.index');
    Route::post('ban-types/form/{item?}', [BanTypeController::class, 'form'])->name('ban-types.form');
    Route::post('ban-types/save/{item?}', [BanTypeController::class, 'save'])->name('ban-types.save');

    //ban types
    Route::get('models', [ModelController::class, 'index'])->name('models.index')->middleware('permission:models.index');
    Route::post('models/form/{item?}', [ModelController::class, 'form'])->name('models.form');
    Route::post('models/save/{item?}', [ModelController::class, 'save'])->name('models.save');



    //oil_change_types
    Route::get('oil_change_types', [OilChangeTypesController::class, 'index'])->name('oil_change_types.index')->middleware("permission:oil_change_types.index");
    Route::post('oil_change_types/form/{item?}', [OilChangeTypesController::class, 'form'])->name('oil_change_types.form');
    Route::post('oil_change_types/save/{item?}', [OilChangeTypesController::class, 'save'])->name('oil_change_types.save');


    //cities
    Route::get('cities', [CitiesController::class, 'index'])->name('cities.index')->middleware('permission:cities.index');
    Route::post('cities/form/{item?}', [CitiesController::class, 'form'])->name('cities.form');
    Route::post('cities/save/{item?}', [CitiesController::class, 'save'])->name('cities.save');


    //technical_reviews
    Route::get('technical-reviews', [TechnicalReviewController::class, 'index'])->name('technical_reviews.index')->middleware("permission:technical-reviews.index");
    Route::post('technical-reviews/form/{item?}', [TechnicalReviewController::class, 'form'])->name('technical_reviews.form');
    Route::post('technical-reviews/save/{item?}', [TechnicalReviewController::class, 'save'])->name('technical_reviews.save');
    Route::get('technical-reviews/{item?}', [TechnicalReviewController::class, 'show'])->name('technical_reviews.show');


     //insurances
    Route::get('insurances', [InsuranceController::class, 'index'])->name('insurances.index')->middleware("permission:insurances.index");
    Route::post('insurances/form/{item?}', [InsuranceController::class, 'form'])->name('insurances.form');
    Route::post('insurances/save/{item?}', [InsuranceController::class, 'save'])->name('insurances.save');
    Route::get('insurances/show/{item}', [InsuranceController::class, 'show'])->name("insurances.show");


      //oil_changes
    Route::get('oil-changes', [OilChangeController::class, 'index'])->name('oil_changes.index')->middleware("permission:oil-changes.index");
    Route::post('oil-changes/form/{item?}', [OilChangeController::class, 'form'])->name('oil_changes.form');
    Route::post('oil-changes/save/{item?}', [OilChangeController::class, 'save'])->name('oil_changes.save');
    Route::get('oil-changes/show/{item}', [OilChangeController::class, 'show'])->name("oil_changes.show");


    Route::post('general/id-card-serial-number',[GeneralController::class,'getSerialCard'])->name('getSerialCard');
    Route::post('general/brands',[GeneralController::class,'getBrand'])->name('getBrand');
    Route::post('general/driver/fin',[GeneralController::class,'getDriverFin'])->name('getDriverFin');
    Route::post('general/delete',[GeneralController::class,'delete'])->name('general.delete');

   
    Route::get('oil-types', [OilTypeController::class, 'index'])->name('oil_types.index')->middleware('permission:oil-types.index');
    Route::post('oil-types/form/{item?}', [OilTypeController::class, 'form'])->name('oil_types.form');
    Route::post('oil-types/save/{item?}', [OilTypeController::class, 'save'])->name('oil_types.save');


    Route::get('logo-managements', [SiteSettingController::class, 'index'])->name('logo-managements.index')->middleware('permission:logo-managements.index');
    Route::post('logo-managements', [SiteSettingController::class, 'save'])->name('logo-managements.save')->middleware("permission:logo-managements.edit");



     //leasing
    Route::get('leasing', [LeasingController::class, 'index'])->name('leasing.index')->middleware('permission:leasing.index');
    Route::post('leasing/form/{item?}', [LeasingController::class, 'form'])->name('leasing.form');
    Route::post('leasing/save/{item?}', [LeasingController::class, 'save'])->name('leasing.save');
    Route::get('leasing/{item?}', [LeasingController::class, 'show'])->name('leasing.show');
    


    
});
