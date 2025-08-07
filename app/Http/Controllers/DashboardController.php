<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\OutgoingRequest;
use App\Models\Product;
use App\Models\Repair;
use App\Models\Returns;
use App\Models\StockMovement;
use App\Models\Supplier;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        $stats = [
            'total_products' => Product::active()->count(),
            'low_stock_products' => Product::lowStock()->count(),
            'pending_requests' => OutgoingRequest::pending()->count(),
            'pending_repairs' => Repair::pending()->count(),
            'recent_returns' => Returns::whereDate('returned_at', '>=', now()->subDays(7))->count(),
            'total_suppliers' => Supplier::active()->count(),
            'total_categories' => Category::active()->count(),
            'total_stock_value' => Product::active()->get()->sum(function ($product) {
                return $product->current_stock * (float) $product->cost_price;
            }),
        ];

        $lowStockProducts = Product::with(['category', 'supplier'])
            ->lowStock()
            ->active()
            ->orderBy('current_stock', 'asc')
            ->limit(10)
            ->get();

        $recentMovements = StockMovement::with(['product', 'user'])
            ->latest('movement_date')
            ->limit(10)
            ->get();

        $pendingRequests = OutgoingRequest::with(['requestedBy', 'items.product'])
            ->pending()
            ->latest('requested_at')
            ->limit(5)
            ->get();

        return Inertia::render('dashboard', [
            'stats' => $stats,
            'lowStockProducts' => $lowStockProducts,
            'recentMovements' => $recentMovements,
            'pendingRequests' => $pendingRequests,
        ]);
    }
}