<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <title>EShop | Games</title>

    <link rel="stylesheet" href="{{ asset('css/listStyle.css') }}">

    @extends('components/layout')

    @section('listcss')
        <link rel="stylesheet" href="{{ asset('css/listStyle.css') }}">
    @endsection

</head>
<body>
@extends('components/otherLayout')

@section('content')
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
@endsection


</body>
</html>
