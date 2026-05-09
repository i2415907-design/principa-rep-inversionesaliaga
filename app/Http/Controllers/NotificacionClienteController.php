<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aviso;

class NotificacionClienteController extends Controller
{
    public function index()
    {
        // Traemos todos los avisos, ordenados de más reciente a más antiguo
        $avisos = Aviso::orderBy('id_aviso', 'desc')->get();

        // Devolvemos la vista con los avisos
        return view('notificaciones.notificliente', compact('avisos'));
    }
}
