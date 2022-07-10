<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand ms-5" href="@auth {{ route('home.index') }} @else {{ route('search') }} @endauth ">Carpooling - Share your rides!</a>
        <button class="navbar-toggler me-5" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto me-5 mb-2 mb-lg-0 align-items-end">

                {{-- Check if named Routes for login & register exist--}}
                @if (Route::has('login') and Route::has('register'))

                        {{-- Logged in user --}}
                        @auth
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{route('home.index')}}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('search')}}">Search</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('home.create')}}">Offer</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('profile')}}">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>

                        {{-- Guest --}}
                        @else
                            <li class="nav-item">
                                <a href="{{ route('login') }}" class="nav-link">Login</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('register') }}" class="nav-link">Register</a>
                            </li>
                        @endauth
                @endif





            </ul>
        </div>
    </div>
</nav>
