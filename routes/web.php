<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RidesController;
use App\Http\Controllers\UserController;

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

Route::post('/joinRide', [RidesController::class, 'joinRide'])->name('joinRide');

Route::post('/unjoinRide', [RidesController::class, 'unjoinRide'])->name('unjoinRide');

Route::resource('/home', RidesController::class);

Route::get('/profile', [UserController::class, 'showProfile'])->name('showProfile');

Route::post('/profile', [UserController::class, 'updateProfile'])->name('updateProfile');
