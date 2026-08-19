<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use App\Services\AuditLogger;

class AdminAuthController extends Controller
{
    /**
     * Display the Official Secure Admin Login Form Portal
     */
    public function showLoginView()
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login'); 
    }

    /**
     * Execute Secure Session Authentication Request Framework with Throttling & Audit Logging
     */
    public function executeAuthentication(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6'
        ]);

        $throttleKey = 'admin_login:' . Str::lower($request->input('email')) . '|' . $request->ip();

        // 1. Check Rate Limiter (Max 5 attempts per 60 seconds)
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            AuditLogger::log('ADMIN_LOGIN_THROTTLED', 'Admin', null, [
                'email' => $request->input('email'),
                'cooldown_seconds' => $seconds
            ], 'Anonymous', $request->input('email'));

            return back()->withErrors([
                'email' => "Too many login attempts. Please try again in {$seconds} seconds.",
            ])->onlyInput('email');
        }

        $rememberMeFlag = $request->has('remember');

        // 2. Execute strict authentication check
        if (Auth::guard('web')->attempt($credentials, $rememberMeFlag)) {
            // Clear rate limiter on success
            RateLimiter::clear($throttleKey);

            // Defend against session fixation
            $request->session()->regenerate();

            $user = Auth::guard('web')->user();

            AuditLogger::log('ADMIN_LOGIN_SUCCESS', 'User', (string)$user->id, [
                'email' => $user->email,
            ], 'Admin', $user->email, $user->id);

            return redirect()
                ->intended(route('admin.dashboard'))
                ->with('success', '🎉 Welcome Back Commander! Secure Administrative Session Initialized.');
        }

        // 3. Failed Attempt: hit rate limiter & log
        RateLimiter::hit($throttleKey, 60);

        AuditLogger::log('ADMIN_LOGIN_FAILED', 'User', null, [
            'attempted_email' => $request->input('email'),
            'attempts_left' => RateLimiter::retriesLeft($throttleKey, 5)
        ], 'Anonymous', $request->input('email'));

        // Uniform generic failure message (never reveals whether email exists)
        return back()->withErrors([
            'email' => 'Authentication Refused: Given email or security password mismatch found.',
        ])->onlyInput('email');
    }

    /**
     * Terminate Active Administrative Board Security Session Token Channels (Logout)
     */
    public function executeSessionTermination(Request $request)
    {
        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            AuditLogger::log('ADMIN_LOGOUT', 'User', (string)$user->id, [
                'email' => $user->email
            ], 'Admin', $user->email, $user->id);
        }

        Auth::guard('web')->logout();

        // Expire session completely
        $request->session()->invalidate();

        // Regenerate CSRF token
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', '🔐 Session Terminated Successfully! Central Administrative Gateways Locked.');
    }
}
