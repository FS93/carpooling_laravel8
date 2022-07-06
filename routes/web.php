<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Collection;
use App\Service\AvailableRides;

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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', function (AvailableRides $rides) {
    $firstRide = $rides->getAll()->first();
    return view('availableRides', ['name' => $firstRide]);
});

Route::get('/search', function () {
   return view('welcome');
});

