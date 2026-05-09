<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DistritoController extends Controller
{
    public function obtenerDistritos()
    {
        $distritos = DB::table('distrito')->select('id_distrito', 'nombre_distr', 'precio_envio')->get();
        return response()->json($distritos);
    }
}
