<?php

namespace App\Http\Controllers;

use App\Mail\ReceiptMail;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Stripe\Stripe;
use Illuminate\Support\Facades\Session;
use App\Models\InventoryGame;

class StripeController extends Controller
{
    public function session(Request $request)
    {
        if (session('cart') === null) {
            return redirect()->back()->with('error', 'Your cart is empty.');
        }

        $user = auth()->user();
        $product = [];


        Stripe::setApiKey(config('stripe.sk'));

        foreach (session('cart') as $id => $details) {
            $productName = $details['product_name'];
            $total = $details['price'];
            $quantity = $details['quantity'];

            $unit_amount = intval($total * 100);

            $product[] = [
                'price_data' => [
                    'product_data' => [
                        'name' => $productName,
                    ],
                    'currency' => 'USD',
                    'unit_amount' => $unit_amount,
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

        $user = auth()->user();
        $cart = session('cart');

        foreach ($cart as $details) {
            $gameId = $details['id'];
            $platform = $details['platform'];
            $quantity = $details['quantity'];
            $isDlc = $details['is_dlc'];

            $game = Game::findOrFail($gameId);

            for ($i = 0; $i < $quantity; $i++) {
                $key = $this->generateRandomKey();

                if ($isDlc == 'false') {
                    InventoryGame::create([
                        'user_id' => $user->id,
                        'game_id' => $game->id,
                        'platform' => $platform,
                        'key' => $key,
                    ]);
                } else {
                    InventoryGame::create([
                        'user_id' => $user->id,
                        'dlc_id' => $game->id,
                        'platform' => $platform,
                        'key' => $key,
                    ]);
                }
            }
        }

        Mail::to($user->email)->send(new ReceiptMail($user, $cart));

        Session::forget('cart');
        return redirect('inventory');
    }

    private function generateRandomKey()
    {
        $key = '';
        for ($i = 0; $i < 4; $i++) {
            $key .= uniqid() . '-';
        }

        return rtrim($key, '-');
    }

    public function cancel()
    {
        Session::flash('error', 'Payment was canceled.');
        return redirect('cart');
    }

}
