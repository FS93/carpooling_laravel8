<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\RidesController;
use App\Services\AvailableRides;
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

Route::get('/', function () {return view('search');})->name('search');

Route::get('/searchresult', [RidesController::class, 'queryRides'])->name('searchresult');

Route::resource('/home', RidesController::class);

Route::get('/profile', function () {return view('profile');})->name('profile');

Route::get('/offer', function () {return view('offer');})->name('offer');

