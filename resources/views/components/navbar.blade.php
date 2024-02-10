<!--NAVBAR-->
<div class="navbar" >
    <div class="navbar_center">
        <img src="/images/bruh.png" width="45">
        <div class="navbar_main">
            <a href="/" class="nav_button">Home</a>
            <a href="/list" class="nav_button">Games</a>
            <a href="/forum" class="nav_button">Discussion</a>
        </div>

        <div class="sidenav links">
            @guest
            <a href="/login" class="nav_button"><i class="fa-solid fa-key"></i> Log In</a>
            <a href="/register" class="nav_button"><i class="fa-solid fa-pencil"></i> Sign In</a>
            @endguest
            @auth()
                    <a class="nav_button" href="/profile"><img class="profilePicture" src="{{ Auth::user()->profile_picture_url }}" alt="Profile Picture">
                        {{Auth::user()->name}}
                    </a>
                    <a class="nav_button" href="{{route('cart')}}">
                        <i class="fa-solid fa-cart-shopping"></i> Cart <span class="badge bg-danger cartCount">{{ count(session('cart', [])) }}</span>
                    </a>
                    <a href="{{ route('logout') }}" class="nav_button" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i> Log Out
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endauth
        </div>


        <div class="navbar_tgl_button">
            <i class="fa fa-bars"></i>
        </div>
    </div>
</div>

<x-dropdownNavbar>

</x-dropdownNavbar>

@if(session()->has('success'))
    <div id="successMessage" class="alert alert-success messageBL">
        {{ session('success') }}
    </div>
@endif
@if(session()->has('error'))
    <div id="errorMessage" class="alert alert-danger messageBL">
        {{ session('error') }}
    </div>
@endif




@yield('content')
