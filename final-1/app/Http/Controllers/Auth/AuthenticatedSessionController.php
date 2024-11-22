<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\LoginAttempt;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{

    public function create()
    {
        return view('auth.login');  // Return the login view
    }

    /**
     * Maximum number of failed attempts before lockout
     */
    protected const MAX_ATTEMPTS = 5;

    /**
     * Lockout duration in minutes
     */
    protected const LOCKOUT_MINUTES = 15;


    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        // Check for previous failed attempts
        $recentAttempts = LoginAttempt::where('ip_address', $request->ip())
        ->where('email', $request->email)
        ->where('status', 'failed')
        ->where('created_at', '>=', now()->subMinutes(self::LOCKOUT_MINUTES))
        ->count();


        if ($recentAttempts >= self::MAX_ATTEMPTS) {
            return back()->withErrors([
                'email' => 'Too many login attempts. Please try again in ' . self::LOCKOUT_MINUTES . ' minutes.',
            ]);
        }

       

        // Record login attempt
        $attempt = LoginAttempt::create([
            'ip_address' => $request->ip(),
            'email' => $request->email,
            'user_agent' => $request->userAgent(),
            'status' => 'pending',
            'attempt_time' => now(),
        ]);

        try {
            $request->authenticate();
            $request->session()->regenerate();

            // Update attempt status
            $attempt->update(['status' => 'success']);

            // Update last login info
            User::where('id', Auth::id())->update([
                'last_login_at' => Carbon::now(),
                'last_login_ip' => $request->ip()
            ]);

            // Log successful login
            Log::info('Successful login', [
                'user_id' => Auth::id(),
                'email' => $request->email,
                'ip' => $request->ip()
            ]);

            if (Auth::attempt($request->only('email', 'password'))) {
                $request->session()->regenerate();
        
                $user = Auth::user();
        
                if ($user->is_super_admin) {
                    return redirect()->route('super-admin.dashboard');
                }
        
                if ($user->is_admin) {
                    return redirect()->route('admin.dashboard');
                }
        
                return redirect()->route('dashboard');
            }

            return redirect()->intended(RouteServiceProvider::HOME);
        } catch (\Exception $e) {
            $attempt->update(['status' => 'failed']);

            // Log failed attempt
            Log::warning('Failed login attempt', [
                'email' => $request->email,
                'ip' => $request->ip(),
                'error' => $e->getMessage()
            ]);

            throw $e;
        }
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
