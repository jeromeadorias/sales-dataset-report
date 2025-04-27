<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Calculate total sales
        $totalSales = Sale::sum('total_sales');

        // Count total number of sales
        $salesCount = Sale::count();

        // Sales per region
        $salesPerRegion = Sale::select('region_id', DB::raw('COUNT(*) as count'))
            ->groupBy('region_id')
            ->with('region')
            ->get()
            ->map(function ($sale) {
                return [
                    'region_name' => optional($sale->region)->name ?? 'Unknown',
                    'count' => $sale->count,
                ];
            });

        // Sales per month (only group by month and year, not day)
        $salesPerMonth = Sale::select(
            DB::raw('YEAR(date) as year'),
            DB::raw('MONTH(date) as month'),
            DB::raw('SUM(total_sales) as total_sales')
        )
        ->groupBy('year', 'month')
        ->orderByRaw('year ASC, month ASC')
        ->get();

        return view('dashboard.index', compact(
            'totalSales',
            'salesCount',
            'salesPerRegion',
            'salesPerMonth'
        ));
    }
}
