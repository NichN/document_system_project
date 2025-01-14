<?php

namespace App\Http\Controllers;

use App\Models\User;
use Firebase\JWT\JWT;
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
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }
        $user = Auth::user();
        $token = $user->createToken('API Token')->accessToken;

        $request->session()->regenerate();
        if ($request->expectsJson()) {
            return response()->json(['token' => $token], 200);
        }

        return redirect()->intended('/');
    }


}
