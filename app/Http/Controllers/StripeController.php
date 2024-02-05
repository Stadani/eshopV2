<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;

class StripeController extends Controller
{
    public function session(Request $request)
    {
        $user = auth()->user();
        $product = [];

        Stripe::setApiKey(config('stripe.sk'));

        foreach (session('cart') as $id => $details) {
            $productName = $details['product_name'];
            $total = $details['price'];
            $quantity = $details['quantity'];



            $product[] = [
                'price_data' => [
                    'product_data' => [
                        'name' => $productName,
                    ],
                    'currency' => 'USD',
                    'unit_amount' => $total,
                ],
                'quantity' =>$quantity
            ];
        }

        $checkout = \Stripe\Checkout\Session::create([
            'line_items' => [$product],
            'mode' => 'payment',
            'allow_promotion_codes' => true,
            'metadata' => ['user_id' => "0001"],
            'customer_email' => $user->email,
            'success_url' => route('success'),
            'cancel_url' => route('cancel'),
        ]);

        return redirect()->away($checkout->url);
    }

    public function success()
    {
        return "Thank you for you purchase. \n You will find your key(s) in your e-mail inbox.";
    }
    public function cancel()
    {
        return "cancel";
    }
}
