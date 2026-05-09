<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:usuarios'],
            'password' => [
                'required',
                'string',
                'min:8', // mínimo 8 caracteres
                'regex:/[A-Z]/', // al menos una letra mayúscula
                'regex:/[0-9]/', // al menos un número
                'regex:/[@$!%*?&]/', // al menos un carácter especial
                'confirmed' // password_confirmation
            ],
        ], [
            'email.unique' => 'Este correo ya está registrado. Intenta con otro.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.regex' => 'La contraseña debe incluir al menos una letra mayúscula, un número y un carácter especial.',
         'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        $usuario = Usuario::create([
            'nombre_usuario' => $request->name,
            'email' => $request->email,
            'contrasena' => Hash::make($request->password),
            'rol' => 'cliente',
        ]);

        event(new Registered($usuario));

        Auth::login($usuario);

        return redirect()->intended();
    }
}
