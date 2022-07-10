@extends('layouts.app')

@section('content')

    <script>
        // set the minimum search data to today - past rides cannot be offered
        window.onload = function () {
            let date = new Date().toISOString().substring(0,16)
            document.getElementById("departureTime").min = date;
        }
    </script>

    <div class="container position-relative">
        <div class="justify-content-center text-center">
            <!-- Page heading-->
            <h1 style="color: #0d6efd">Let's share a ride!</h1>
        </div>

        <div class="row justify-content-center">
            <div class="col-xl-7">
                <div class="mb-xl-5 text-center text-white">

                    <form class="form-text needs-validation" novalidate id="offerData" action="{{route('home.store')}}" method="POST">
                        @csrf
                        <!-- Ride Parameters -->
                        <div class="row">
                            <div class="col-xl">
                                <input class="form-control mb-4" type="text" name="departure" id="departure" placeholder="Departure" required/>
                                <input class="form-control mb-4" type="text" name="destination" id="destination" placeholder="Destination" required/>
                                <input class="form-control mb-4" type="datetime-local" name="departureTime" id="departureTime" required/>
                                <input class="form-control mb-4" type="number" min="1" name="availableSeats" id="numberSeats" placeholder="Number of Seats" required/>
                                <input class="form-control mb-4" type="number" min="0.00" step="0.01" name="price" id="price" placeholder="Price per seat" required/>
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

    <script>
        // JavaScript for disabling form submissions if there are invalid fields
        (function () {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>

@endsection
