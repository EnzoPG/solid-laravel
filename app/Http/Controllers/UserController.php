<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;

class UserController extends Controller
{
    /**
     * Store a newly created user in storage.
     */
    public function store(RegisterUserRequest $request)
    {
        // Create the user
        $user = User::create($request->toArray());
        return $user;
    }
}
