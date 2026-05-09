<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
    // Guardar la URL anterior para redirección después del login
    session(['url.intended' => url()->previous()]);
    return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();

    $usuario = \Illuminate\Support\Facades\Auth::user();

    $request->session()->regenerate();

    // 1. Verifica que exista
    if (!$usuario) {
        return redirect()->route('login')->withErrors(['email' => 'Error al iniciar sesión.']);
    }

    // 2. Verifica si está activo
    if (!$usuario->activo) {
        Auth::logout();
        return redirect()->route('login')->withErrors(['email' => 'Usuario deshabilitado.']);
    }

    // 3. Validación por rol + correo autorizado
    $correosPermitidos = [
        'cajero' => ['cajero1inversiones@ialiaga.com', 'cajera2inversiones@ialiaga.com'],
        'vendedor' => ['ventas1inversiones@ialiaga.com', 'ventas2inversiones@ialiaga.com', 'ventas3inversiones@ialiga.com'],
        'gerente' => ['gerentegeninversiones@ialaiga.com'],
        'admin' => ['admin@empresa.com'], // único permitido
    ];

    if (in_array($usuario->rol, ['cajero', 'vendedor', 'gerente', 'admin'])) {
        if (!isset($correosPermitidos[$usuario->rol]) || !in_array($usuario->email, $correosPermitidos[$usuario->rol])) {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Correo no autorizado para el rol: ' . $usuario->rol
            ]);
        }

        return redirect()->route('admin.dashboard');
    }

    // 4. Rol cliente o cualquier otro
    if ($usuario->rol === 'cliente') {
        // Redirige a la última página visitada o al home
        return redirect()->intended(route('home'));
    }

    // 5. Si no entra en ningún caso
    Auth::logout();
    return redirect()->route('login')->withErrors(['email' => 'Rol no válido.']);
}



    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // Agregar script para limpiar localStorage del carrito
        $request->session()->flash('limpiar_carrito', true);

        return redirect('/');
    }
}
