<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminAuthController extends Controller
{
    /**
     * Display the Official Secure Admin Login Form Portal
     */
        public function showLoginView()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login'); 
    }


    /**
     * Execute Secure Session Authentication Request Framework
     */
    public function executeAuthentication(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6'
        ]);

        // Enforce secure remember session cookie flag setup
        $rememberMeFlag = $request->has('remember');

        // Execute strict Laravel Auth check against cryptographically hashed security storage bounds
        if (Auth::attempt($credentials, $rememberMeFlag)) {
            
            // Regenerate session tokens to defend against brute force session fixation cyber attacks
            $request->session()->regenerate();

            return redirect()
                ->intended(route('admin.dashboard'))
                ->with('success', '🎉 Welcome Back Commander! Secure Administrative Session Initialized.');
        }

        // Return error flags back to dashboard login panel if credentials matrix verification failure
        return back()->withErrors([
            'email' => 'Authentication Refused: Given email or security password mismatch found.',
        ])->onlyInput('email');
    }

    /**
     * Terminate Active Administrative Board Security Session Token Channels (Logout)
     */
    public function executeSessionTermination(Request $request)
    {
        Auth::logout();

        // Expire all session data block footprints
        $request->session()->invalidate();

        // Re-generate fresh security tokens to protect upcoming client payloads
        $request->session()->regenerateToken();

        return redirect()
            ->route('admin.login')
            ->with('success', '🔐 Session Terminated Successfully! Central Administrative Gateways Locked.');
    }
}
