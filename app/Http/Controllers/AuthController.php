<?php

namespace App\Http\Controllers;

use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:Super Admin,Admin,Teacher,Student,Guest',
        ]);

        $user = User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json(['error' => 'Invalid email or password'], 401);
        }

        $payload = [
            'id' => $user->id,
            'role' => $user->role,
            'exp' => now()->addHours(2)->timestamp,
        ];

        $token = JWT::encode($payload, env('JWT_SECRET'), 'HS256');

        return response()->json(['token' => $token, 'role' => $user->role]);
    }
    // public function register(Request $request)
    // {
    //     $validated = $request->validate([
    //         'username' => 'required|string|unique:users',
    //         'email' => 'required|email|unique:users',
    //         'password' => 'required|min:6',
    //         'role' => 'required|in:Super Admin,Admin,Teacher,Student,Guest',
    //     ]);

    //     $user = User::create([
    //         'username' => $validated['username'],
    //         'email' => $validated['email'],
    //         'password' => Hash::make($validated['password']),
    //         'role' => $validated['role'],
    //     ]);

    //     return response()->json(['message' => 'User registered successfully'], 201);
    // }

    // // User Login
    // public function login(Request $request)
    // {
    //     $credentials = $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);

    //     $user = User::where('email', $credentials['email'])->first();

    //     if (!$user || !Hash::check($credentials['password'], $user->password)) {
    //         return response()->json(['error' => 'Invalid credentials'], 401);
    //     }

    //     $payload = [
    //         'id' => $user->id,
    //         'role' => $user->role,
    //         'exp' => now()->addHours(2)->timestamp,
    //     ];

    //     $token = JWT::encode($payload, env('JWT_SECRET'), 'HS256');

    //     return response()->json(['token' => $token, 'role' => $user->role]);
    // }
}
