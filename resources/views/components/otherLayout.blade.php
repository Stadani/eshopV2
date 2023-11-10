<!--NAVBAR-->
<div class="navbar" >
    <div class="navbar_center">
        <img src="{{ asset('images/bruh.png') }}" width="45">
        <div class="navabar_main">
            <a href="/" class="nav_button">Home</a>
            <a href="list" class="nav_button">Games</a>
            <a href="forum" class="nav_button">Discussion</a>
        </div>

        <div class="sidenav links">
            <a class="nav_button"><i class="fa-solid fa-key"></i> Log In</a>
            <a class="nav_button"><i class="fa-solid fa-pencil"></i> Sign In</a>
        </div>

        <div class="navbar_tgl_button">
            <i class="fa fa-bars"></i>
        </div>
    </div>
</div>

<div class="dropdown_navbar">
    <ul>
        <li><a href="index.blade.php" class="nav_button">Home</a></li>
        <li><a href="list.html" class="nav_button">Games</a></li>
        <li><a href="forum.blade.php" class="nav_button">Discussion</a></li>
        <li><a class="nav_button">Log In</a></li>
        <li><a class="nav_button">Sign In</a></li>
    </ul>
</div>

@yield('content')
