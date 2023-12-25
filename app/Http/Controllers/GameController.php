<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RawgService;


class GameController extends Controller
{


    protected $rawgApiService;

    public function __construct(RawgService $rawgApiService)
    {
        $this->rawgApiService = $rawgApiService;
    }



    public function index(Request $request)
    {

        $pageSize = $request->input('page_size', 10);
        $games = $this->rawgApiService->getGames(['page_size' => $pageSize]);

        if ($request->ajax()) {
            return view('components.gameCard', ['games' => $games]);
        }
        return view('/list', ['games' => $games, 'page_size' => $pageSize]);
    }

    public function show($id)
    {

        $gameDetails = $this->rawgApiService->getGameDetails($id);

        $fullDescription = $gameDetails['description'] ?? '';
        $descriptions = explode('<p>Español<br />', $fullDescription);
        $englishDescription = $descriptions[0] ?? '';

        return view('/game', ['gameDetails' => $gameDetails,
                                    'englishDescription' => $englishDescription]);
    }

}
