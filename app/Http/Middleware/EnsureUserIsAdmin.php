<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If there's no user, or their role isn't "admin", forbid access
        if (! $request->user() || $request->user()->role !== 'admin') {
            abort(403, 'Unauthorized.');
        }
        return $next($request);
    }
}