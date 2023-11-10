<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <title>EShop | Games</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <script src="https://kit.fontawesome.com/9ee462782c.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon-32x32.png') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsiveNavbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <script src="{{ asset('js/navbarScript.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/listStyle.css') }}">

</head>
<body>
<!--NAVBAR-->
<div class="navbar" >
    <div class="navbar_center">
        <img src="{{ asset('images/bruh.png') }}" width="45">
        <div class="navabar_main">
            <a href="/" class="nav_button">Home</a>
            <a href="list" class="nav_button active">Games</a>
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

<!--PAGE CONTENT-->
<div class="container">
    <input type="text" placeholder="Search..">
</div>

<div class="container page_content">
    <div class="row row-cols-2 row-cols-md-3 g-4">
        <div class="col">
            <div class="card">
                <img src="{{ asset('images/Background18.jpg') }}">
                <div class="card-body ">
                    <h5 class="card-title">Game 1</h5>

                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <img src="{{ asset('images/Background14.jpg') }}">
                <div class="card-body h-20">
                    <h5 class="card-title">Game 2</h5>

                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100">
                <img src="{{ asset('images/planet.jpg') }}">
                <div class="card-body">
                    <h5 class="card-title">Game 3</h5>

                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100">
                <img src="{{ asset('images/Background13.png') }}">
                <div class="card-body">
                    <h5 class="card-title">Game 4</h5>
                </div>
            </div>
        </div>
    </div>
</div>



</body>
</html>
