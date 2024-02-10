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
            @foreach($purchaseHistory as $index => $purchase)
                <tr>
                    <td>
                        <div class="row productDetails">
                            <div class="col-auto">
                                @if ($purchase->dlc_id == null)
                                    <img src="{{ $itemDetails[$index]->game_picture }}" alt="product_img">
                                @else
                                    <img src="{{ \App\Models\Game::find($itemDetails[$index]->game_id)->game_picture }}"
                                         alt="dlc_img">
                                @endif
                            </div>
                            <div class="col">
                                @if ($purchase->dlc_id == null)
                                    <a href="/game/{{ $itemDetails[$index]->id }}"
                                       style="text-decoration: none; color: #EEEEEE">
                                        <h4>{{ $itemDetails[$index]->name }}</h4>
                                    </a>
                                @else
                                    <a href="/game/{{ $itemDetails[$index]->game_id }}"
                                       style="text-decoration: none; color: #EEEEEE">
                                        <h4>{{ $itemDetails[$index]->name }}</h4>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>{{ $purchase->platform }}</td>
                    <td>{{ $purchase->key }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div>{{ $purchaseHistory->links() }}</div>
    </div>
</x-app-layout>







