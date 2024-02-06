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

            $gameDetails = $this->rawgApiService->getGameDetails($id);
            $gameScreenshots = $this->rawgApiService->getScreenshots($id);
            $gameTrailers = $this->rawgApiService->getTrailers($id);
            $gameDLCs = $this->rawgApiService->getDLCs($id);
            $gameSeries = $this->rawgApiService->getSameSeries($id);

            $fullDescription = $gameDetails['description'] ?? '';
            $descriptions = explode('<p>Español<br />', $fullDescription);
            $englishDescription = $descriptions[0] ?? '';


            return view('/game', ['gameDetails' => $gameDetails,
                                        'englishDescription' => $englishDescription,
                                        'gameScreenshots' => $gameScreenshots,
                                        'gameTrailers' => $gameTrailers,
                                        'gameDLCs' => $gameDLCs,
                                        'gameSeries' => $gameSeries,
                                       ]);
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
