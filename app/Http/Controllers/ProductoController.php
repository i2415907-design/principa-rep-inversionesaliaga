<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    // Mostrar lista de productos (PANEL ADMIN - muestra TODOS incluyendo descontinuados)
    public function index()
    {
        $productos = Producto::with('categoria')->get();
        $categorias = Categoria::all();

        return view('productos.index', compact('productos', 'categorias'));
    }

    // Guardar nuevo producto
    public function store(Request $request)
    {
        $request->validate([
            'nombre_producto' => 'required|string|max:255',
            'descripcion_producto' => 'nullable|string|max:500',
            'precio_producto' => 'required|numeric|min:0.01',
            'stock_producto' => 'required|integer|min:0',
            'id_categoria' => 'required|exists:categorias,id_categoria',
            'marca' => 'nullable|string|max:255',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        $producto = new Producto();
        $producto->nombre_producto = $request->nombre_producto;
        $producto->descripcion_producto = $request->descripcion_producto;
        $producto->precio_producto = $request->precio_producto;
        $producto->stock_producto = $request->stock_producto;
        $producto->id_categoria = $request->id_categoria;
        $producto->marca = $request->marca;
        
    
        // Asignar estado según stock
        $producto->estado_producto = ($producto->stock_producto > 0)
            ? 'disponible'
            : 'agotado';
    
        if ($request->hasFile('imagen')) {
            $producto->imagen = $request->file('imagen')->store('productos', 'public');
        }
    
        $producto->save();
    
        return redirect()->back()->with('success', 'Producto añadido exitosamente');
    }
    
    // Actualizar producto
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_producto' => 'required|string|max:255',
            'descripcion_producto' => 'nullable|string|max:500',
            'precio_producto' => 'required|numeric|min:0.01',
            'stock_producto' => 'required|integer|min:0',
            'id_categoria' => 'required|exists:categorias,id_categoria',
            'marca' => 'nullable|string|max:255',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        $producto = Producto::findOrFail($id);
    
        $producto->nombre_producto = $request->nombre_producto;
        $producto->descripcion_producto = $request->descripcion_producto;
        $producto->precio_producto = $request->precio_producto;
        $producto->stock_producto = $request->stock_producto;
        $producto->id_categoria = $request->id_categoria;
        $producto->marca = $request->marca;
    
        // Actualizar estado según stock (solo si no está descontinuado)
        if ($producto->estado_producto !== 'descontinuado') {
            $producto->estado_producto = ($producto->stock_producto > 0)
                ? 'disponible'
                : 'agotado';
        }
    
        if ($request->hasFile('imagen')) {
            if ($producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
                Storage::disk('public')->delete($producto->imagen);
            }
            $producto->imagen = $request->file('imagen')->store('productos', 'public');
        }
    
        $producto->save();
    
        return redirect()->back()->with('success', 'Producto actualizado exitosamente');
    }

    // Eliminar producto
    public function destroy($id)
    {
        try {
            $producto = Producto::findOrFail($id);

            // Si el producto está en ventas, solo se marca como descontinuado
            $tieneVentas = \App\Models\DetalleVenta::where('id_producto', $id)->exists();

            if ($tieneVentas) {
                $producto->estado_producto = 'descontinuado';
                $producto->save();
                return redirect()->back()->with('success', 'Producto marcado como descontinuado (no se puede eliminar porque ya fue vendido).');
            }

            // Si no tiene ventas, se puede eliminar físicamente
            $producto->delete();
            return redirect()->back()->with('success', 'Producto eliminado correctamente.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar el producto: ' . $e->getMessage());
        }
    }

    // 🔥 SOLUCIÓN: ACTUALIZAR MÉTODO FILTRAR para excluir productos descontinuados
    public function filtrar(Request $request)
    {
        // SOLUCIÓN: Filtrar productos que NO estén descontinuados
        $query = Producto::with('categoria')
            ->where('estado_producto', '!=', 'descontinuado');

        // Filtrar por búsqueda
        if ($request->has('buscar') && $request->buscar != '') {
            $query->where('nombre_producto', 'like', '%' . $request->buscar . '%');
        }

        // Filtrar por categoría
        if ($request->has('categoria') && $request->categoria != '') {
            $query->where('id_categoria', $request->categoria);
        }

        // Filtrar por rango de precios
        if ($request->has('precio') && $request->precio != '') {
            switch ($request->precio) {
                case '1':
                    $query->where('precio_producto', '<', 100);
                    break;
                case '2':
                    $query->whereBetween('precio_producto', [100, 500]);
                    break;
                case '3':
                    $query->whereBetween('precio_producto', [500, 1000]);
                    break;
                case '4':
                    $query->where('precio_producto', '>', 1000);
                    break;
            }
        }

        // Aplicar ordenamiento aleatorio
        $productos = $query->inRandomOrder()->get();

        return response()->json(['productos' => $productos]);
    }

    public function reactivar($id)
    {
        try {
            $producto = Producto::findOrFail($id);

            if ($producto->estado_producto !== 'descontinuado') {
                return redirect()->back()->with('info', 'Este producto no está descontinuado.');
            }

            // Verificamos si hay stock, para decidir el nuevo estado
            $producto->estado_producto = $producto->stock_producto > 0
                ? 'disponible'
                : 'agotado';

            $producto->save();

            return redirect()->back()->with('success', 'Producto reactivado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al reactivar el producto: ' . $e->getMessage());
        }
    }

    
}