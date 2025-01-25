<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    public function store(UserRequest $request)
    {
        $validated = $request->validated();
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' =>  bcrypt($validated['password']),
            'role_id' => 1
        ]);
        return response()->json(['message' => 'User created successfully', 'data' => $user], 201);
    }
}
