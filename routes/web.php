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
Route::get('/users', [App\Http\Controllers\UsermanegmentController::class, 'index'])->middleware(['auth', 'authentication', 'access'])->name('users');
Route::get('/api', [App\Http\Controllers\ApiController::class, 'index'])->middleware(['auth', 'authentication' , 'access'])->name('api');
Route::get('/report', [App\Http\Controllers\ReportController::class, 'index'])->middleware(['auth', 'authentication' , 'access'])->name('report');
Route::get('/phonebook', [App\Http\Controllers\PhonebookController::class, 'index'])->middleware(['auth', 'authentication' , 'access'])->name('phonebook');

Route::get('/pricing', [App\Http\Controllers\PricingController::class, 'index'])->middleware(['auth' ,'authentication', 'access'])->name('pricing');
Route::get('/del_user/{user_id}/del', [App\Http\Controllers\UsermanegmentController::class, 'del']);
Route::get('/del_api/{api_id}/del', [App\Http\Controllers\ApiController::class, 'del']);
Route::get('/del_phonebook/{phonebook_id}/del', [App\Http\Controllers\PhonebookController::class, 'del']);
Route::get('/edit_phonebook/{phonebook_id}/edit', [App\Http\Controllers\PhonebookController::class, 'get_edit']);
Route::get('/edit_user/{user_id}/edit', [App\Http\Controllers\UsermanegmentController::class, 'user_edit']);
Route::get('/price_edit/{price_id}/edit', [App\Http\Controllers\PricingController::class, 'edit_price']);
Route::get('/report_edit/{report_eit}/edit', [App\Http\Controllers\ReportController::class, 'report_edit']);
Route::get('/api_edit/{api_edit}/edit', [App\Http\Controllers\ApiController::class, 'api_edit']);





Route::get('/number_import', [App\Http\Controllers\PhonebookController::class, 'import']);
Route::post('/create_user', [App\Http\Controllers\UsermanegmentController::class, 'create'])->name('create_user');
Route::post('/create_api', [App\Http\Controllers\ApiController::class, 'create'])->name('create_api');
Route::post('/add_pricing', [App\Http\Controllers\PricingController::class, 'store'])->name('add_pricing');
Route::post('/system_activate', [App\Http\Controllers\ActivationController::class, 'activate'])->name('system_activate');
Route::get('/search_calls', [App\Http\Controllers\CallsController::class, 'search'])->name('search_calls');
Route::post('/add_report', [App\Http\Controllers\ReportController::class, 'store'])->name('add_report');
Route::post('/add_number', [App\Http\Controllers\PhonebookController::class, 'store'])->name('add_number');
Route::post('/edit_number/{edit_id}/edit', [App\Http\Controllers\PhonebookController::class, 'edit'])->name('edit_number');
Route::post('/user_edit/{edit_id}/edit', [App\Http\Controllers\UsermanegmentController::class, 'edit']);
Route::post('/edit_price/{edit_id}/edit', [App\Http\Controllers\PricingController::class, 'edit']);
Route::post('/edit_report/{edit_id}/edit', [App\Http\Controllers\ReportController::class, 'edit']);
Route::post('/edit_api/{edit_id}/edit', [App\Http\Controllers\ApiController::class, 'edit']);





Route::get('/del_price/{user_id}/del', [App\Http\Controllers\PricingController::class, 'destroy']);
Route::get('/del_report/{user_id}/del', [App\Http\Controllers\ReportController::class, 'destroy']);
Route::get('/pdf/{user_id}/id', [App\Http\Controllers\ReportController::class, 'report'])->name('pdf');
Route::get('/auto_report', [App\Http\Controllers\ReportController::class, 'auto_report'])->name('auto_report');
Route::get('/sendnow/{user_id}/send', [App\Http\Controllers\ReportController::class, 'sendnow']);











