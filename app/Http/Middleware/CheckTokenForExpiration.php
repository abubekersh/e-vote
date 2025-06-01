<?php

namespace App\Http\Middleware;

use App\Models\voter;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTokenForExpiration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->route('token');

        // Find the voter using the token
        $voter = voter::where('token', $token)->first();

        // If voter not found, deny access
        if (!$voter) {
            abort(404, 'Voter not found.');
        }

        // Check if the token is expired
        if (Carbon::now()->greaterThan($voter->token_expires_at)) {
            abort(403, 'Your token has expired,you have already voted');
        }

        // Check if the voter has already vote

        // Allow access if everything is fine
        return $next($request);
    }
}
