<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\GameAndPlatform;
use App\Models\GameCategory;
use App\Models\GameDeveloper;
use App\Models\GameDLC;
use App\Models\GamePlatform;
use App\Models\GamePublisher;
use App\Models\GameScreenshot;
use App\Models\GameTrailer;
use App\Models\PriceHistory;
use App\Models\PriceHistoryDlc;
use App\Models\SameSeriesGame;
use App\Services\SteamService;
use Illuminate\Http\Request;
use App\Services\RawgService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use function Laravel\Prompts\search;
use function PHPUnit\Framework\isEmpty;


class GameController extends Controller
{


    protected $rawgApiService;

    public function __construct(RawgService $rawgApiService)
    {
        $this->rawgApiService = $rawgApiService;

    }


    /**
     * Zobrazuje zoznam hier a umoznuje filtrovanie
     */
    public function index(Request $request)
    {
        $searchQuery = $request->input('search');

        $gamesQuery = Game::query();

        if ($searchQuery) {
            $gamesQuery->where('name', 'like', '%' . $searchQuery . '%');
        }

        if ($request->has('genres')) {
            $genres = $request->input('genres');
            $gamesQuery->whereHas('category', function ($query) use ($genres) {
                $query->whereIn('id', $genres);
            });
        }

        if ($request->has('platforms')) {
            $platforms = $request->input('platforms');
            $gamesQuery->whereHas('platform', function ($query) use ($platforms) {
                $query->whereIn('id', $platforms);
            });
        }

        if ($request->has('developers')) {
            $developers = $request->input('developers');
            $gamesQuery->whereHas('developer', function ($query) use ($developers) {
                $query->whereIn('id', $developers);
            });
        }

        if ($request->has('publishers')) {
            $publishers = $request->input('publishers');
            $gamesQuery->whereHas('publisher', function ($query) use ($publishers) {
                $query->whereIn('id', $publishers);
            });
        }

        $ordering = $request->input('ordering');
        switch ($ordering) {
            case 'name':
                $gamesQuery->orderBy('name');
                break;
            case '-name':
                $gamesQuery->orderByDesc('name');
                break;
            case 'released':
                $gamesQuery->orderBy('release_date');
                break;
            case '-released':
                $gamesQuery->orderByDesc('release_date');
                break;
            case 'rating':
                $gamesQuery->orderBy('rating');
                break;
            case '-rating':
                $gamesQuery->orderByDesc('rating');
                break;
            case 'urating':
                $gamesQuery->leftJoin('reviews', 'games.id', '=', 'reviews.game_id')
                    ->select('games.id', 'games.name', 'games.game_picture', 'games.rating', DB::raw('AVG(reviews.rating) as avg_rating'))
                    ->groupBy('games.id', 'games.name', 'games.game_picture', 'games.rating')
                    ->orderBy('avg_rating');

                break;
            case '-urating':
                $gamesQuery->leftJoin('reviews', 'games.id', '=', 'reviews.game_id')
                    ->select('games.id', 'games.name', 'games.game_picture', 'games.rating', DB::raw('AVG(reviews.rating) as avg_rating'))
                    ->groupBy('games.id', 'games.name', 'games.game_picture', 'games.rating')
                    ->orderByDesc('avg_rating');

                break;
        }

        $games = $gamesQuery->paginate(24)->appends(request()->query());

        $genres = GameCategory::all();
        $platforms = GamePlatform::all();
        $developers = GameDeveloper::all();
        $publishers = GamePublisher::all();

        foreach ($games as $game) {
            $userRating = $game->review()->where('game_id', $game->id)
                ->where('user_id', auth()->id())
                ->value('rating');
            $game->user_rating = $userRating;

            $averageRating = $game->review()->where('game_id', $game->id)->avg('rating');
            $game->average_rating = $averageRating;
        }

        return view('list', [
            'game' => $games,
            'genres' => $genres,
            'platforms' => $platforms,
            'developers' => $developers,
            'publishers' => $publishers,
            'search' => $searchQuery,
        ]);


    }

