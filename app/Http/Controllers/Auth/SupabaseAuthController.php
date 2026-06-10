<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\SupabaseAuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SupabaseAuthController extends Controller
{
    public function __construct(
        private SupabaseAuthService $authService
    ) {}

    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $user = $this->authService->login($credentials['email'], $credentials['password']);

        if (!$user) {
            return back()->withErrors([
                'email' => 'Credenciales invalidas.',
            ])->onlyInput('email');
        }

        return redirect()->intended(route('dashboard'));
    }

    public function logout(Request $request): RedirectResponse
    {
        $this->authService->logout();
        return redirect()->route('login');
    }

    public function showRegisterForm(): View
    {
        return view('admin.create');
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|min:6',
            'rol' => 'required|in:administrador,director',
        ]);

        $user = $this->authService->register(
            $data['nombre'],
            $data['email'],
            $data['password'],
            $data['rol']
        );

        if (!$user) {
            return back()->withErrors(['email' => 'Error al registrar.'])->onlyInput('email');
        }

        return redirect()->route('dashboard')->with('success', 'Administrador registrado exitosamente.');
    }
}
