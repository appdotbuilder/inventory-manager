<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class ReportController extends Controller
{
    /**
     * Display the reports dashboard.
     */
    public function index()
    {
        return Inertia::render('reports/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('reports/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        return redirect()->route('reports.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $reportType = $id;
        
        if ($reportType === 'inventory') {
            return Inertia::render('reports/inventory');
        }
        
        if ($reportType === 'stock-movements') {
            return Inertia::render('reports/stock-movements');
        }
        
        return Inertia::render('reports/show', ['reportType' => $reportType]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Inertia::render('reports/edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $id)
    {
        return redirect()->route('reports.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return redirect()->route('reports.index');
    }
}