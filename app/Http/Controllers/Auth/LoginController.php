<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    // Menampilkan form login
    public function showForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        try {
            // Rate limiting - cegah brute force attack
            $this->checkTooManyFailedAttempts($request);

            $request->validate([
                'login'    => 'required|string',
                'password' => 'required|min:6'
            ], [
                'login.required' => 'Email or username is required.',
                'password.required' => 'Password is required.',
                'password.min' => 'Password must be at least 6 characters.'
            ]);

            // Cek input login (email atau username)
            $loginInput = $request->login;
            $field = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

            $credentials = [
                $field     => $loginInput,
                'password' => $request->password
            ];

            $remember = $request->has('remember');

            if (Auth::attempt($credentials, $remember)) {
                // Clear rate limiting pada login berhasil
                $this->clearLoginAttempts($request);

                $request->session()->regenerate();

                // Redirect berdasarkan role user
                return $this->authenticated($request, Auth::user());
            }

            // Increment failed attempts
            $this->incrementLoginAttempts($request);

            return back()->withErrors([
                'login' => 'These credentials do not match our records.'
            ])->withInput($request->except('password'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            return back()->withErrors([
                'login' => 'An error occurred during login. Please try again.'
            ])->withInput($request->except('password'));
        }
    }

    /**
     * Handle authenticated user redirect
     */
    protected function authenticated(Request $request, $user)
    {
        // Custom redirect logic berdasarkan role/user
        if (method_exists($user, 'isAdmin') && $user->isAdmin()) {
            return redirect()->intended('/admin/dashboard')->with('success', 'Welcome back, Admin!');
        }

        return redirect()->intended('/dashboard')->with('success', 'Welcome back, ' . $user->name . '!');
    }

    /**
     * Check if too many failed login attempts
     */
    private function checkTooManyFailedAttempts(Request $request)
    {
        $key = $this->throttleKey($request);

        if (RateLimiter::tooManyAttempts($key, 5)) { // 5 attempts per minute
            $seconds = RateLimiter::availableIn($key);

            throw \Illuminate\Validation\ValidationException::withMessages([
                'login' => "Too many login attempts. Please try again in {$seconds} seconds."
            ]);
        }
    }

    /**
     * Increment login attempts
     */
    private function incrementLoginAttempts(Request $request)
    {
        RateLimiter::hit($this->throttleKey($request), 60); // 60 seconds
    }

    /**
     * Clear login attempts on successful login
     */
    private function clearLoginAttempts(Request $request)
    {
        RateLimiter::clear($this->throttleKey($request));
    }

    /**
     * Get throttle key for rate limiting
     */
    private function throttleKey(Request $request)
    {
        return Str::lower($request->input('login')) . '|' . $request->ip();
    }

    // Logout
    public function logout(Request $request)
    {
        try {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('success', 'You have been logged out successfully.');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('info', 'You have been logged out.');
        }
    }
}
