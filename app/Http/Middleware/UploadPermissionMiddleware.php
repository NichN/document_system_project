<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UploadPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
{
    $token = $request->bearerToken();

    if (!$token) {
        return response()->json(['error' => 'Token not provided'], 401);
    }

    try {
        $decoded = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
        $allowedRoles = ['Super Admin', 'Admin', 'Teacher'];

        if (!in_array($decoded->role, $allowedRoles)) {
            return response()->json(['error' => 'Forbidden: You do not have permission to upload files'], 403);
        }
    } catch (\Exception $e) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    return $next($request);

}}
