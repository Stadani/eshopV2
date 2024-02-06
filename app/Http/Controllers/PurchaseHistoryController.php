<?php

namespace App\Http\Controllers;

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
        foreach ($purchaseHistory as $purchase) {
            $gameId = $purchase->idGame;
            $gameDetails[$gameId] = $this->rawgApiService->getGameDetails($gameId);
        }

        return view('inventory', [
            'purchaseHistory' => $purchaseHistory,
            'gameDetails' => $gameDetails,
        ]);
    }
}
