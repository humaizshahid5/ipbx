<?php

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



Auth::routes();
Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');
Route::get('activation', [App\Http\Controllers\ActivationController::class, 'index'])->middleware(['auth'])->name('activation');
Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');
Route::get('/calls', [App\Http\Controllers\CallsController::class, 'index'])->middleware(['auth', 'authentication'])->name('calls');
Route::get('/users', [App\Http\Controllers\UsermanegmentController::class, 'index'])->middleware(['auth', 'authentication'])->name('users');
Route::get('/api', [App\Http\Controllers\ApiController::class, 'index'])->middleware(['auth', 'authentication'])->name('api');
Route::get('/report', [App\Http\Controllers\ReportController::class, 'index'])->middleware(['auth', 'authentication'])->name('report');
Route::get('/pricing', [App\Http\Controllers\PricingController::class, 'index'])->middleware(['auth' ,'authentication'])->name('pricing');
Route::get('/del_user/{user_id}/del', [App\Http\Controllers\UsermanegmentController::class, 'del']);
Route::get('/del_api/{api_id}/del', [App\Http\Controllers\ApiController::class, 'del']);
Route::post('/create_user', [App\Http\Controllers\UsermanegmentController::class, 'create'])->name('create_user');
Route::post('/create_api', [App\Http\Controllers\ApiController::class, 'create'])->name('create_api');
Route::post('/add_pricing', [App\Http\Controllers\PricingController::class, 'store'])->name('add_pricing');
Route::post('/system_activate', [App\Http\Controllers\ActivationController::class, 'activate'])->name('system_activate');
Route::get('/search_calls', [App\Http\Controllers\CallsController::class, 'search'])->name('search_calls');
Route::post('/add_report', [App\Http\Controllers\ReportController::class, 'store'])->name('add_report');
Route::get('/del_price/{user_id}/del', [App\Http\Controllers\PricingController::class, 'destroy']);
Route::get('/del_report/{user_id}/del', [App\Http\Controllers\ReportController::class, 'destroy']);
Route::get('/pdf/{user_id}/id', [App\Http\Controllers\ReportController::class, 'report'])->name('pdf');
Route::get('/auto_report', [App\Http\Controllers\ReportController::class, 'auto_report'])->name('auto_report');
Route::get('/sendnow/{user_id}/send', [App\Http\Controllers\ReportController::class, 'sendnow']);











