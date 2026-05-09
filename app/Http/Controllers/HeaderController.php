<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Aviso;
use App\Models\Usuario;

class HeaderController extends Controller
{
    public function perfil()
    {
        $usuario = Auth::user();
        $usuarios = Usuario::all();
        $avisos = Aviso::orderBy('id_aviso', 'desc')->get(); // aseguramos que exista

        // Devolver la vista padre para que los includes y layout se mantengan
        return view('perfiladm.perfildeadmn', compact('usuario', 'usuarios', 'avisos'));
    }

    public function pedidos()
    {
        return view('pedidos.pedidosadm');
    }

    public function notificaciones()
    {
        $avisos = Aviso::orderBy('id_aviso', 'desc')->get();
        return view('notifiadm.notificacionadm', compact('avisos'));
    }
}
