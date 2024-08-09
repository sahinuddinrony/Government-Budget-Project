<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIfApproved
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }

    // public function handle(Request $request, Closure $next)
    // {
    //     if (auth()->check() && !auth()->user()->approved) {
    //         auth()->logout();
    //         return redirect('/login')->with('error', 'Your account is not approved yet.');
    //     }

    //     return $next($request);
    // }


}