    /**
     zobrazi obsah hry
     */
    public function show($id, Request $request)
    {
        $dlc = GameDLC::all();
        $game = Game::with('category', 'trailer', 'screenshot', 'developer', 'publisher', 'platform', 'gameDLCs', 'gameSeries')->find($id);


        $perPage = $request->input('perPage', 20);
        $reviews = $game->review()->paginate($perPage)->withQueryString();
        $showUsersReview = $game->review()->where('user_id', auth()->id())->get();
        $averageRating = $game->review()->where('game_id', $game->id)->avg('rating');
        $priceHistory = PriceHistory::where('game_id', $game->id)->get();
        $dlcPriceHistory = PriceHistoryDlc::all();

        if ($request->ajax()) {
            $forumItemsView = view('components.userReview', ['reviews' => $reviews])->render();
            $paginationView = $reviews->links()->render();

            return response()->json([
                'forumItemsHTML' => $forumItemsView,
                'paginationHTML' => $paginationView,
            ]);
        } else {
            return view('/game', ['game' => $game,
                'dlc' => $dlc,
                'reviews' => $reviews,
                'perPage' => $perPage,
                'showUsersReview' => $showUsersReview,
                'averageRating' => $averageRating,
                'priceHistory' => $priceHistory,
                'dlcPriceHistory' => $dlcPriceHistory,
            ]);
        }
    }

    public function carouselItems()
    {
        $sortedGames = Game::orderByDesc('rating')
            ->limit(100)
            ->get();

        $randomGames = $sortedGames->shuffle()->take(10);

        return view('index', ['games' => $randomGames]);

    }

    public function cart()
    {
        return view('cart');
    }

    public function addToCart($id, $platform, $dlc)
    {

        $cartItemId = $id . '-' . $platform;
        $cart = session()->get('cart', []);
        $game = Game::findOrFail($id);

        if ($dlc == "true") {
            $dlcDetails = GameDLC::findOrFail($id);
            if (isset($cart[$cartItemId])) {
                $cart[$cartItemId]['quantity']++;
            } else {
                $gameId = GameDLC::where('id', $id)
                    ->value('game_id');
                $thumbnail = Game::where('id', $gameId)
                    ->value('game_picture');
                $cart[$cartItemId] = [
                    "id" => $id,
                    "product_name" => $dlcDetails->name,
                    "platform" => $platform,
                    "thumbnail" => $thumbnail,
                    "price" => $dlcDetails->price,
                    "quantity" => 1,
                    "is_dlc" => 'true',
                ];
            }
        } else {
            $gamePrice = GameAndPlatform::where('game_id', $id)
                ->where('platform_id', $platform)
                ->value('price');

            $platformName = GamePlatform::where('id', $platform)
                ->value('name');

            if ($gamePrice !== null) {
                if (isset($cart[$cartItemId])) {
                    $cart[$cartItemId]['quantity']++;
                } else {
                    $cart[$cartItemId] = [
                        "id" => $id,
                        "product_name" => $game->name,
                        "platform" => $platformName,
                        "thumbnail" => $game->game_picture,
                        "price" => $gamePrice,
                        "quantity" => 1,
                        "is_dlc" => 'false',
                    ];
                }


            }
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

    /**
        zobrazi formular na vytvorenie hry
     */
    public function createGameForm()
    {
        $genres = GameCategory::all();
        $developers = GameDeveloper::all();
        $publishers = GamePublisher::all();
        $platforms = GamePlatform::all();
        $games = Game::all();

        return view('gameForm', compact(
            'genres', 'developers', 'publishers', 'platforms', 'games'
        ));
    }


    /**
        ulozenie hry zadane vo formulary do DB
     */
    public function storeGameForm(Request $request, Game $game)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'game_picture' => 'required|image|mimes:jpeg,png,jpg|max:4096',
            'release_date' => 'required',
            'rating' => 'required|integer|min:0|max:5',
            'description' => 'required|string',
            'developers' => 'required|array',
            'developers.*' => 'exists:developers,id',
            'publishers' => 'required|array',
            'publishers.*' => 'exists:publishers,id',
            'trailers.*' => 'mimes:mp4,mov,avi|max:100000',
            'screenshots.*' => 'image|mimes:jpeg,png,jpg|max:100000',
            'genres' => 'required|array',
            'genres.*' => 'exists:game_categories,id',
            'platforms' => 'array',
            'platforms.*' => 'required_with:prices.*',
            'prices' => 'array',
            'prices.*' => 'required_with:platforms.*',
            'dlcs.*' => 'nullable|required_with:dlc_prices.*',
            'dlc_prices.*' => 'nullable|required_with:dlcs.*',
        ], [
            'dlc_prices.*.required_with' => 'Price is required when a DLC is provided.',
            'dlcs.*.required_with' => 'DLC is required when a price is provided.',
            'platforms.*.required_with' => 'Platform is required when a price is provided.',
            'prices.*.required_with' => 'Price is required when a Platform is provided.',
        ]);

