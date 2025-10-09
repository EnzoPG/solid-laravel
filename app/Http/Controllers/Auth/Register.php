<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterUserRequest;

class Register extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(RegisterUserRequest $request)
    {
        // Create the user
        $user = User::create($request->toArray());
 
        // Log them in
        Auth::login($user);
 
        // Redirect to home
        return redirect('/')->with('success', 'Welcome to Chirper!');
    }
}
