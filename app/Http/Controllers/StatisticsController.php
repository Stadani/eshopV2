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
//monthly sales
        $monthlyTotalSales = InventoryGame::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(id) as total_sales')
        )
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->pluck('total_sales');
        $monthlyLabels = [
           'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];

//paltforms
        $excludedValue = 'All';
        $platformSales = InventoryGame::select('platform', DB::raw('count(*) as total_sales'))
            ->where('platform', '!=', $excludedValue)
            ->groupBy('platform')
            ->orderByDesc('total_sales')
            ->get();

        $platformLabels = [];
        $platformData = [];

        foreach ($platformSales as $sale) {
            $platformLabels[] = $sale->platform;
            $platformData[] = $sale->total_sales;
        }
//genres
        $mostSoldGenres = DB::table('purchase_history')
            ->join('game_and_category', 'purchase_history.game_id', '=', 'game_and_category.game_id')
            ->join('game_categories', 'game_and_category.category_id', '=', 'game_categories.id')
            ->select('game_categories.category', DB::raw('COUNT(*) as total_sales'))
            ->whereNull('purchase_history.dlc_id')
            ->groupBy('game_categories.category')
            ->orderByDesc('total_sales')

            ->get();

        return view('statistics', compact( 'monthlyTotalSales', 'monthlyLabels',
            'platformLabels', 'platformData','mostSoldGenres'));
    }
}
