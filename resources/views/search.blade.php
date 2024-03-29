@extends('layouts.app')

@section('content')

    <script>
        // set the minimum search data to today - past rides shall not be searchable
        window.onload = function () {
            date = new Date().toISOString().substring(0, 10);
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

                    <form class="form-text" id="searchData" action="{{route('searchresult')}}" method="GET">
                        <!-- Ride Parameters -->
                        <div class="row">
                            <div class="col-xl">
                                <input class="form-control mb-4" name="departure" id="departure" placeholder="Departure" autofocus/>
                                <input class="form-control mb-4" name="destination" id="destination" placeholder="Destination"/>
                                <input class="form-control mb-4" name="departureTime" id="departureTime" type="date" min="2022-07-10"/>
                            </div>
                        </div>
                        <div class="row align-content-center">
                            <div class="col-xl">
                                <button class="btn btn-primary btn-lg mb-4" id="searchButton" type="submit"><i class="bi bi-search me-2"></i>Search</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
