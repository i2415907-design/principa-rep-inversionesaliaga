<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aviso;

class AvisoController extends Controller
{
    public function index()
    {
        $avisos = Aviso::orderBy('id_aviso', 'desc')->get();
        // La vista de gestión de avisos ahora está integrada en el perfil admin
        // redirigimos al perfil admin que carga la partial con $avisos
        return redirect()->route('perfiladm.perfildeadmn');
    }

    public function guardar(Request $request)
    {
        try {
            $aviso = new Aviso();
            $aviso->titulo = $request->input('titulo');
            $aviso->mensaje = $request->input('mensaje');
            $aviso->tipo = $request->input('tipo');
            $aviso->fecha_publicacion = now();
            $aviso->save();

            return redirect()->route('perfiladm.perfildeadmn')->with('status', '✅ Aviso registrado correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', '❌ Error al registrar el aviso: ' . $e->getMessage());
        }
    }

    public function eliminar($id)
    {
        $aviso = Aviso::find($id);

        if ($aviso) {
            $aviso->delete();
            return redirect()->route('perfiladm.perfildeadmn')->with('status', '🗑️ Aviso eliminado.');
        }

    return redirect()->route('perfiladm.perfildeadmn')->with('error', '⚠️ El aviso no existe.');
    }
}
