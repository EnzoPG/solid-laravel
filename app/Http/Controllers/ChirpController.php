<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use App\Http\Requests\CreateChirpRequest;

class ChirpController extends Controller
{

    /** 
     * Validate that the authenticated user is the owner of the chirp.
     */
    private function validateUser(Chirp $chirp)
    {
        if ($chirp->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
    }

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
        $this->validateUser($chirp);
        return view('chirps.edit', compact('chirp'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateChirpRequest $request, Chirp $chirp)
    {
        $this->validateUser($chirp);
        $chirp->update($request->toArray());
        return redirect('/')->with('success', 'Chirp updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp)
    {
        $this->validateUser($chirp);
        $chirp->delete();
        return redirect('/')->with('success', 'Chirp deleted!');
    }
}
