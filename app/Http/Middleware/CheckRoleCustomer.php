<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRoleCustomer
{
    public function handle(Request $request, Closure $next)
    {
        if($request->user()->role === 'Customer') {
            return $next($request);
        }
        return response()->json(['message' => 'Anda bukan Customer!'], 403);
    }
}
