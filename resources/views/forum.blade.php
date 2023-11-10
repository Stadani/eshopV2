<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <title>EShop | Discussion</title>
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


</head>
<body>
<!--NAVBAR-->
<div class="navbar" >
    <div class="navbar_center">
        <img src="{{ asset('images/bruh.png') }}" width="45">
        <div class="navabar_main">
            <a href="/" class="nav_button">Home</a>
            <a href="list" class="nav_button">Games</a>
            <a href="forum" class="nav_button active">Discussion</a>
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
        <li><a href="list.blade.php" class="nav_button">Games</a></li>
        <li><a href="forum.blade.html" class="nav_button">Discussion</a></li>
        <li><a class="nav_button">Log In</a></li>
        <li><a class="nav_button">Sign In</a></li>
    </ul>
</div>

<!--PAGE CONTENT-->
<div class="container bar">
    <button type="button" class="button_bar">
        <i class="fa-solid fa-pencil"></i> Post Thread
    </button>
</div>

<div class="container arrow_bar">
    <div class="navabar_main">
        <button class="button_arrow">
            <
        </button>
            1
        <button class="button_arrow">
            >
        </button>
    </div>
    <div class="sidenav just">
        <input type="text" placeholder="Search..">
    </div>
</div>

<!--TABLE-->
<div class="container">
    <div class="table_item">
        <div class="table_cell table_cell_icon">
            <div class="table_cell_icon_cont">
                <img src="{{ asset('images/favicon-32x32.png') }}" alt="profile">
            </div>
        </div>
        <div class="table_cell table_cell_main">
            <div>
                <div class="table_cell_title">
                    <a href="">Name of topic</a>
                </div>
                <div class="table_cell_info">
                    <a href="">Username</a>
                </div>
            </div>
        </div>

        <div class="table_cell table_cell_middle table_cell_info">
            <div class="table_cell_stats">
                <div>
                    Views
                </div>
                <div>
                    Replies
                </div>
            </div>
            <div class="table_cell_stats table_cell_stats_right">
                <div>
                    123
                </div>
                <div>
                    1233
                </div>
            </div>
        </div>

        <div class="table_cell table_cell_side">
            <div>
                <div class="table_cell_info">
                    1 min ago
                </div>
                <div class="table_cell_info ">
                    <a href="">Username</a>
                </div>
            </div>
        </div>
        <div class="table_cell table_cell_icon">
            <div class="table_cell_icon_cont">
                <img src="{{ asset('images/albertwhisker.png') }}" alt="profile">
            </div>
        </div>
    </div>

    <div class="table_item">
        <div class="table_cell table_cell_icon">
            <div class="table_cell_icon_cont">
                <img src="{{ asset('images/albertwhisker.png') }}" alt="profile">
            </div>
        </div>
        <div class="table_cell table_cell_main">
            <div>
                <div class="table_cell_title">
                    <a href="#">Name of topic but longer</a>
                </div>
                <div class="table_cell_info">
                    <a href="">Username</a>
                </div>
            </div>
        </div>

        <div class="table_cell table_cell_middle table_cell_info">
            <div class="table_cell_stats">
                <div>
                    Views
                </div>
                <div>
                    Replies
                </div>
            </div>
            <div class="table_cell_stats table_cell_stats_right">
                <div>
                    123
                </div>
                <div>
                    1233
                </div>
            </div>
        </div>

        <div class="table_cell table_cell_side">
            <div>
                <div class="table_cell_info">
                    1 min ago
                </div>
                <div class="table_cell_info ">
                    <a href="">Username</a>
                </div>
            </div>
        </div>
        <div class="table_cell table_cell_icon">
            <div class="table_cell_icon_cont">
                <img src="{{ asset('images/albertwhisker.png') }}" alt="profile">
            </div>
        </div>
    </div>

    <div class="table_item">
        <div class="table_cell table_cell_icon">
            <div class="table_cell_icon_cont">
                <img src="{{ asset('images/albertwhisker.png') }}" alt="profile">
            </div>
        </div>
        <div class="table_cell table_cell_main">
            <div>
                <div class="table_cell_title">
                    <a href="#">
                        Name of topic
                    </a>
                </div>
                <div class="table_cell_info">
                    <a href="#">
                        Username
                    </a>
                </div>
            </div>
        </div>

        <div class="table_cell table_cell_middle table_cell_info">
            <div class="table_cell_stats">
                <div>
                    Views
                </div>
                <div>
                    Replies
                </div>
            </div>
            <div class="table_cell_stats table_cell_stats_right">
                <div>
                    123
                </div>
                <div>
                    1233
                </div>
            </div>
        </div>

        <div class="table_cell table_cell_side">
            <div>
                <div class="table_cell_info">
                    1 min ago
                </div>
                <div class="table_cell_info ">
                    <a href="#">
                        Username
                    </a>
                </div>
            </div>
        </div>
        <div class="table_cell table_cell_icon">
            <div class="table_cell_icon_cont">
                <img src="{{ asset('images/favicon-32x32.png') }}" alt="profile">
            </div>
        </div>
    </div>

</div>
