<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\GameDLC;
use App\Models\InventoryGame;
use Illuminate\Http\Request;
use App\Services\RawgService;

class PurchaseHistoryController extends Controller
{
    protected $rawgApiService;

    public function __construct(RawgService $rawgApiService)
    {
        $this->rawgApiService = $rawgApiService;
    }


    public function index()
    {

        $purchaseHistory = InventoryGame::where('user_id', auth()->id())->paginate(10);
        $gameDetails = [];
        $dlcDetails = [];
        $itemDetails = [];
        foreach ($purchaseHistory as $purchase) {
            $gameId = $purchase->game_id;
            $dlcId = $purchase->dlc_id;

            $game = Game::find($gameId);
            $dlc = GameDLC::find($dlcId);

            if ($game) {
                $itemDetails[] = $game;
            }

            if ($dlc) {
                $itemDetails[] = $dlc;
            }
        }

        return view('inventory', [
            'purchaseHistory' => $purchaseHistory,
            'gameDetails' => $gameDetails,
            'dlcDetails' => $dlcDetails,
            'itemDetails' => $itemDetails,
        ]);
    }
}

