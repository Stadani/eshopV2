<div class="dropdown_navbar">
    <ul>
        <li><a href="/" class="nav_button">Home</a></li>
        <li><a href="/list" class="nav_button">Games</a></li>
        <li><a href="/forum" class="nav_button">Discussion</a></li>
        @guest
            <li><a href="/login" class="nav_button"><i class="fa-solid fa-key"></i> Log In</a></li>
            <li> <a href="/register" class="nav_button"><i class="fa-solid fa-pencil"></i> Sign In</a></li>
        @endguest
        @auth()
            <li><a href="{{ route('logout') }}" class="nav_button" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Log Out
            </a></li>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        @endauth
    </ul>
</div>
