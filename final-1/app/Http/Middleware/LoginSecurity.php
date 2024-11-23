<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class LoginSecurity
{
    public function handle(Request $request, Closure $next): Response
    {
        $key = 'login_' . $request->ip();

        $limiter = RateLimiter::attempt(
            $key,
            5, // maximum attempts
            function () {
                // This callback is executed when the request is allowed
            },
            300 // decay time in seconds (5 minutes)
        );

        if (! $limiter->succeeded()) {
            return response()->json([
                'message' => 'Too many login attempts. Please try again in ' .
                    $limiter->remainingTime() . ' seconds.',
                'seconds_remaining' => $limiter->remainingTime()
            ], Response::HTTP_TOO_MANY_REQUESTS);
        }

        return $next($request);
    }
}
