<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // app/Http/Middleware/Role.php
    public function handle($request, Closure $next, $Role)
    {
        if (!$request->user() || $request->user()->Role !== $Role) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        return $next($request);
    }
}
