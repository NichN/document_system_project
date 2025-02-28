<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid credentials.',
            ], 401);
        }

        $user = Auth::user();

        $token = $user->createToken('API Token')->accessToken;

        return response()->json([
            'token' => $token,
            'name' => $user->username,
            'role' => $user->role, // Ensure the 'role' field exists in the User model
        ]);
        // Validate the incoming request
        // $credentials = $request->validate([
        //     'email' => 'required|email',
        //     'password' => 'required',
        // ]);

        // // Attempt to authenticate the user
        // if (!Auth::attempt($credentials)) {
        //     // If authentication fails, redirect back with an error message
        //     return back()->withErrors([
        //         'email' => 'The provided credentials do not match our records.',
        //     ])->onlyInput('email');
        // }

        // // Regenerate session to prevent session fixation attacks
        // $request->session()->regenerate();

        // // If authenticated, retrieve the authenticated user
        // $user = Auth::user();

        // // For API requests, generate and return an access token
        // if ($request->expectsJson()) {
        //     $token = $user->createToken('API Token')->accessToken;
        //     return response()->json(['token' => $token], 200);
        // }

        // // Redirect to the intended location (or a default page)
        // return redirect()->intended('/');
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }


}
