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
    Route::get('dashboard', [HomeController::class,'dashboard'])->name('dashboard');
    Route::get('/', [HomeController::class,'dashboard'])->name('dashboard');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');


    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::post('users/form/{item?}', [UserController::class, 'form'])->name('users.form');
    Route::post('users/save/{item?}', [UserController::class, 'save'])->name('users.save');


    //role-managements
    Route::get('role-managements', [RoleManagementController::class, 'index'])->name('role-managements.index');
    Route::post('role-managements/form/{item?}', [RoleManagementController::class, 'form'])->name('role-managements.form');
    Route::post('role-managements/save/{item?}', [RoleManagementController::class, 'save'])->name('role-managements.save');

    //role-permission
    Route::get('role-permissions', [RolePermissionController::class, 'index'])->name('role-permissions.index');
    Route::get('role-permissions/create', [RolePermissionController::class, 'create'])->name("role-permissions.create");
    Route::post('role-permissions/store', [RolePermissionController::class, 'store'])->name("role-permissions.store");


    //drivers
    Route::get('drivers', [DriverController::class, 'index'])->name('drivers.index');
    Route::post('drivers/form/{item?}', [DriverController::class, 'form'])->name('drivers.form');
    Route::post('drivers/save/{item?}', [DriverController::class, 'save'])->name('drivers.save');



    //vehicles
    Route::get('vehicles', [VehicleController::class, 'index'])->name('vehicles.index');
    Route::post('vehicles/form/{item?}', [VehicleController::class, 'form'])->name('vehicles.form');
    Route::post('vehicles/save/{item?}', [VehicleController::class, 'save'])->name('vehicles.save');


    //brands
    Route::get('brands', [BrandController::class, 'index'])->name('brands.index');
    Route::post('brands/form/{item?}', [BrandController::class, 'form'])->name('brands.form');
    Route::post('brands/save/{item?}', [BrandController::class, 'save'])->name('brands.save');


    //ban types
    Route::get('ban-types', [BanTypeController::class, 'index'])->name('ban-types.index');
    Route::post('ban-types/form/{item?}', [BanTypeController::class, 'form'])->name('ban-types.form');
    Route::post('ban-types/save/{item?}', [BanTypeController::class, 'save'])->name('ban-types.save');

    //ban types
    Route::get('models', [ModelController::class, 'index'])->name('models.index');
    Route::post('models/form/{item?}', [ModelController::class, 'form'])->name('models.form');
    Route::post('models/save/{item?}', [ModelController::class, 'save'])->name('models.save');

    //ban types
    Route::get('models', [ModelController::class, 'index'])->name('models.index');
    Route::post('models/form/{item?}', [ModelController::class, 'form'])->name('models.form');
    Route::post('models/save/{item?}', [ModelController::class, 'save'])->name('models.save');

    //oil_change_types
    Route::get('oil_change_types', [OilChangeTypesController::class, 'index'])->name('oil_change_types.index');
    Route::post('oil_change_types/form/{item?}', [OilChangeTypesController::class, 'form'])->name('oil_change_types.form');
    Route::post('oil_change_types/save/{item?}', [OilChangeTypesController::class, 'save'])->name('oil_change_types.save');


    //cities
    Route::get('cities', [CitiesController::class, 'index'])->name('cities.index');
    Route::post('cities/form/{item?}', [CitiesController::class, 'form'])->name('cities.form');
    Route::post('cities/save/{item?}', [CitiesController::class, 'save'])->name('cities.save');

});
