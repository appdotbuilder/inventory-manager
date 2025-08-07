<?php

namespace App\Http\Controllers;

use App\Models\Returns;
use Inertia\Inertia;

class ReturnsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $returns = Returns::with(['product', 'returnedBy'])
            ->latest('returned_at')
            ->paginate(20);

        return Inertia::render('returns/index', [
            'returns' => $returns,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('returns/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        return redirect()->route('returns.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Returns $return)
    {
        $return->load(['product', 'returnedBy']);

        return Inertia::render('returns/show', [
            'return' => $return,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Returns $return)
    {
        return Inertia::render('returns/edit', [
            'return' => $return,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Returns $return)
    {
        return redirect()->route('returns.show', $return);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Returns $return)
    {
        return redirect()->route('returns.index');
    }
}