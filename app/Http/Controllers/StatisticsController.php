<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\GameDLC;
use App\Models\InventoryGame;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function index()
    {

        $gameSales = InventoryGame::select('game_id', DB::raw('count(*) as total_sales'))
            ->whereNotNull('game_id')
            ->groupBy('game_id')
            ->orderByDesc('total_sales')
            ->take(5)
            ->get();

        $gameLabels = [];
        $gameData = [];

        foreach ($gameSales as $sale) {
            $game = Game::find($sale->game_id);
            if ($game) {
                $gameLabels[] = $game->name;
                $gameData[] = $sale->total_sales;
            }
        }

        // Chart for DLCs
        $dlcSales = InventoryGame::select('dlc_id', DB::raw('count(*) as total_sales'))
            ->whereNotNull('dlc_id')
            ->groupBy('dlc_id')
            ->orderByDesc('total_sales')
            ->take(5)
            ->get();

        $dlcLabels = [];
        $dlcData = [];

        foreach ($dlcSales as $sale) {
            $dlc = GameDLC::find($sale->dlc_id);
            if ($dlc) {
                $dlcLabels[] = $dlc->name;
                $dlcData[] = $sale->total_sales;
            }
        }

        $excludedValue = 'All';
        $platformSales = InventoryGame::select('platform', DB::raw('count(*) as total_sales'))
            ->where('platform', '!=', $excludedValue)
            ->groupBy('platform')
            ->orderByDesc('total_sales')
            ->take(5)
            ->get();

        $platformLabels = [];
        $platformData = [];

        foreach ($platformSales as $sale) {
            $platformLabels[] = $sale->platform;
            $platformData[] = $sale->total_sales;
        }


        return view('statistics', compact('gameLabels', 'gameData', 'dlcLabels', 'dlcData','platformLabels', 'platformData'));
    }
}
