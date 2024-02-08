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


    public function getScreenshots($id)
    {
        $response = Http::get($this->baseUrl . 'games/' . $id . '/screenshots', ['key' => $this->apiKey]);
        return $response->json();

    }

    public function getTags()
    {
        $response = Http::get($this->baseUrl . 'tags' , ['key' => $this->apiKey]);
        return $response->json();
    }

    public function getGenres($parameters = [])
    {
        $parameters = array_merge(['key' => $this->apiKey], $parameters);
        $response = Http::get($this->baseUrl . 'genres' , $parameters);
        return $response->json();
    }

    public function getPlatforms()
    {
        $response = Http::get($this->baseUrl . 'platforms' , ['key' => $this->apiKey]);
        return $response->json();
    }

    public function getTrailers($id)
    {
        $response = Http::get($this->baseUrl . 'games/' . $id . '/movies' , ['key' => $this->apiKey]);
        return $response->json();
    }
    public function getDLCs($id)
    {
        $response = Http::get($this->baseUrl . 'games/' . $id . '/additions' , ['key' => $this->apiKey]);
        return $response->json();
    }
    public function getSameSeries($id)
    {
        $response = Http::get($this->baseUrl . 'games/' . $id . '/game-series' , ['key' => $this->apiKey]);
        return $response->json();
    }
    public function getDevelopers($parameters = [])
    {
        $parameters = array_merge(['key' => $this->apiKey], $parameters);
        $response = Http::get($this->baseUrl . 'developers', $parameters);

        return $response->json();
    }
    public function getPublishers($parameters = [])
    {
        $parameters = array_merge(['key' => $this->apiKey], $parameters);
        $response = Http::get($this->baseUrl . 'publishers' , $parameters);
        return $response->json();
    }
}
