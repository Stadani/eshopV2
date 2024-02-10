@extends('components/layout')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PixelNexus | Main Page</title>

    @extends('components/layout')
    @section('listcss')
        <link rel="stylesheet" href="/css/forumStyle.css">
    @endsection
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>
@if(session('success'))
    <div id="successMessage" class="alert alert-success messageBL">
        {{ session('success') }}
    </div>
@endif

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
                             {{ Auth::user()->name }}
                             </a>
                            <a class="nav_button" href="/cart">
                                <i class="fa-solid fa-cart-shopping"></i> Cart <span class="badge bg-danger">{{ count(session('cart', [])) }}</span>
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
    <div class="containerGeneral paragraphs">
        <p> Welcome to PixelNexus – Your Ultimate Gaming Hub!
            At PixelNexus, we're passionate about all things gaming, and we've created a vibrant community where gamers like you can come together to explore, connect, and experience the excitement of gaming like never before.
        </p>
        <p>Discover the latest video game releases: Stay up-to-date with the hottest new releases across all gaming platforms. From AAA titles to indie gems.</p>
        <p>Connect with fellow gamers in our vibrant forum: Join the conversation with a community of like-minded gamers who share your passion. Discuss your favorite games, share tips, strategies and opinions with players from around the world.</p>
    </div>

{{--NEWSLETTER--}}
<div class="containerGeneral paragraphs">
    <p>Are you a gaming enthusiast always on the lookout for the latest updates, releases, and insights about your favorite games? Look no further! Our newsletter is tailored just for you.</p>
    <p>By subscribing to our newsletter, you'll get exclusive access to:</p>
    <p>📰 Breaking News: Be the first to know about game releases, updates, and industry news.</p>
    <p>🎉 Special Offers: Get notified about exclusive deals, discounts, and promotions on popular games and gaming accessories.</p>
    <p>📅 Event Reminders: Never miss out on important gaming events, tournaments, and conventions happening in your area or online.></p>
    <p>🎁 Giveaways and Contests: Stand a chance to win exciting prizes, game keys, merchandise, and more through our regular giveaways and contests.</p>

    <form action="/newsletter" method="POST">
        @csrf
        <div>
            <input type="text" name="email" placeholder="Your email address...">
            @error('email')
                <div id="errorMessage" class="alert alert-danger messageBL"> {{$message}}</div>
            @enderror
        </div>
        <button type="submit" class="button_bar mt-1">SUBSCRIBE</button>


    </form>
</div>
<!--FOOTER-->
    <footer>
       <div class="footer_content_block">
           <p><i class="fa-regular fa-clipboard"></i> About Us</p>
           PixelNexus is shop and forum at the same time.
           Users can buy, rate, comment and discuss video games.
       </div>
       <div class="footer_content_block">
           <p><i class="fa-regular fa-envelope"></i> Contact</p>
            E-mail: stadani2@stud.uniza.sk
       </div>

    </footer>

</body>
</html>
