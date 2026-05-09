<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NotificacionHistorial;
use App\Models\Usuario;
use Illuminate\Http\Request;

class NotificacionController extends Controller
{
    /**
     * Obtener el historial de notificaciones del usuario
     */
    public function index(Request $request)
    {
        // Usamos tu método de buscar por token en la URL
        $token = $request->query('token');
        $usuario = Usuario::where('api_token', $token)->first();

        if (!$usuario) {
            return response()->json(['error' => 'No autorizado'], 401);
        }

        // Jalamos las últimas 30 notificaciones
        $notificaciones = NotificacionHistorial::where('id_usuario', $usuario->id_usuario)
            ->orderBy('fecha', 'desc')
            ->limit(30)
            ->get();

        return response()->json([
            'res' => true,
            'usuario' => $usuario->nombre_usuario,
            'datos' => $notificaciones
        ], 200);
    }

    /**
     * Marcar una notificación como leída
     */
    public function marcarComoLeida(Request $request)
    {
        $id = $request->id_notificacion;
        
        $notificacion = NotificacionHistorial::find($id);
        
        if (!$notificacion) {
            return response()->json(['res' => false, 'mensaje' => 'Notificación no encontrada'], 404);
        }

        $notificacion->update(['leido' => 1]);

        return response()->json([
            'res' => true,
            'mensaje' => 'Marcada como leída'
        ], 200);
    }
}