        $path = $request->file('game_picture')->store('database_pictures', 'public');

        $game->name = $validatedData['name'];
        $game->game_picture = $path;
        $game->release_date = $validatedData['release_date'];
        $game->rating = $validatedData['rating'];
        $game->description = $validatedData['description'];

        $platforms = $request->input('platforms');
        $prices = $request->input('prices');

        $uniquePlatforms = array_unique($platforms);
        if (count($platforms) != count($uniquePlatforms)) {
            return redirect()->back()->withInput()->with('error', 'Duplicate platforms are not allowed.');
        }

        $nonNullPlatforms = array_filter($platforms, function ($value) {
            return $value !== null;
        });
        $nonNullPrices = array_filter($prices, function ($value) {
            return $value !== null;
        });

        if (count($nonNullPlatforms) !== count($nonNullPrices)) {
            return redirect()->back()->withInput()->with('error', 'Platform and price arrays must have the same length.');
        }

        $dlcsData = $request->input('dlcs');
        $dlcPricesData = $request->input('dlc_prices');
        $uniqueDlcs = array_unique($dlcsData);
        if (count($dlcsData) != count($uniqueDlcs)) {
            return redirect()->back()->withInput()->with('error', 'Duplicate DLCs are not allowed.');
        }

        $nonNullDlcs = array_filter($dlcsData, function ($value) {
            return $value !== null;
        });
        $nonNullDlcPrices = array_filter($dlcPricesData, function ($value) {
            return $value !== null;
        });
        if (count($nonNullDlcs) !== count($nonNullDlcPrices)) {
            return redirect()->back()->withInput()->with('error', 'DLC name and price arrays must have the same length.');
        }

        $game->save();
        $game->developer()->sync($request->developers);
        $game->publisher()->sync($request->publishers);

        if ($request->hasFile('trailers')) {
            foreach ($request->file('trailers') as $trailer) {
                $path = $trailer->store('database_trailers', 'public');
                $game->trailer()->create([
                    'trailer' => $path,
                ]);
            }
        }

        if ($request->hasFile('screenshots')) {
            foreach ($request->file('screenshots') as $screenshot) {
                $path = $screenshot->store('database_pictures', 'public');
                $game->screenshot()->create([
                    'screenshot' => $path,
                ]);
            }
        }
        $game->category()->sync($request->genres);


        foreach ($platforms as $index => $platform) {
            $existingPlatform = GamePlatform::where('name', $platform)->first();

            if (!$existingPlatform) {
                return redirect()->back()->withInput()->with('error', 'Platform "' . $platform . '" does not exist in the database.');
            }

            $gameAndPlatform = new GameAndPlatform();
            $platformModel = GamePlatform::firstOrCreate(['name' => $platform]);

            $gameAndPlatform->game_id = $game->id;
            $gameAndPlatform->platform_id = $platformModel->id;
            $gameAndPlatform->price = $prices[$index];

            $gameAndPlatform->save();
        }


        if ($nonNullDlcs && $nonNullDlcPrices) {
            foreach ($dlcsData as $index => $dlcName) {
                $dlcPrice = $nonNullDlcPrices[$index];

                $dlc = new GameDLC();
                $dlc->game_id = $game->id;
                $dlc->name = $dlcName;
                $dlc->price = $dlcPrice;
                $dlc->save();
            }
        }

        $seriesData = $request->input('series');
        if ($seriesData != null) {
            foreach ($seriesData as $seriesId) {
                $sameSeriesGame = new SameSeriesGame();
                $sameSeriesGame->original_id = $game->id;
                $sameSeriesGame->series_id = $seriesId;
                $sameSeriesGame->save();
            }
        }

