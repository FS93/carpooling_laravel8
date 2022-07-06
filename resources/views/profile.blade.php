@extends('layouts.app')

 @section('content')
     <div class="container position-relative">
         <div class="d-flex justify-content-center align-items-center">
             <h1 class="text-center">Profile Settings</h1>
         </div>

         <div class="row justify-content-center">
             <div class="col-md-3 border-right">
                 <div class="d-flex flex-column align-items-center text-center ">
                     <img class="rounded-circle mt-5" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg"></div>
             </div>
             <div class="col-md-9 border-right">

                <form class="form-text" id="profileData" action="{{route('profile')}}" method="GET">
                     <div class="row mt-2">
                         <div class="col-md-6">
                             <label class="labels">First Name</label>
                             <input type="text" class="form-control" name="firstName" value="{{\Illuminate\Support\Facades\Auth::user()->firstName}}">
                         </div>
                         <div class="col-md-6">
                             <label class="labels">Surname</label>
                             <input type="text" class="form-control" name="name" value="{{\Illuminate\Support\Facades\Auth::user()->name}}">
                         </div>
                     </div>

                     <div class="row mt-3">

                         <div class="col-md-6">
                             <label class="labels">Mobile Number</label>
                             <input type="tel" class="form-control" name="phone" value="{{\Illuminate\Support\Facades\Auth::user()->phone}}">
                         </div>
                     </div>

                     <div class="col-md-12 mt-3 text-center">
                         <button class="btn btn-primary" type="submit">Save Profile</button>
                     </div>
                </form>

             </div>

         </div>
     </div>
 @endsection
