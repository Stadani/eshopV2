@extends('components/layout')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PixelNexus | Main Page</title>
</head>

<body>
<!--HEADER & NAVBAR-->
    <header>
        <div class="head">
            <div class="header_content">
                <img src="/images/bruh.png" alt="logo">
                PixelNexus
            </div>
        </div>

        <div class="navbar" >
            <div class="navbar_center">
                <div class="navbar_main">
                    <a href="/" class="nav_button">Home</a>
                    <a href="list" class="nav_button">Games</a>
                    <a href="forum" class="nav_button">Discussion</a>
                </div>

                <div class="sidenav links">
                    @guest
                        <a href="/login" class="nav_button"><i class="fa-solid fa-key"></i> Log In</a>
                        <a href="/register" class="nav_button"><i class="fa-solid fa-pencil"></i> Sign In</a>
                    @endguest
                    @auth()
                         <a class="nav_button" href="/profile"><img class="profilePicture" src="{{ Auth::user()->profile_picture_url }}" alt="Profile Picture">
                                 Profile
                             </a>
                            <a class="nav_button" href="/cart">
                                <i class="fa-solid fa-cart-shopping"></i> Cart <span class="badge bg-danger">0</span>
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
    </header>

<!--CAROUSEL-->
<x-carousel :games="$games">


</x-carousel>

<!--MAIN-->
    <div class="main_content">
        Welcome to GameShop – Your Ultimate Gaming Hub!
        Discover the latest video game releases, connect with fellow gamers in our vibrant forum, and embark on a journey into the world of gaming excellence.
        Start exploring now!
    </div>

<!--FOOTER-->
    <footer>
       <div class="footer_content_block">
           <p><i class="fa-regular fa-clipboard"></i> About Us</p>
           Gameshop is shop and forum at the same time.
           Users can buy, rate, comment and discuss videogames.
       </div>
       <div class="footer_content_block">
           <p><i class="fa-regular fa-envelope"></i> Contact</p>
            E-mail: stadani2@stud.uniza.sk
       </div>
{{--       <div class="footer_content_block">--}}
{{--           <p><i class="fa-solid fa-chart-line"></i> Statistics</p>--}}
{{--       </div>--}}
    </footer>

</body>
</html>
