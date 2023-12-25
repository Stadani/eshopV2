<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RawgService
{
    protected $baseUrl = 'https://api.rawg.io/api/';
//    protected $gameUrl = 'https://api.rawg.io/api/games/';
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('RAWG_KEY');
    }

    public function getGames($params = [])
    {
        $defaultParams = ['key' => $this->apiKey];
        $response = Http::get($this->baseUrl . 'games', array_merge($defaultParams, $params));

        return $response->json();
    }

    public function getGameDetails($id)
    {

        $response = Http::get($this->baseUrl . 'games/' . $id, ['key' => $this->apiKey]);
        return $response->json();
    }




}
