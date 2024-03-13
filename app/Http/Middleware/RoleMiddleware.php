<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;


class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$role)
    {
        $user = Auth::user();
    
        if (!$user) {
            return response()->json(['message' => 'Acceso no autorizado'], 403);
        }
    
        $userRole = $user->rol;
        $hasAccess = in_array($userRole, $role);
    
        if ($hasAccess) {
            return $next($request);
        }
    
        return response()->json(['message' => 'Acceso no autorizado'], 403);
    }

}