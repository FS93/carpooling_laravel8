@extends('layouts.app')

@section('content')
    <div class="container position-relative">
        <div class="justify-content-center text-center">
            <!-- Page heading-->
            <h1 style="color: #0d6efd">Let's share a ride!</h1>
        </div>

        <div class="row justify-content-center">
            <div class="col-xl-7">
                <div class="mb-xl-5 text-center text-white">

                    <form class="form-text" id="offerData" action="{{route('searchresult')}}" method="POST">
                        <!-- Ride Parameters -->
                        <div class="row">
                            <div class="col-xl">
                                <input class="form-control form-control-lg mb-4" type="text" name="departure" id="departure" placeholder="Departure" data-sb-validations="required" />
                                <div class="invalid-feedback text-white" data-sb-feedback="departure:required">Please let us know where you want to start.</div>
                                <input class="form-control form-control-lg mb-4" type="text" name="destination" id="destination" placeholder="Destination" data-sb-validations="required" />
                                <div class="invalid-feedback text-white" data-sb-feedback="destination:required">Please let us know where you want to go.</div>
                                <input class="form-control form-control-lg mb-4" type="date" name="startDate" id="startDate"  />
                                <div class="invalid-feedback text-white" data-sb-feedback="startDate:required">Please let us know when you want to start.</div>
                                <input class="form-control form-control-lg mb-4" type="number" name="numberSeats" id="numberSeats" placeholder="Number of Seats" data-sb-validations="required" />
                                <div class="invalid-feedback text-white" data-sb-feedback="numberSeats:required">How many seats do you want to offer?</div>
                                <input class="form-control form-control-lg mb-4" type="number" min="0.00" step="0.01" name="price" id="price" placeholder="Price per seat" data-sb-validations="required" />
                                <div class="invalid-feedback text-white" data-sb-feedback="numberSeats:required">How much shall the ride cost per passenger?</div>
                            </div>
                        </div>

                        <div class="row align-content-center">
                            <div class="col-xl">
                                <button class="btn btn-primary btn-lg mb-4" id="searchButton" type="submit"><i class="bi bi-search me-2"></i>Offer</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
