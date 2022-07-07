@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center display-2">
        Destination: {{ $departure }}, Departure: {{ $destination }}, Start Date: {{ $startDate }}
    </div>

    <div class="container">
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">Departure</th>
                <th scope="col">Destination</th>
                <th scope="col">Departure Time</th>
                <th scope="col">Price</th>
                <th scope="col">Available Seats</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Halle</td>
                <td>Leipzig</td>
                <td>07.07.2022 12:00</td>
                <td>10 €</td>
                <td>2</td>
            </tr>
            </tbody>
        </table>
    </div>


@endsection
