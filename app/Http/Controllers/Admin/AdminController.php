<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Categoria;

class AdminController extends Controller
{
public function index()
{
    $usuario = \Illuminate\Support\Facades\Auth::user();
    
    if (!in_array($usuario->rol, ['admin', 'gerente', 'vendedor', 'cajero'])) {
        abort(403, 'Acceso no autorizado');
    }

    return view('admindashboard.addashboardprincipal');
}
    public function productos() {
        $productos = Producto::with('categoria')->get();
        $categorias = Categoria::all();
        // obtener todos los productos de la BD
        return view('productosadm.productosview', compact('productos', 'categorias')); // pasarlo a la vista
    }


    public function ventas() {
        return view('ventasadm.ventasview');
    }

    public function reportes() {
        return view('reportesadm.reportesview');
    }

    public function ingresosEgresos() {
        return view('inegresos.inegresos');
    }
    
    public function productoedit() {
        $productos = Producto::with('categoria')->get();
        $categorias = Categoria::all();
        return view('productosadm.productosview', compact('productos', 'categorias'));
    }
        public function store(Request $request)
    {
        $request->validate([
            'nombre_producto' => 'required|string|max:255',
            'descripcion_producto' => 'nullable|string|max:500',
            'precio_producto' => 'required|numeric',
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

        if ($request->hasFile('imagen')) {
            $producto->imagen = $request->file('imagen')->store('productos', 'public');
        }

        $producto->save();

        return redirect()->back()->with('success', 'Producto añadido exitosamente');
    }
}

