<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RidesController extends Controller
{
    public function showMyRides() {
        return view('home');
    }
}
