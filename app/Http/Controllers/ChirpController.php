<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use App\Http\Requests\CreateChirpRequest;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $chirps = Chirp::with('user')
            ->latest()
            ->take(50)
            ->get();

        return view('home', ['chirps' => $chirps]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateChirpRequest $request)
    {
        // Use the authenticated user
        auth()->user()->chirps()->create($request->toArray());
        return redirect('/')->with('success', 'Chirp created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp)
    {
        $this->authorize('update', $chirp);
        return view('chirps.edit', compact('chirp'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateChirpRequest $request, Chirp $chirp)
    {
        $this->authorize('update', $chirp);
        $chirp->update($request->toArray());
        return redirect('/')->with('success', 'Chirp updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp)
    {
        $this->authorize('delete', $chirp);
        $chirp->delete();
        return redirect('/')->with('success', 'Chirp deleted!');
    }
}
