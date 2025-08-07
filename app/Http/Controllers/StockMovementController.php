<?php

namespace App\Http\Controllers;

use App\Models\StockMovement;
use Inertia\Inertia;

class StockMovementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movements = StockMovement::with(['product', 'user'])
            ->latest('movement_date')
            ->paginate(50);

        return Inertia::render('stock-movements/index', [
            'movements' => $movements,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        // Implementation would go here
        return redirect()->route('stock-movements.index');
    }
}