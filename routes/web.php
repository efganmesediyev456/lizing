<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleManagementController;
use App\Http\Controllers\RolePermissionController;
use Illuminate\Support\Facades\Route;

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

Route::get('dahsboard', function () {})->name('dashboard');

Route::get('logout', function () {})->name('logout');


// Route::middleware(['auth'])->group(function () {
Route::get('users', [UserController::class, 'index']);
Route::post('users/form/{item?}', [UserController::class, 'form'])->name('users.form');
Route::post('users/save/{item?}', [UserController::class, 'save'])->name('users.save');


//role-managements
Route::get('role-managements', [RoleManagementController::class, 'index']);
Route::post('role-managements/form/{item?}', [RoleManagementController::class, 'form'])->name('role-managements.form');
Route::post('role-managements/save/{item?}', [RoleManagementController::class, 'save'])->name('role-managements.save');

//role-permission
Route::get('role-permissions', [RolePermissionController::class, 'index'])->name('role-permissions.index');
Route::get('role-permissions/create', [RolePermissionController::class, 'create'])->name("role-permissions.create");
Route::post('role-permissions/store', [RolePermissionController::class, 'store'])->name("role-permissions.store");



// });