        return redirect()->route('game.show', ['id' => $game->id])->with('success', 'Game created successfully.');
    }


    public function editGameForm(Game $game)
    {
        $genres = GameCategory::all();
        $developers = GameDeveloper::all();
        $publishers = GamePublisher::all();
        $platforms = GamePlatform::all();
        $games = Game::all();
        $gameAndPlatforms = GameAndPlatform::where('game_id', $game->id)->orderBy('game_id', 'desc')->get();
        $gameAndDlcs = GameDLC::where('game_id', $game->id)->get();


        if (auth()->user()->is_admin == 1) {
            return view('gameForm', [
                'game' => $game,
                'genres' => $genres,
                'developers' => $developers,
                'publishers' => $publishers,
                'platforms' => $platforms,
                'games' => $games,
                'gameAndPlatforms' => $gameAndPlatforms,
                'gameAndDlcs' => $gameAndDlcs,
            ]);
        }
        return redirect()->back();
    }

    public function updateGameForm(Request $request, Game $game)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'game_picture' => 'image|mimes:jpeg,png,jpg|max:4096',
            'release_date' => 'required',
            'rating' => 'required|integer|min:0|max:5',
            'description' => 'required|string',
            'developers' => 'required|array',
            'developers.*' => 'exists:developers,id',
            'publishers' => 'required|array',
            'publishers.*' => 'exists:publishers,id',
            'trailers.*' => 'mimes:mp4,mov,avi|max:100000',
            'screenshots.*' => 'image|mimes:jpeg,png,jpg|max:100000',
            'genres' => 'required|array',
            'genres.*' => 'exists:game_categories,id',
            'platforms' => 'array',
            'platforms.*' => 'required_with:prices.*',
            'prices' => 'array',
            'prices.*' => 'required_with:platforms.*',
            'dlcs.*' => 'nullable|required_with:dlc_prices.*',
            'dlc_prices.*' => 'nullable|required_with:dlcs.*',
        ], [
            'dlc_prices.*.required_with' => 'Price is required when a DLC is provided.',
            'dlcs.*.required_with' => 'DLC is required when a price is provided.',
            'platforms.*.required_with' => 'Platform is required when a price is provided.',
            'prices.*.required_with' => 'Price is required when a Platform is provided.',
        ]);


        if ($request->hasFile('game_picture')) {
            Storage::delete($game->game_picture);
            $path = $request->file('game_picture')->store('database_pictures', 'public');
            $game->game_picture = $path;
        }

        $game->name = $validatedData['name'];
        $game->release_date = $validatedData['release_date'];
        $game->rating = $validatedData['rating'];
        $game->description = $validatedData['description'];

        $game->update();
        $game->developer()->sync($request->developers);
        $game->publisher()->sync($request->publishers);
        $game->category()->sync($request->genres);

        if ($request->hasFile('trailers')) {
            $game->trailer()->delete();
            foreach ($request->file('trailers') as $trailer) {
                $path = $trailer->store('database_trailers', 'public');
                $game->trailer()->create([
                    'trailer' => $path,
                ]);
            }
        }

        if ($request->hasFile('screenshots')) {
            $game->screenshot()->delete();
            foreach ($request->file('screenshots') as $screenshot) {
                $path = $screenshot->store('database_pictures', 'public');
                $game->screenshot()->create([
                    'screenshot' => $path,
                ]);
            }
        }

        $platforms = $request->input('platforms');
        $prices = $request->input('prices');
        $uniquePlatforms = array_unique($platforms);
        if (count($platforms) != count($uniquePlatforms)) {
            return redirect()->back()->with('error', 'Duplicate platforms are not allowed.');
        }
        if (count($platforms) !== count($prices)) {
            return redirect()->back()->with('error', 'Platform and price arrays must have the same length.');
        }


        foreach ($platforms as $index => $platform) {
            $existingPlatform = GamePlatform::where('name', $platform)->first();

            if (!$existingPlatform) {
                return redirect()->back()->withInput()->with('error', 'Platform "' . $platform . '" does not exist in the database.');
            }

            $platformId = GamePlatform::where('name', $platform)->first();

            $previousPrices = [];
            $previousPrices[$existingPlatform->id] = GameAndPlatform::where('game_id', $game->id)
                ->where('platform_id', $platformId->id)->value('price');

            PriceHistory::updateOrCreate([
                'game_id' => $game->id,
                'platform_id' => $existingPlatform->id,
            ], [
                    'price' => $previousPrices[$existingPlatform->id],
                ]
            );

            $exists = GameAndPlatform::where('game_id', $game->id)
                ->where('platform_id', $platformId->id)
                ->exists();


            if ($exists) {
                GameAndPlatform::where('game_id', $game->id)
                    ->where('platform_id', $platformId->id)
                    ->update(['price' => $prices[$index]]);
            } else {

                $gameAndPlatform = new GameAndPlatform();
                $gameAndPlatform->game_id = $game->id;
                $gameAndPlatform->platform_id = $platformId->id;
                $gameAndPlatform->price = $prices[$index];
                $gameAndPlatform->save();
            }
        }

        $existingPlatformNames = collect($platforms);
        $existingPlatforms = $game->platform;
        foreach ($existingPlatforms as $existingPlatform) {
            if (!$existingPlatformNames->contains($existingPlatform->name)) {

                $game->platform()->detach($existingPlatform->id);
            }
        }


        $dlcsData = $request->input('dlcs');
        $dlcPricesData = $request->input('dlc_prices');
        $uniqueDlcs = array_unique($dlcsData);

        if (count($dlcsData) != count($uniqueDlcs)) {
            return redirect()->back()->with('error', 'Duplicate DLCs are not allowed.');
        }

        if ($dlcsData && $dlcPricesData) {

            if ($dlcsData) {
                $nonNullDlcs = array_filter($dlcsData, function ($value) {
                    return $value !== null;
                });
            }
            if ($dlcPricesData) {
                $nonNullDlcPrices = array_filter($dlcPricesData, function ($value) {
                    return $value !== null;
                });
            }

            if (count($nonNullDlcs) !== count($nonNullDlcPrices)) {
                return redirect()->back()->with('error', 'DLC name and price arrays must have the same length.');
            }


            $previousPricesDlc = [];
            foreach ($game->gameDLCs as $dlc) {
                $previousPricesDlc[$dlc->id] = $dlc->price;
            }


            foreach ($nonNullDlcs as $index => $dlc) {
                $dlcName = GameDLC::where('name', $dlc)->first();
                if ($dlcName !== null) {

                    $dlcId = $dlcName->id;
                    if (array_key_exists($dlcId, $previousPricesDlc)) {
                        PriceHistoryDLC::updateOrCreate([
                            'dlc_id' => $dlcId,

                        ], [
                            'price' => $previousPricesDlc[$dlcId],
                        ]);
                    }
                    GameDLC::where('game_id', $game->id)
                        ->where('name', $dlcName->name)
                        ->update(['price' => $nonNullDlcPrices[$index]]);
                } else {
                    $gameAndDlc = new GameDLC();
                    $gameAndDlc->game_id = $game->id;
                    $gameAndDlc->name = $dlc;
                    $gameAndDlc->price = $nonNullDlcPrices[$index];
                    $gameAndDlc->save();
                }
            }

            $existingDlcNames = collect($dlcsData);

            $existingDlcs = $game->gameDLCs;

            foreach ($existingDlcs as $existingDlc) {
                if (!$existingDlcNames->contains($existingDlc->name)) {
                    $game->gameDLCs()->where('name', $existingDlc->name)->delete();
                }
            }
        }


        return redirect()->route('game.show', ['id' => $game->id])->with('success', 'Game updated successfully.');

    }

    public function deleteGameForm(Game $game)
    {
        if (auth()->user() && auth()->user()->is_admin == 1) {
            foreach ($game->trailer as $trailer) {
                if (Storage::disk('public')->exists($trailer->trailer)) {
                    Storage::disk('public')->delete($trailer->trailer);
                }
            }
            foreach ($game->screenshot as $screenshot) {
                if (Storage::disk('public')->exists($screenshot->screenshot)) {
                    Storage::disk('public')->delete($screenshot->screenshot);
                }
            }
            if (Storage::disk('public')->exists($game->game_picture)) {
                Storage::disk('public')->delete($game->game_picture);

            }

            $game->delete();
            return redirect()->route('game.index')->with('success', 'Game deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Cannot perform this action');
        }
    }


}
