<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\DonorsController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\RequestsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Redirect::route('home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function (){
    Route::middleware(['auth', 'admin'])->group(function () {
        // Blood bank admin routes
        Route::get('/blood_bank',[InventoryController::class,'index'])->name('blood_bank.home');
        Route::get('/blood_bank/stock',[InventoryController::class,'view'])->name('blood_bank.view');
        Route::get('/blood_bank/add',[InventoryController::class,'create'])->name('blood_bank.create');
        Route::post('/blood_bank/add',[InventoryController::class,'store'])->name('blood_bank.store');
        Route::get('/blood_bank/requests',[RequestsController::class,'index'])->name('requests.index');
        Route::post('/blood_bank/approve/{id}',[RequestsController::class,'approve'])->name('admin_requests.approve');
        Route::post('/blood_bank/deny/{id}',[RequestsController::class,'deny'])->name('admin_requests.deny');
        Route::get('/blood_bank/donors',[DonorsController::class,'index'])->name('donors.index');
    });

    Route::middleware(['auth', 'customer'])->group(function () {
        // Customer routes
        Route::get('/customer',[CustomerController::class,'index'])->name('customer.home');
        Route::get('/customer/request',[CustomerController::class,'create'])->name('customer.request');
        Route::get('/customer/requests',[CustomerController::class,'view'])->name('customer.requests');
        Route::post('/customer/request',[RequestsController::class,'store'])->name('customer.store');
        Route::get('/customer/donate',[CustomerController::class,'donate'])->name('customer.donate');
        Route::post('/customer/donate',[CustomerController::class,'store'])->name('customer.donate');
    });

    Route::middleware(['auth', 'doctor'])->group(function () {
        // Doctor routes
        Route::get('/doctor',[DoctorController::class,'index'])->name('doctor.home');
        Route::post('/doctor/approve/{id}',[DoctorController::class,'approve'])->name('doctor_requests.approve');
        Route::post('/doctor/deny/{id}',[DoctorController::class,'deny'])->name('doctor_requests.deny');
        Route::get('/doctor/request',[DoctorController::class,'show'])->name('doctor.request');
        Route::post('/doctor/request',[RequestsController::class,'request_code'])->name('doctor.store');
    });
});
