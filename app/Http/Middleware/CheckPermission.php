<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $admin = Auth::guard('admin')->user() ?? $request->user();

        if (!$admin || !$admin->hasPermission($permission)) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Unauthorized.'], 403);
            }
            return redirect()->route('unauthorized');
        }

        return $next($request);
    }
}
