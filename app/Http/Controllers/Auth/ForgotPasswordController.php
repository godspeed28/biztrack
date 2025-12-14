<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    // Menampilkan form forgot password
    public function showForm()
    {
        return view('auth.forgotpass');
    }

    // Mengirim link reset password
    public function sendResetLink(Request $request)
    {
        // Rate limiting - cegah spam
        $this->checkTooManyAttempts($request);

        $request->validate([
            'email' => 'required|email'
        ], [
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
        ]);

        try {
            // Increment attempts sebelum mengirim email
            $this->incrementAttempts($request);

            // Kirim link reset ke email pengguna
            $status = Password::sendResetLink(
                $request->only('email')
            );

            if ($status === Password::RESET_LINK_SENT) {
                // Clear rate limiting pada success
                $this->clearAttempts($request);

                // Log activity
                Log::info("Password reset link sent to: {$request->email}");

                return back()->with('success', 'Password reset link has been sent to your email!');
            }

            return back()->withErrors([
                'email' => $this->getErrorMessage($status)
            ])->withInput($request->only('email'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error("Password reset error: " . $e->getMessage());
            return back()->withErrors([
                'email' => 'Failed to send reset link. Please try again.'
            ])->withInput($request->only('email'));
        }
    }

    /**
     * Check if too many reset password attempts
     */
    private function checkTooManyAttempts(Request $request)
    {
        $key = $this->throttleKey($request);

        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);

            throw \Illuminate\Validation\ValidationException::withMessages([
                'email' => "Too many reset attempts. Please try again in {$seconds} seconds."
            ]);
        }
    }

    /**
     * Increment reset attempts
     */
    private function incrementAttempts(Request $request)
    {
        RateLimiter::hit($this->throttleKey($request), 60);
    }

    /**
     * Clear attempts on successful request
     */
    private function clearAttempts(Request $request)
    {
        RateLimiter::clear($this->throttleKey($request));
    }

    /**
     * Get throttle key for rate limiting
     */
    private function throttleKey(Request $request)
    {
        return Str::lower('forgot-password|' . $request->ip() . '|' . $request->email);
    }

    /**
     * Get user-friendly error message
     */
    private function getErrorMessage($status)
    {
        $messages = [
            Password::INVALID_USER => 'If this email exists, we have sent a reset link to it.',
            Password::RESET_THROTTLED => 'Please wait before requesting another reset link.',
        ];

        return $messages[$status] ?? 'If this email exists, we have sent a reset link to it.';
    }
}
