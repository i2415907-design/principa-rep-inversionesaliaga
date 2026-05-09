<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaginaController extends Controller
{
    public function nosotros()
    {
        return view('partials.inicioprincipal.nosotros');
    }
    
    public function catalogo()
    {
        return view('partials.inicioprincipal.catalogo');
    }
}