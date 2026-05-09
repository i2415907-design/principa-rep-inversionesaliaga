<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateApiKey
{
public function handle(Request $request, Closure $next)
{
    // Buscamos 'token' en la URL (ej: ?token=xyz)
    $token = $request->query('token');

    if (!$token) {
        return response()->json(['error' => 'No se proporcionó un token de acceso.'], 401);
    }

    $usuario = \App\Models\Usuario::where('api_token', $token)->first();

    if (!$usuario) {
        return response()->json(['error' => 'Token inválido o expirado.'], 401);
    }

    // Autenticamos al usuario para la sesión actual
    auth()->login($usuario);

    return $next($request);
}
}