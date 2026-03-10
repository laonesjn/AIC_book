<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class RedirectAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            // If already on an admin URL allow it — avoid redirect loop
            if ($request->is('admin/*') || $request->is('admin') ) {
                return $next($request);
            }

            return redirect()->route('admin.dashboard');
        }

        return $next($request);
    }
}
