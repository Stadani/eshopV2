<?php

    namespace App\Http\Controllers;

    use App\Models\Game;
    use App\Models\GameCategory;
    use App\Models\GameDeveloper;
    use App\Models\GameDLC;
    use App\Models\GamePlatform;
    use App\Models\GamePublisher;
    use App\Models\GameScreenshot;
    use App\Models\GameTrailer;
    use App\Models\SameSeriesGame;
    use App\Services\SteamService;
    use Illuminate\Http\Request;
    use App\Services\RawgService;
    use Illuminate\Pagination\LengthAwarePaginator;
    use function Laravel\Prompts\search;


    class GameController extends Controller
    {


        protected $rawgApiService;

        public function __construct(RawgService $rawgApiService)
        {
            $this->rawgApiService = $rawgApiService;

        }



        public function index(Request $request)
        {

            $gameTags = $this->rawgApiService->getTags();

            $pageSize = $request->input('page_size', 24);
            $currentPage = $request->input('page', 1);
            $search = $request->input('search', '');
            $ordering = $request->input('ordering', '');

            $gameGenres = $this->rawgApiService->getGenres();
            $selectedGenres = $request->input('genres', []);
            $genreString = implode(',', $selectedGenres);

            $gamePlatforms = $this->rawgApiService->getPlatforms();
            $selectedPlatforms = $request->input('platforms', []);
            $platformString = implode(',', $selectedPlatforms);

            $gameDevelopers = $this->rawgApiService->getDevelopers();
            $selectedDevelopers = $request->input('developers', []);
            $developersString = implode(',', $selectedDevelopers);

            $gamePublishers = $this->rawgApiService->getPublishers();
            $selectedPublishers = $request->input('publishers', []);
            $publishersString = implode(',', $selectedPublishers);

            $queryParameters = [
                    'page_size' => $pageSize,
                    'page' => $currentPage,
                    'search' => $search,
                    'ordering' => $ordering,
            ];

            if (!empty($genreString)) {
                $queryParameters['genres'] = $genreString;
            }
            if (!empty($platformString)) {
                $queryParameters['platforms'] = $platformString;
            }
            if (!empty($developersString)) {
                $queryParameters['developers'] = $developersString;
            }
            if (!empty($publishersString)) {
                $queryParameters['publishers'] = $publishersString;
            }


            $response = $this->rawgApiService->getGames($queryParameters);

            $games = collect($response['results'] ?? []);
            $totalGames = $response['count'] ?? 0;



            $paginatedGames = new LengthAwarePaginator(
                $games,
                $totalGames,
                $pageSize,
                $currentPage,
                ['path' => $request->url(), 'query' => $request->query()]
            );


//GAMES

//            $currentPage = 25;
//            $totalPages = 50;
//
//            do {
//                $request->merge(['page' => $currentPage]);
//                $response = $this->rawgApiService->getGames($request->all());
//                $gamesData = $response['results'] ?? [];
//                dd($gamesData);
//                foreach ($gamesData as $gameData) {
//                    Game::updateOrCreate(
//                        ['name' => $gameData['name']],
//                        [
//                            'name' => $gameData['name'],
//                            'game_picture' => $gameData['background_image'],
//                            'release_date' => $gameData['released'],
//                            'rating' => $gameData['rating'],
//                        ]
//                    );
//                }
//                $currentPage++;
//            } while ($currentPage <= $totalPages);
//

//GAME DESCRIPTION

//            $currentPage = 1;
//            $totalPages = 50;
//
//            do {
//                $request->merge(['page' => $currentPage]);
//                $response = $this->rawgApiService->getGames($request->all());
//                $gamesData = $response['results'] ?? [];
//
//                foreach ($gamesData as $gameData) {
//                    $game = Game::updateOrCreate(
//                        ['name' => $gameData['name']],
//                        [
//                            'name' => $gameData['name'],
//                            'game_picture' => $gameData['background_image'],
//                            'release_date' => $gameData['released'],
//                            'rating' => $gameData['rating'],
//                        ]
//                    );
//
//                    $gameDetails = $this->rawgApiService->getGameDetails($gameData['id']);
//                    $fullDescription = $gameDetails['description'] ?? '';
//                    $descriptions = explode('<p>Español<br />', $fullDescription);
//                    $englishDescription = $descriptions[0] ?? '';
//
//                    $game->update(['description' => $englishDescription]);
//                }
//
//                $currentPage++;
//            } while ($currentPage <= $totalPages);

//CATEGORIES

//            $currentPage = 1;
//            $totalPages = 2;
//
//            do {
//                $request->merge(['page' => $currentPage]);
//                $response = $this->rawgApiService->getGenres($request->all());
//                $genresData = $response['results'] ?? [];
////                dd($genresData);
//                foreach ($genresData as $genreData) {
//                    GameCategory::updateOrCreate(
//                        ['slug' => $genreData['slug']],
//                        [
//                            'category' => $genreData['name'],
//                            'slug' => $genreData['slug'],
//                        ]
//                    );
//                }
//                $currentPage++;
//            } while ($currentPage <= $totalPages );

//PLATFORMS

//            $platformResponse = $this->rawgApiService->getPlatforms();
//
//            // Extract relevant information from the API response
//            $platformsData = $platformResponse['results'] ?? [];
////            {{dd($platformsData);}}
//            // Insert categories into the database
//            foreach ($platformsData as $platformData) {
//                // Create a new category record or update if it already exists
//                GamePlatform::updateOrCreate(
//                    ['name' => $platformData['name']], // Check if the category already exists based on its slug
//                    [
//                        'name' => $platformData['name'],
//                    ]
//                );
//            }

//DEVELOPERS

//            $currentPage = 1;
//            $totalPages = 10;
//            do {
//                $developersResponse = $this->rawgApiService->getDevelopers(['page' => $currentPage]);
//                $developersData = $developersResponse['results'] ?? [];
//
//                foreach ($developersData as $developerData) {
//                    GameDeveloper::updateOrCreate(
//                        ['name' => $developerData['name']],
//                        [
//                            'name' => $developerData['name'],
//                        ]
//                    );
//                }
//                $currentPage++;
//            } while ($currentPage <= $totalPages);

//PUBLISHERS

//            $currentPage = 1;
//            $totalPages = 10;
//            do {
//                $publishersResponse = $this->rawgApiService->getPublishers(['page' => $currentPage]);
//                $publishersData = $publishersResponse['results'] ?? [];
//                dd($publishersData);
//                foreach ($publishersData as $publisherData) {
//                    GamePublisher::updateOrCreate(
//                        ['name' => $publisherData['name']],
//                        [
//                            'name' => $publisherData['name'],
//                        ]
//                    );
//                }
//                $currentPage++;
//            } while ($currentPage <= $totalPages);

//GAME AND CATEGORY PIVOT

//            $currentPage = 40;
//            $totalPages = 50;
//
//            do {
//                $request->merge(['page' => $currentPage]);
//                $response = $this->rawgApiService->getGames($request->all());
//                $gamesData = $response['results'] ?? [];
//
//                foreach ($gamesData as $gameData) {
//                    $game = Game::updateOrCreate(
//                        ['name' => $gameData['name']],
//                        [
//                            'name' => $gameData['name'],
//                            'game_picture' => $gameData['background_image'],
//                            'release_date' => $gameData['released'],
//                            'rating' => $gameData['rating'],
//                        ]
//                    );
//
//                    $genres = $gameData['genres'] ?? [];
//
//                    foreach ($genres as $genre) {
//                        $category = GameCategory::where('category', $genre['name'])->first();
//
//                        if ($category) {
//                            if (!$game->category->contains($category->id)) {
//                                $game->category()->attach($category->id);
//                            }
//                        }
//                    }
//                }
//                $currentPage++;
//            } while ($currentPage <= $totalPages);

//GAME AND PLATFORM PIVOT

//            $currentPage = 1;
//            $totalPages = 50;
//
//            do {
//                $request->merge(['page' => $currentPage]);
//                $response = $this->rawgApiService->getGames($request->all());
//                $gamesData = $response['results'] ?? [];
////                dd($gamesData);
//                foreach ($gamesData as $gameData) {
//                    $game = Game::updateOrCreate(
//                        ['name' => $gameData['name']],
//                        [
//                            'name' => $gameData['name'],
//                            'game_picture' => $gameData['background_image'],
//                            'release_date' => $gameData['released'],
//                            'rating' => $gameData['rating'],
//                        ]
//                    );
//
//                    $platforms = $gameData['platforms'] ?? [];
//
//                    foreach ($platforms as $platform) {
////                        dd($platforms);
//                        $platformEntry = GamePlatform::where('name', $platform['platform']['name'])->first();
//
//                        if ($platformEntry) {
//                            if (!$game->platform->contains($platformEntry->id)) {
//                                $game->platform()->attach($platformEntry->id);
//                            }
//                        }
//                    }
//                }
//                $currentPage++;
//            } while ($currentPage <= $totalPages);

//GAME TRAILERS
//
//            $currentPage = 1;
//            $totalPages = 1;
//
//            do {
//                $request->merge(['page' => $currentPage]);
//                $response = $this->rawgApiService->getGames($request->all());
//                $gamesData = $response['results'] ?? [];
//
//                foreach ($gamesData as $gameData) {
//                    $game = Game::updateOrCreate(
//                        ['name' => $gameData['name']],
//                        [
//                            'name' => $gameData['name'],
//                            'game_picture' => $gameData['background_image'],
//                            'release_date' => $gameData['released'],
//                            'rating' => $gameData['rating'],
//                        ]
//                    );
//
//                    $trailersResponse = $this->rawgApiService->getTrailers($gameData['id']);
//                    $trailersData = $trailersResponse['results'] ?? [];
//
//                    foreach ($trailersData as $trailer) {
//
//                        GameTrailer::updateOrCreate(
//                            ['game_id' => $game->id, 'trailer' => $trailer['data']['max']],
//                            ['game_id' => $game->id,
//                                'trailer' => $trailer['data']['max'],
//
//                            ]);
//                    }
//                }
//                $currentPage++;
//            } while ($currentPage <= $totalPages);

//GAME SCREENSHOTS

//            $currentPage = 1;
//            $totalPages = 50;
//
//            do {
//                $request->merge(['page' => $currentPage]);
//                $response = $this->rawgApiService->getGames($request->all());
//                $gamesData = $response['results'] ?? [];
//
//                foreach ($gamesData as $gameData) {
//                    $game = Game::updateOrCreate(
//                        ['name' => $gameData['name']],
//                        [
//                            'name' => $gameData['name'],
//                            'game_picture' => $gameData['background_image'],
//                            'release_date' => $gameData['released'],
//                            'rating' => $gameData['rating'],
//                        ]
//                    );
//
//                    $screenshotsResponse = $this->rawgApiService->getScreenshots($gameData['id']);
//                    $screenshotsData = $screenshotsResponse['results'] ?? [];
//
//                    foreach ($screenshotsData as $screenshot) {
//                        GameScreenshot::updateOrCreate(
//                            ['game_id' => $game->id, 'screenshot' => $screenshot['image']],
//                            ['game_id' => $game->id, 'screenshot' => $screenshot['image']]
//                        );
//                    }
//                }
//                $currentPage++;
//            } while ($currentPage <= $totalPages);

//SAME SERIES GAMES

//            $currentPage = 1;
//            $totalPages = 50;
//
//            do {
//                $request->merge(['page' => $currentPage]);
//                $response = $this->rawgApiService->getGames($request->all());
//                $gamesData = $response['results'] ?? [];
//
//                foreach ($gamesData as $gameData) {
//                    $game = Game::updateOrCreate(
//                        ['name' => $gameData['name']],
//                        [
//                            'name' => $gameData['name'],
//                            'game_picture' => $gameData['background_image'],
//                            'release_date' => $gameData['released'],
//                            'rating' => $gameData['rating'],
//                        ]
//                    );
//
//                    $seriesResponse = $this->rawgApiService->getSameSeries($gameData['id']);
//                    $seriesData = $seriesResponse['results'] ?? [];
//
//                    foreach ($seriesData as $series) {
//                        $seriesGame = Game::where('name', $series['name'])->first();
//                        if ($seriesGame) {
//                            SameSeriesGame::updateOrCreate(
//                                [
//                                    'original_id' => $game->id,
//                                    'series_id' => $seriesGame->id,
//                                ]
//                            );
//                        }
//                    }
//                }
//                $currentPage++;
//            } while ($currentPage <= $totalPages);

//GAME DLCS

//            $currentPage = 1;
//            $totalPages = 50;
//
//            do {
//                $request->merge(['page' => $currentPage]);
//                $response = $this->rawgApiService->getGames($request->all());
//                $gamesData = $response['results'] ?? [];
//
//                foreach ($gamesData as $gameData) {
//                    $game = Game::updateOrCreate(
//                        ['name' => $gameData['name']],
//                        [
//                            'name' => $gameData['name'],
//                            'game_picture' => $gameData['background_image'],
//                            'release_date' => $gameData['released'],
//                            'rating' => $gameData['rating'],
//                        ]
//                    );
//
//                    $dlcsResponse = $this->rawgApiService->getDLCs($gameData['id']);
//                    $dlcsData = $dlcsResponse['results'] ?? [];
//
//                    foreach ($dlcsData as $dlcData) {
//                        $dlc = GameDLC::updateOrCreate(
//                            ['name' => $dlcData['name'], 'game_id' => $game->id],
//                            [
//                                'name' => $dlcData['name'],
//                                'game_id' => $game->id,
//                            ]
//                        );
//                    }
//                }
//                $currentPage++;
//            } while ($currentPage <= $totalPages);

//GAME AND DEVELOPERS PIVOT

//            $currentPage = 1;
//            $totalPages = 1;
//
//            do {
//                $request->merge(['page' => $currentPage]);
//                $response = $this->rawgApiService->getGames($request->all());
//                $gamesData = $response['results'] ?? [];
//
//                foreach ($gamesData as $gameData) {
//                    $game = Game::updateOrCreate(
//                        ['name' => $gameData['name']],
//                        [
//                            'name' => $gameData['name'],
//                            'game_picture' => $gameData['background_image'],
//                            'release_date' => $gameData['released'],
//                            'rating' => $gameData['rating'],
//                        ]
//                    );
//
//                    $developersResponse = $this->rawgApiService->getGameDetails($gameData['id']);
//                    $developersData = $developersResponse['developers'] ?? [];
//
//                    foreach ($developersData as $developerData) {
//                        $developerName = $developerData['name'] ?? null;
//                        if ($developerName) {
//                            $developer = GameDeveloper::where('name', $developerName)->first();
//                            if ($developer) {
//                                $game->developer()->syncWithoutDetaching([$developer->id]);
//                            }
//                        }
//                    }
//                }
//
//                    $currentPage++;
//            } while ($currentPage <= $totalPages);

//GAME AND PUBLISHER PIVOT

//            $currentPage = 48;
//            $totalPages = 50;
//
//            do {
//                $request->merge(['page' => $currentPage]);
//                $response = $this->rawgApiService->getGames($request->all());
//                $gamesData = $response['results'] ?? [];
//
//                foreach ($gamesData as $gameData) {
//                    $game = Game::updateOrCreate(
//                        ['name' => $gameData['name']],
//                        [
//                            'name' => $gameData['name'],
//                            'game_picture' => $gameData['background_image'],
//                            'release_date' => $gameData['released'],
//                            'rating' => $gameData['rating'],
//                        ]
//                    );
//
//                    $publishersResponse = $this->rawgApiService->getGameDetails($gameData['id']);
//                    $publishersData = $publishersResponse['publishers'] ?? [];
//
//                    foreach ($publishersData as $publisherData) {
//                        $publisherName = $publisherData['name'] ?? null;
//                        if ($publisherName) {
//                            $publisher = GamePublisher::where('name', $publisherName)->first();
//                            if ($publisher) {
//                                $game->publisher()->syncWithoutDetaching([$publisher->id]);
//                            }
//                        }
//                    }
//                }
//
//                $currentPage++;
//            } while ($currentPage <= $totalPages);



            return view('/list', ['games' => $paginatedGames,
                'page_size' => $pageSize,
                'gameTags'=> $gameTags,
                'gameGenres' => $gameGenres,
                'search' => request('search'),
                'gamePlatforms' => $gamePlatforms,
                'gameDevelopers' => $gameDevelopers,
                'gamePublishers' => $gamePublishers,
                ]);
        }

        public function show($id)
        {

//            $gameDetails = $this->rawgApiService->getGameDetails($id);
//            $gameScreenshots = $this->rawgApiService->getScreenshots($id);
//            $gameTrailers = $this->rawgApiService->getTrailers($id);
//            $gameDLCs = $this->rawgApiService->getDLCs($id);
//            $gameSeries = $this->rawgApiService->getSameSeries($id);
//
//            $fullDescription = $gameDetails['description'] ?? '';
//            $descriptions = explode('<p>Español<br />', $fullDescription);
//            $englishDescription = $descriptions[0] ?? '';
//
//
//            return view('/game', ['gameDetails' => $gameDetails,
//                                        'englishDescription' => $englishDescription,
//                                        'gameScreenshots' => $gameScreenshots,
//                                        'gameTrailers' => $gameTrailers,
//                                        'gameDLCs' => $gameDLCs,
//                                        'gameSeries' => $gameSeries,
//                                       ]);

            $game = Game::with('category', 'trailer', 'screenshot', 'developer', 'publisher', 'platform', 'gameDLCs', 'gameSeries')->find($id);
            return view('/game', ['game' => $game]);

        }

        public function carouselItems()
        {
            $sortedGames = $this->rawgApiService->getGames(['ordering' => '-metacritic', 'page_size' => 100]);
            $gamesList = $sortedGames['results'] ?? [];

            shuffle($gamesList);
            $randomGames = array_slice($gamesList, 0, 10);

            return view('index', ['games' => $randomGames]);

        }

        public function cart()
        {
            return view('cart');
        }

        public function addToCart($id, $platform)
        {
            $cartItemId = $id . '-' . $platform;

            $gameDetails = $this->rawgApiService->getGameDetails($id);
            $cart = session()->get('cart', []);

            if (isset($cart[$cartItemId])) {
                $cart[$cartItemId]['quantity']++;
            } else {
                $cart[$cartItemId] = [
                    "id" => $id,
                    "product_name" => $gameDetails['name'],
                    "platform" => $platform,
                    "thumbnail" => $gameDetails['background_image'],
                    "price" => 59.99,
                    "quantity" => 1
                ];
            }

            session()->put('cart', $cart);
            session()->now('success', 'Item added to cart!');
            return response()->json([
                'cartCount' => count($cart),
            ]);
        }

        public function removeFromCart(Request $request)
        {
            if ($request->id) {
                $cart = session()->get('cart');
                if (isset($cart[$request->id])) {
                    unset($cart[$request->id]);
                    session()->put('cart', $cart);
                }
                session()->flash('success', 'Item removed from cart!');
            }
        }

        public function updateCart(Request $request)
        {
            if ($request->id && $request->quantity) {
                $cart = session()->get('cart');
                $cart[$request->id]['quantity'] = $request->quantity;
                session()->put('cart', $cart);
            }
        }


    }
