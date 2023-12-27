<?php

    namespace App\Http\Controllers;

    use App\Services\SteamService;
    use Illuminate\Http\Request;
    use App\Services\RawgService;
    use Illuminate\Pagination\LengthAwarePaginator;
    use function Laravel\Prompts\search;


    class GameController extends Controller
    {


        protected $rawgApiService;
        protected $steamApiService;

        public function __construct(RawgService $rawgApiService, SteamService $steamService)
        {
            $this->rawgApiService = $rawgApiService;
            $this->steamApiService = $steamService;
        }



        public function index(Request $request)
        {
            $gamePlatforms = $this->rawgApiService->getPlatforms();
            $gameTags = $this->rawgApiService->getTags();
            $gameGenres = $this->rawgApiService->getGenres();
            $pageSize = $request->input('page_size', 10);
            $currentPage = $request->input('page', 1);

            $selectedGenres = $request->input('genres', []);
            $genreString = implode(',', $selectedGenres);

            $search = $request->input('search', '');

            $selectedPlatforms = $request->input('platforms', []);
            $platformString = implode(',', $selectedPlatforms);


            $queryParameters = [
                    'page_size' => $pageSize,
                    'page' => $currentPage,
                    'search' => $search,
            ];

            if (!empty($genreString)) {
                $queryParameters['genres'] = $genreString;
            }
            if (!empty($platformString)) {
                $queryParameters['platforms'] = $platformString;
            }


            $response = $this->rawgApiService->getGames($queryParameters);

            $games = collect($response['results'] ?? []);
            $totalGames = $response['count'] ?? 0;


    //        $gameIds = $games->pluck('id')->all(); // Assuming these IDs are Steam IDs
    //        $steamPrices = $this->steamApiService->getSteamPrices($gameIds);
    //
    //        // Combine game data with prices
    //        $games->transform(function ($game) use ($steamPrices) {
    //            $game['price'] = $steamPrices[$game['id']] ?? null;
    //            return $game;
    //        });


            $paginatedGames = new LengthAwarePaginator(
                $games,
                $totalGames,
                $pageSize,
                $currentPage,
                ['path' => $request->url(), 'query' => $request->query()]
            );
    //        dd($paginatedGames);
    //        dd($gameGenres);
    //        dd($genreString);
    //        dd($response);
    //        dd($search);
    //        if ($request->ajax()) {
    //            return view('components.gameCard', ['games' => $paginatedGames]);
    //        }
            return view('/list', ['games' => $paginatedGames,
                'page_size' => $pageSize,
                'gameTags'=> $gameTags,
                'gameGenres' => $gameGenres,
                'search' => request('search'),
                'gamePlatforms' => $gamePlatforms,
                ]);
        }

        public function show($id)
        {

            $gameDetails = $this->rawgApiService->getGameDetails($id);
            $gameScreenshots = $this->rawgApiService->getScreenshots($id);

            $fullDescription = $gameDetails['description'] ?? '';
            $descriptions = explode('<p>Español<br />', $fullDescription);
            $englishDescription = $descriptions[0] ?? '';


            return view('/game', ['gameDetails' => $gameDetails,
                                        'englishDescription' => $englishDescription,
                                        'gameScreenshots' => $gameScreenshots,
                                       ]);
        }

    }
