<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class JuryMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->role_id !== 3 || $request->user()->jury->count() === 0) {
            return response()->fail('Unauthorized', 403);
        }
        return $next($request);
    }
}
