<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SteamService
{

    protected $baseUrl = 'http://api.steampowered.com/';

    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('RAWG_KEY');
    }

//    public function getSteamPrices($id)
//    {
//
//        $response = Http::get($this->baseUrl, ['key' => $this->apiKey]);
//
//        $data = $response->json();
//        $price = $data[$id]['data']['price_overview']['final'] / 100;
//        return response()->json(['price' => $price]);
//    }
    public function getSteamPrices(array $ids)
    {
        $prices = [];
        foreach ($ids as $id) {
            $url = "https://store.steampowered.com/api/appdetails?appids={$id}&cc=us&filters=price_overview";
            $response = Http::get($url);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data[$id]['data']['price_overview'])) {
                    $prices[$id] = $data[$id]['data']['price_overview']['final'] / 100;
                } else {
                    $prices[$id] = null; // Price not available
                }
            } else {
                $prices[$id] = null; // Error in response
                // Consider logging this error
            }
        }

        return $prices;
    }
}
