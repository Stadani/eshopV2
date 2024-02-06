<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>PixelNexus | Inventory</title>


    @extends('components/layout')
    @section('listcss')
        <link rel="stylesheet" href="/css/cartStyle.css">
    @endsection
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<x-app-layout>
    <div class="containerGeneral table-responsive">
        <table id="cart">
            <thead>
            <tr>
                <th scope="col" style="width: 50%;">Product</th>
                <th scope="col" style="width: 20%;">Platform</th>
                <th scope="col" style="width: 30%">key</th>
            </tr>
            </thead>
            <tbody>
            @foreach($purchaseHistory as $purchase)
                <tr>
                    <td>
                        <div class="row productDetails">
                            <div class="col-auto">
                                <img src="{{ $gameDetails[$purchase->idGame]['background_image']}}" alt="product_img">
                            </div>
                            <div class="col">
                                <a href="/game/{{$purchase->idGame}}" style="text-decoration: none; color: #EEEEEE">
                                    <h4>{{ $gameDetails[$purchase->idGame]['name'] }}</h4></a>
                            </div>
                        </div>
                    </td>
                    <td>{{ $purchase->platform }}</td>
                    <td >{{ $purchase->key }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div>{{ $purchaseHistory->links() }}</div>
    </div>
</x-app-layout>







