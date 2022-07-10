<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function showProfile() {

        $user = Auth::user();
        return view('profile')->with([
            'firstName' => $user->firstName,
            'name' => $user->name,
            'phone' => $user->phone
            ]);
    }



    public function updateProfile(Request $request) {

        $user = Auth::user();
        $user->firstName = $request->firstName;
        $user->name = $request->name;
        $user->phone = $request->phone;

        $user->save();
        return redirect()->route('showProfile')
            ->with('success','Profile has been updated successfully');
    }
}
