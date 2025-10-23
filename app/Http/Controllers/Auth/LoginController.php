<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Override login logic to include custom remember and validation logic.
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        $credentials = $request->only($this->username(), 'password');
        $remember = $request->filled('remember');

        if (Auth::attempt(array_merge($credentials, ['deleted_at' => null]), $remember)) {
            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Custom error messages for failed login attempt.
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $email = $request->input($this->username());

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw ValidationException::withMessages([
                $this->username() => ['Format email tidak valid.'],
            ]);
        }

        $userExists = User::where($this->username(), $email)->exists();

        if (!$userExists) {
            throw ValidationException::withMessages([
                $this->username() => ['Email tidak ditemukan.'],
            ]);
        }

        throw ValidationException::withMessages([
            'password' => ['Password tidak sesuai.'],
        ]);
    }

    /**
     * Logout logic.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
