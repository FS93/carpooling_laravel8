<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RidesController extends Controller
{
    public function showMyRides() {
        return view('home');
    }
}
