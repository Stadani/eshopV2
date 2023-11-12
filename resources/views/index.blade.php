<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EShop | Main Page</title>


    @extends('components/layout')

</head>

<body>
<!--HEADER & NAVBAR-->
    <header>
        <div class="head">
            <div class="header_content">
                <img src="{{ asset('images/bruh.png') }}" alt="logo">
                GAMESHOP
            </div>
        </div>

        <div class="navbar" >
            <div class="navbar_center">
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
                <li><a href="index.html" class="nav_button">Home</a></li>
                <li><a href="list.blade.php" class="nav_button">Games</a></li>
                <li><a href="forum.blade.php" class="nav_button">Discussion</a></li>
                <li><a class="nav_button">Log In</a></li>
                <li><a class="nav_button">Sign In</a></li>
            </ul>
        </div>
    </header>

<!--CAROUSEL-->
    <div id="myCarousel" class="carousel slide mb-6" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-label="Slide 1" aria-current="true"></button>
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2" class=""></button>
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3" class=""></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{asset('images/planet.jpg')}}" alt="a"><rect width="1200" height="400" fill="var(--bs-secondary-color)"></rect>
                <div class="container">
                    <div class="carousel-caption text-start">
                        <h1>Space Explora</h1>
                        <p><a class="btn btn-lg btn-primary" href="list">Browse games</a></p>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{asset('images/Background14.jpg')}}"><rect width="100%" height="100%" fill="var(--bs-secondary-color)"></rect>
                <div class="container">
                    <div class="carousel-caption">
                        <h1>Vagrant Samurai</h1>
                        <p><a class="btn btn-lg btn-primary" href="list">Browse games</a></p>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{asset('images/Background18.jpg')}}"><rect width="100%" height="100%" fill="var(--bs-secondary-color)"></rect></svg>
                <div class="container">
                    <div class="carousel-caption text-end">
                        <h1>Shrine Linker</h1>
                        <p><a class="btn btn-lg btn-primary" href="list">Browse games</a></p>
                    </div>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

<!--MAIN-->
    <div class="main_content">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur facilisis molestie elit, a luctus mi. Nunc tempor ornare fringilla. Sed sit amet tellus sed sapien pretium varius. Integer non tempor massa. Suspendisse egestas auctor turpis. Curabitur pulvinar consequat fringilla. Maecenas faucibus tincidunt erat, non condimentum turpis mattis sit amet. Curabitur nibh mauris, tincidunt ut volutpat quis, tristique nec nulla. Pellentesque vulputate ultrices facilisis. Quisque pretium leo sed purus ultricies, vitae pretium lacus finibus. Sed elementum mi nibh, ac dictum arcu sagittis a. Donec iaculis maximus eros. Suspendisse potenti. In vulputate libero sit amet tortor egestas, eu maximus lectus dapibus.
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
       <div class="footer_content_block">
           <p><i class="fa-solid fa-chart-line"></i> Statistics</p>
       </div>
    </footer>

</body>
</html>
