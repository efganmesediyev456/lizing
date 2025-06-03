<?php

use App\Http\Controllers\UserController;
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

    Route::get('dahsboard',function(){

    })->name('dashboard');

    Route::get('logout',function(){

    })->name('logout');


// Route::middleware(['auth'])->group(function () {
    Route::get('users',[ UserController::class, 'index']);
    Route::post('users/form/{item?}', [UserController::class, 'form'])->name('users.form');
    Route::post('users/save/{item?}', [UserController::class, 'save'])->name('users.save');

// });
