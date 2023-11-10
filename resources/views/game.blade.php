 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Game</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <script src="https://kit.fontawesome.com/9ee462782c.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon-32x32.png') }}">
    <script src="{{ asset('js/navbarScript.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsiveNavbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/forumStyle.css') }}">
    <link rel="stylesheet" href="{{ asset('css/gameDiscussionStyle.css') }}">
    <link rel="stylesheet" href="{{ asset('css/gamePageStyle.css') }}">

</head>
<body>

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

<div class="containerGeneral">
    <div class="videoPanel">video panel</div>
    <div class="sidePanel">
        <div>
            image
        </div>
        <div>
            description?
        </div>
        <div>
            release date
            developer
            publisher
            release date
        </div>
        <div>
            tags
        </div>
    </div>
</div>

<div class="containerGeneral">
    content panel
</div>

</body>
</html>
