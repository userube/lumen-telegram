<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserIdMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $userId = $request->header('User-ID');
        
        if (!$userId) {
            return response()->json(['error' => 'User ID header parameter is missing'], 400);
        }
        
        return $next($request);
    }
}