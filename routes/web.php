<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HourController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderHourController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TechnicalReportHourController;
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

Route::get('/', static function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/lang', [ProfileController::class, 'updateLang'])->name('profile.updateLang');
    Route::resource('/customers', CustomerController::class);
    Route::resource('/orders', OrderController::class);
    Route::resource('/hours', HourController::class);
    Route::resource('/locations', LocationController::class);
    Route::resource('/technical-report-hours', TechnicalReportHourController::class);
    Route::resource('/order-hours', OrderHourController::class);
});

Route::get('/print',[HourController::class,'print'])->name('hour.print');

require __DIR__.'/auth.php';
