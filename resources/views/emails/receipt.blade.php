<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
</head>
<body>
<p>Dear {{ $user->name }},</p>
<p>Thank you for buying following products:</p>
<table>
    <tr>
        <th scope="col" style="width: 70%;">Product</th>
        <th scope="col" style="width: 10%;">Platform</th>
        <th scope="col" style="width: 10%">Price</th>
        <th scope="col" style="width: 10%">Quantity</th>
    </tr>
    @foreach($cart as $details)
        @php

 @endphp
        <tr>
            <td>
                {{ $details['product_name'] }}
            </td>
            <td>
                {{ $details['platform'] }}
            </td>
            <td>
                {{ $details['price'] * $details['quantity'] }}
            </td>
            <td>
                {{ $details['quantity'] }}
            </td>
        </tr>
    @endforeach
</table>
<p>You can find key(s) in your inventory.</p>
<p>If you have any questions or concerns, please contact us at stadani2@stud.uniza.sk.</p>
<p>Thank you,</p>
<p>PixelNexus</p>
</body>
</html>

