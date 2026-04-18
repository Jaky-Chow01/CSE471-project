<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check() || auth()->user()->role !== $role) {
            if (!auth()->check()) {
                return redirect()->route('login')->with('error', 'Please log in to continue.');
            }
            abort(403, 'You do not have permission to access this area.');
        }

        return $next($request);
    }
}
