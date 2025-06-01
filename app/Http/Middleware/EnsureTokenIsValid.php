<?php

namespace App\Http\Middleware;

use App\Models\passwordResetTokens;
use Closure;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Auth\Passwords\PasswordBrokerManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $pt = passwordResetTokens::where('email', $request->email)->first();
        if (!$pt || !Hash::check($request->token, $pt->token)) {
            abort(404);
        }
        return $next($request);
    }
}
