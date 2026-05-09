<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/login'); // si no está logueado
        }

        // si el rol del usuario no está dentro de los permitidos
        if (!in_array(Auth::user()->rol, $roles)) {
            abort(403, 'No tienes permisos para acceder a esta sección');
        }

        return $next($request);
    }

}
