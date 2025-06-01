<?php

namespace App\Http\Middleware;

use Closure;
use Dotenv\Util\Str;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // dd($role);
        if ($request->user()->role !== $role) {
            return redirect(route('home'));
        }
        return $next($request);
    }
}
