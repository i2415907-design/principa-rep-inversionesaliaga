<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Mostrar la página principal con productos de venta
     */
    public function index()
    {
        // Obtener todos los productos de forma aleatoria
        $productos = Producto::with('categoria')->inRandomOrder()->get();
        $categorias = Categoria::all();
        
        // Agrupar productos por categoría
        $productosPorCategoria = $productos->groupBy('id_categoria');
        
        // Debug: mostrar información en logs
        Log::info('Productos encontrados: ' . $productos->count());
        foreach($productos as $producto) {
            Log::info("Producto: {$producto->nombre_producto}, Estado: {$producto->estado_producto}, Stock: {$producto->stock_producto}");
        }
        
        return view('home', compact('productos', 'productosPorCategoria', 'categorias'));
    }
}
