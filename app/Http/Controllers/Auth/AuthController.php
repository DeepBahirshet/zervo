<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AuthController extends Controller
{
    public function showLogin(): Response {
        return Inertia::render('Auth/Login');
    }

    public function login(LoginRequest $request) {

        $credentials = $request->only('email', 'password');

        if(!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'Invalid email or password.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->route('requirements.index');
    }

    public function showRegister(): Response {
        return Inertia::render('Auth/Register');
    }

    public function register(RegisterRequest $request) {
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('requirements.index');
    }

    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function profile(Request $request)
    {
        return Inertia::render('Profile/Index', [
            'user' => $request->user(),
        ]);
    }

}
