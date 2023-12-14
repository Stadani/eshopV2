<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <title>EShop | Games</title>

    <link rel="stylesheet" href="/css/listStyle.css">

    @extends('components/layout')

    @section('listcss')
        <link rel="stylesheet" href="/css/forumStyle.css">
        <link rel="stylesheet" href="/css/listStyle.css">
    @endsection

</head>
<body>
@extends('components.navbar')

@section('content')
    <!--PAGE CONTENT-->
    <div class="container">
        <div class="navbar_main">
            <input type="text" placeholder="Search..">
        </div>

        <div class="sidenav">
            <button class="button_bar"><i class="fa-solid fa-filter"></i></button>
        </div>

    </div>

    <div class="container page_content">
        <div class="gamePanel">
            <div class="row row-cols-2 row-cols-md-3 g-4">
                <div class="col">
                    <div class="card">
                        <img src="/images/Background18.jpg">
                        <div class="card-body ">
                            <h5 class="card-title">Game 1</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="filters">
            asd
        </div>
    </div>
@endsection


</body>
</html>
