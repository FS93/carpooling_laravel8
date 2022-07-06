@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center display-2">
        Destination: {{ $departure }} <br>
        Departure: {{ $destination }} <br>
        Start Date: {{ $startDate }}
    </div>


@endsection
