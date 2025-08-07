<?php

namespace App\Http\Controllers;

use App\Models\OutgoingRequest;
use Inertia\Inertia;

class OutgoingRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $requests = OutgoingRequest::with(['requestedBy', 'items.product'])
            ->latest('requested_at')
            ->paginate(20);

        return Inertia::render('outgoing-requests/index', [
            'requests' => $requests,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('outgoing-requests/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        return redirect()->route('outgoing-requests.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(OutgoingRequest $outgoingRequest)
    {
        $outgoingRequest->load(['requestedBy', 'approvedBy', 'items.product']);

        return Inertia::render('outgoing-requests/show', [
            'request' => $outgoingRequest,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OutgoingRequest $outgoingRequest)
    {
        return Inertia::render('outgoing-requests/edit', [
            'request' => $outgoingRequest,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OutgoingRequest $outgoingRequest)
    {
        return redirect()->route('outgoing-requests.show', $outgoingRequest);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OutgoingRequest $outgoingRequest)
    {
        return redirect()->route('outgoing-requests.index');
    }


}