<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = Usuario::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                $user = Usuario::create([
                    'nombre_usuario' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'contrasena' => bcrypt(Str::random(16)),
                    'google_id' => $googleUser->getId(),
                    'activo' => 1,
                    'fecha_registro' => now(),
                    'rol' => 'cliente', // o lo que prefieras por defecto
                ]);
            }

            Auth::login($user);

            return redirect()->route('home');
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Error al iniciar sesión con Google.');
        }
    }
}