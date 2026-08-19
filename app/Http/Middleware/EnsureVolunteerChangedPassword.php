<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureVolunteerChangedPassword
{
    /**
     * Handle an incoming request to force password change on first login.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('volunteer')->check()) {
            $volunteer = Auth::guard('volunteer')->user();

            if ($volunteer->must_change_password &&
                !$request->routeIs('volunteer.change_password*') &&
                !$request->routeIs('volunteer.logout')) {
                return redirect()->route('volunteer.change_password')
                    ->with('warning', 'For security, you must change your default temporary password before accessing the dashboard.');
            }
        }

        return $next($request);
    }
}
