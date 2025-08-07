<?php

namespace App\Http\Controllers;

use App\Models\Repair;
use Inertia\Inertia;

class RepairController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $repairs = Repair::with(['product', 'assignedTo', 'createdBy'])
            ->latest()
            ->paginate(20);

        return Inertia::render('repairs/index', [
            'repairs' => $repairs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('repairs/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        return redirect()->route('repairs.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Repair $repair)
    {
        $repair->load(['product', 'assignedTo', 'createdBy']);

        return Inertia::render('repairs/show', [
            'repair' => $repair,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Repair $repair)
    {
        return Inertia::render('repairs/edit', [
            'repair' => $repair,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Repair $repair)
    {
        return redirect()->route('repairs.show', $repair);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Repair $repair)
    {
        return redirect()->route('repairs.index');
    }
}