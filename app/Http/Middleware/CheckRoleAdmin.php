<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRoleAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if($request->user()->role === 'Admin') {
            return $next($request);
        }
        return response()->json(['message' => 'Anda bukan Admin!'], 403);
    }
}
