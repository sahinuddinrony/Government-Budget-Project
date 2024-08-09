<?php

namespace App\Http\Middleware;

use Closure;
use App\Constants\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle(Request $request, Closure $next): Response
    // {
    //     return $next($request);
    // }

    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === Role::ADMIN) {
            return $next($request);
        }

        return redirect('login')->with('error', 'You do not have access to this page.');
        // return redirect('login');
    }
}
