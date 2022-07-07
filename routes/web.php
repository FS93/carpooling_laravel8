<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\RidesController;
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

Route::get('/', function () {
    return view('search');
})->name('search');

Route::get('/searchresult', function (Request $request) {
    return view('searchResults',
        ['departure' => $request->input('departure'),
        'destination'=> $request->input('destination'),
        'startDate' => $request->input('startDate')
        ]);
})->name('searchresult');

Route::get('/home', [RidesController::class, 'showMyRides'])->name('home');

Route::get('/profile', function () {
    return view('profile');
})->name('profile');

Route::get('/offer', function () {
   return view('offer');
})->name('offer');


