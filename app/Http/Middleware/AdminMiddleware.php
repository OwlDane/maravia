<?php

namespace App\Http\Middleware;

use Closure;
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
    public function handle(Request $request, Closure $next): Response
    {
        // Only allow if authenticated via the admin guard
        if (! Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }

        // Optionally ensure the user has admin flag/role if needed
        $user = Auth::guard('admin')->user();
        if (method_exists($user, 'is_admin') && ! $user->is_admin) {
            return redirect()->route('admin.login');
        }

        // Proceed and then add strong no-cache headers to prevent back navigation showing cached pages
        $response = $next($request);
        $response->headers->set('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');

        return $response;
    }
}
