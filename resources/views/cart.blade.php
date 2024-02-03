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
    @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="containerGeneral" >

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
@endsection
<script>
    $(document).ready(function() {
        $(".cartRemove").click(function (e) {
            e.preventDefault();

            var element = $(this);
            var productId = element.parents("tr").attr("data-id");

            $.ajax({
                url: '{{ route('removeFromCart') }}',
                method: "DELETE",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: productId
                },
                success: function (response) {
                    window.location.reload();
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function() {
        $(".cartUpdate").change(function (e) {
            e.preventDefault();

            var element = $(this);
            var productId = element.parents("tr").attr("data-id");
            var productQuantity = element.parents("tr").find(".quantity").val();

            $.ajax({
                url: '{{ route('updateCart') }}',
                method: "patch",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: productId,
                    quantity: productQuantity,
                },
                success: function (response) {
                    window.location.reload();
                }
            });
        });
    });
</script>

