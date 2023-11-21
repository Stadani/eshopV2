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

@yield('content')
