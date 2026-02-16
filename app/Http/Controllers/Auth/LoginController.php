<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\VerifyOtpRequest;
use App\Mail\LoginOtpMail;
use App\Models\LoginOtp;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class LoginController extends Controller
{
    private const OTP_TTL_MINUTES = 10;

    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        if (! Auth::guard('web')->attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            return back()->withErrors(['email' => __('auth.failed')])->onlyInput('email');
        }

        $email = $request->validated('email');
        $otpCode = (string) random_int(100000, 999999);

        LoginOtp::create([
            'email' => $email,
            'otp' => $otpCode,
            'expires_at' => now()->addMinutes(self::OTP_TTL_MINUTES),
        ]);

        Mail::to($email)->send(new LoginOtpMail($otpCode, $email));

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->put('otp_email', $email);
        $request->session()->put('otp_remember', $request->boolean('remember'));

        return redirect()
            ->route('verify-otp')
            ->with('status', 'A 6-digit verification code has been sent to your email.')
            ->with('otp_display', $otpCode);
    }

    public function showVerifyOtpForm(Request $request): View
    {
        return view('auth.verify-otp', [
            'pendingVerification' => $request->session()->has('otp_email'),
            'otpDisplay' => $request->session()->get('otp_display'),
        ]);
    }

    public function verifyOtp(VerifyOtpRequest $request): RedirectResponse
    {
        $email = $request->session()->get('otp_email');
        if (! $email) {
            return redirect()->route('login')->withErrors(['email' => 'Session expired. Please log in again.']);
        }

        $loginOtp = LoginOtp::query()
            ->where('email', $email)
            ->valid()
            ->where('otp', $request->validated('otp'))
            ->first();

        if (! $loginOtp) {
            return back()->withErrors(['otp' => 'Invalid or expired verification code.'])->withInput();
        }

        $loginOtp->markAsUsed();
        $remember = $request->session()->get('otp_remember', false);
        $request->session()->forget(['otp_email', 'otp_remember']);

        $user = User::where('email', $email)->firstOrFail();
        Auth::guard('web')->login($user, $remember);
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
