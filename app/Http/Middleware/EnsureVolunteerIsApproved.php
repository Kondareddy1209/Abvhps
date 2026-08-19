<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureVolunteerIsApproved
{
    /**
     * Handle an incoming request for volunteer-authenticated routes.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('volunteer')->check()) {
            return redirect()->route('volunteer.login')->with('error', 'Please log in to access the Volunteer Portal.');
        }

        $volunteer = Auth::guard('volunteer')->user();

        // Strict verification: Volunteer must be APPROVED and ACTIVE
        if ($volunteer->status !== 'approved' || (isset($volunteer->is_active) && !$volunteer->is_active)) {
            Auth::guard('volunteer')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('volunteer.login')->with('error', 'Your volunteer account is not active or approved. Please contact the administration.');
        }

        return $next($request);
    }
}
