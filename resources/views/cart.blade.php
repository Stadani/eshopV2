<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>PixelNexus | Cart</title>


    @extends('components/layout')
    @section('listcss')
        <link rel="stylesheet" href="/css/cartStyle.css">
    @endsection
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

@extends('components.navbar')

@section('content')



    <div class="containerGeneral" >
        <div class="table-responsive">
            <table id="cart" >
            <thead>
            <tr>
                <th scope="col" style="width: 50%;">Product</th>
                <th scope="col" style="width: 20%;">Platform</th>
                <th scope="col" style="width: 10%">Price</th>
                <th scope="col" style="width: 10%">Quantity</th>
                <th scope="col" style="width: 10%">Subtotal</th>
            </tr>
            </thead>
            <tbody>

            @php $total = 0 @endphp
            @if(session('cart'))
                @foreach(session('cart') as $id => $details)
{{--                    {{dd($details)}}--}}
                    @php $total += $details['price'] * $details['quantity'] @endphp
                        <tr data-id="{{$id}}">
                            <td>
                                <div class="row productDetails">
                                    <div class="col-auto">
                                        <img src="{{$details['thumbnail']}}" alt="product_img">
                                    </div>
                                    <div class="col">
                                        <h4>{{$details['product_name']}}</h4>
                                    </div>

                                </div>
                            </td>
                            <td>{{ $details['platform']}}</td>
                            <td>{{$details['price']}}$</td>
                            <td >
                                <input type="number" value="{{$details['quantity']}}" class="form-control cartUpdate quantity" min="1">
                            </td>
                            <td>{{$details['price'] * $details['quantity'] }}$ </td>
                            <td>
                                <button class="btn btn-danger cartRemove"><i class="fa-solid fa-trash-can"></i></button>
                            </td>
                        </tr>
                @endforeach
            @endif
            </tbody>
            <tfoot>
            <tr>
                <td colspan="6"><h3>Total {{$total}}$</h3></td>
            </tr>
            <tr>
                <td colspan="6">
                    <div class="text-right">
                        <a href="/list" class="btn btn-danger">Continue shopping</a>
                        <button type="submit" class="btn btn-success">Checkout</button>
                    </div>
                </td>
            </tr>
            </tfoot>
        </table>
        </div>
    </div>
@endsection
<script>
    var removeFromCartRoute = '{{ route('removeFromCart') }}';
    var CSRF_TOKEN = '{{ csrf_token() }}';
    var updateCartRoute = '{{ route('updateCart') }}';

</script>

<script src="{{ asset('js/cartRemove.js') }}"></script>
<script src="{{ asset('js/cartUpdate.js') }}"></script>





