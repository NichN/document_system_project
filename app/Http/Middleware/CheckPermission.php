<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\RolePermission;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $rolePermission = RolePermission::where('role', $user->role)->first();

        if (!$rolePermission || !$rolePermission->$permission) {
            return response()->json(['message' => 'Permission denied'], 403);
        }

        return $next($request);
    }
}
