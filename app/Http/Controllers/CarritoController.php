<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Carrito;
use App\Models\CarritoItem;
use App\Models\Producto;
use Illuminate\Support\Facades\Log;

class CarritoController extends Controller
{
    /**
     * Guardar datos del checkout (productos seleccionados y totales)
     */
    public function guardarCheckout(Request $request)
    {
        $datosCheckout = $request->input();
        session(['checkout_data' => $datosCheckout]);
        
        return response()->json([
            'success' => true, 
            'message' => 'Datos del checkout guardados en sesión'
        ]);
    }

    /**
     * Sincronizar carrito del localStorage con la base de datos
     */
    public function sincronizar(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false, 
                'message' => 'Usuario no autenticado'
            ], 401);
        }

        $carritoLocalStorage = $request->input('carrito', []);
        $userId = Auth::id();

        // Obtener carrito existente en la base de datos
        $carritoDB = Carrito::where('user_id', $userId)->first();
        
        if (!$carritoDB) {
            $carritoDB = Carrito::create([
                'user_id' => $userId,
                'estado' => 'activo'
            ]);
        }

        // Sincronizar productos: crear o actualizar según exista
        foreach ($carritoLocalStorage as $item) {
            CarritoItem::updateOrCreate(
                ['carrito_id' => $carritoDB->id, 'producto_id' => $item['id']],
                ['cantidad' => $item['cantidad'], 'precio' => $item['precio']]
            );
        }

        // Limpiar sesión
        session()->forget('carrito');

        return response()->json([
            'success' => true, 
            'message' => 'Carrito sincronizado correctamente'
        ]);
    }

    /**
     * Fusionar carrito de invitado (localStorage) con el carrito del usuario y devolver resultado
     */
    public function sincronizarPostLogin(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no autenticado'
            ], 401);
        }

        $userId = Auth::id();

        // Carrito del invitado enviado desde el cliente
        $carritoGuest = $request->input('carrito', []);

        // Obtener o crear carrito activo del usuario
        $carritoDB = Carrito::where('user_id', $userId)
            ->where('estado', 'activo')
            ->with('items')
            ->first();

        if (!$carritoDB) {
            $carritoDB = Carrito::create([
                'user_id' => $userId,
                'estado' => 'activo'
            ]);
        }

        // Indexar items actuales por producto_id para fusionar rápido
        $itemsActuales = $carritoDB->items->keyBy('producto_id');

        // Fusionar: sumar cantidades (límite 10), mantener precio del guest si viene, o el existente
        foreach ($carritoGuest as $itemGuest) {
    $productoId = $itemGuest['id'] ?? null;
    if (!$productoId) {
        continue;
    }

    $cantidadGuest = (int) ($itemGuest['cantidad'] ?? 1);
    $precioGuest = $itemGuest['precio'] ?? null;

    // 🔥 VALIDAR STOCK ANTES DE AGREGAR
    $validacionStock = $this->validarStockDisponible($productoId, $cantidadGuest, $carritoDB->id);
    
    if (!$validacionStock['disponible']) {
        // Si no hay stock suficiente, ajustar a lo disponible o saltar
        $cantidadGuest = min($cantidadGuest, $validacionStock['stock_disponible'] ?? 0);
        if ($cantidadGuest <= 0) {
            continue; // Saltar producto si no hay stock
        }
    }

    if (isset($itemsActuales[$productoId])) {
        $item = $itemsActuales[$productoId];
        $nuevaCantidad = min(10, (int) $item->cantidad + $cantidadGuest);
        
        // 🔥 VALIDAR STOCK DE NUEVO PARA LA NUEVA CANTIDAD
        $validacionFinal = $this->validarStockDisponible($productoId, $nuevaCantidad, $carritoDB->id);
        if (!$validacionFinal['disponible']) {
            $nuevaCantidad = min($nuevaCantidad, $validacionFinal['stock_disponible'] ?? $nuevaCantidad);
        }
        
        $item->cantidad = $nuevaCantidad;
        if (!is_null($precioGuest)) {
            $item->precio = $precioGuest;
        }
        $item->save();
    } else {
        CarritoItem::updateOrCreate(
            ['carrito_id' => $carritoDB->id, 'producto_id' => $productoId],
            [
                'cantidad' => min(10, max(1, $cantidadGuest)),
                'precio' => $precioGuest ?? 0,
            ]
        );
    }
}

        // Volver a cargar con relaciones para responder
        $carritoDB->load('items.producto');

        $carritoFormateado = $carritoDB->items->map(function ($item) {
            return [
                'id' => $item->producto_id,
                'nombre' => optional($item->producto)->nombre_producto,
                'descripcion' => optional($item->producto)->descripcion_producto,
                'precio' => $item->precio,
                'imagen' => optional($item->producto)->imagen,
                'cantidad' => $item->cantidad
            ];
        })->values();

        return response()->json([
            'success' => true,
            'carrito' => $carritoFormateado,
            'message' => 'Carrito fusionado correctamente'
        ]);
    }

    /**
     * Obtener carrito del usuario autenticado
     */
    public function obtener(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false, 
                'message' => 'Usuario no autenticado'
            ], 401);
        }

        $userId = Auth::id();
        $carrito = Carrito::where('user_id', $userId)
            ->where('estado', 'activo')
            ->with('items.producto')
            ->first();

        if (!$carrito) {
            return response()->json([
                'success' => true, 
                'carrito' => []
            ]);
        }

$productos = $carrito->items->map(function ($item) {
    return [
        'id' => $item->producto_id,
        'nombre' => optional($item->producto)->nombre_producto ?? 'Producto no disponible',
        'descripcion' => optional($item->producto)->descripcion_producto ?? 'Descripción no disponible',
        'precio' => $item->precio,
        'imagen' => optional($item->producto)->imagen ?? '',
        'cantidad' => $item->cantidad
    ];
});

        return response()->json([
            'success' => true, 
            'carrito' => $productos
        ]);
    }
    /**
 * Eliminar un producto del carrito (BD)
 */
public function eliminarItem($productoId)
{
    try {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no autenticado'
            ], 401);
        }

        $userId = Auth::id();

        // Obtener carrito activo del usuario
        $carrito = Carrito::where('user_id', $userId)
            ->where('estado', 'activo')
            ->first();

        if (!$carrito) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró un carrito activo para el usuario.'
            ], 404);
        }

        // Buscar el item dentro del carrito
        $item = CarritoItem::where('carrito_id', $carrito->id)
            ->where('producto_id', $productoId)
            ->first();

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'El producto no existe en el carrito.'
            ], 404);
        }

        // Eliminar el item
        $item->delete();

        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado correctamente del carrito.'
        ]);

    } catch (\Exception $e) {
        // Capturamos cualquier error inesperado
        return response()->json([
            'success' => false,
            'message' => 'Error al eliminar el producto del carrito.',
            'error' => $e->getMessage()
        ], 500);
    }
}

// En CarritoController.php - agregar este método
private function validarStockDisponible($productoId, $cantidadDeseada, $carritoId = null)
{
    $producto = Producto::find($productoId);
    
    if (!$producto) {
        return [
            'disponible' => false,
            'mensaje' => 'Producto no encontrado'
        ];
    }
    
    // Calcular cantidad ya en el carrito (excluyendo el item actual si se está editando)
    $cantidadEnCarrito = 0;
    if ($carritoId) {
        $cantidadEnCarrito = CarritoItem::where('carrito_id', $carritoId)
            ->where('producto_id', $productoId)
            ->sum('cantidad');
    }
    
    $stockDisponible = $producto->stock_producto - $cantidadEnCarrito;
    
    if ($stockDisponible <= 0) {
        return [
            'disponible' => false,
            'mensaje' => 'Producto agotado'
        ];
    }
    
    if ($cantidadDeseada > $stockDisponible) {
        return [
            'disponible' => false,
            'mensaje' => "Solo hay {$stockDisponible} unidades disponibles",
            'stock_disponible' => $stockDisponible
        ];
    }
    
    return [
        'disponible' => true,
        'stock_disponible' => $stockDisponible
    ];
}
/**
 * Actualizar cantidad de un producto en el carrito
 */
/**
 * Actualizar cantidad de un producto en el carrito - LÓGICA CORREGIDA
 */
public function actualizarCantidad(Request $request, $productoId)
{
    try {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Usuario no autenticado'], 401);
        }

        $request->validate(['cantidad' => 'required|integer|min:1|max:10']);

        $userId = Auth::id();
        $nuevaCantidad = $request->cantidad;

        // Obtener carrito
        $carrito = Carrito::where('user_id', $userId)->where('estado', 'activo')->first();
        if (!$carrito) {
            return response()->json(['success' => false, 'message' => 'Carrito no encontrado'], 404);
        }

        // Buscar item
        $item = CarritoItem::where('carrito_id', $carrito->id)->where('producto_id', $productoId)->first();
        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Producto no en carrito'], 404);
        }

        // 🔥 LÓGICA SUPER SIMPLE: Verificar stock total
        $producto = Producto::find($productoId);
        if (!$producto) {
            return response()->json(['success' => false, 'message' => 'Producto no encontrado'], 404);
        }

        // Solo verificar que la nueva cantidad no exceda el stock total
        if ($nuevaCantidad > $producto->stock_producto) {
            return response()->json([
                'success' => false,
                'message' => "Solo hay {$producto->stock_producto} unidades disponibles",
                'stock_disponible' => $producto->stock_producto
            ], 400);
        }

        // También verificar límite máximo de 10
        if ($nuevaCantidad > 10) {
            return response()->json([
                'success' => false,
                'message' => "No puedes agregar más de 10 unidades del mismo producto"
            ], 400);
        }

        // Actualizar
        $item->cantidad = $nuevaCantidad;
        $item->save();

        return response()->json([
            'success' => true,
            'message' => 'Cantidad actualizada correctamente'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al actualizar la cantidad',
            'error' => $e->getMessage()
        ], 500);
    }
}
// En tu controlador de productos o carrito
public function validarProductosCarrito(Request $request)
{
    $ids = explode(',', $request->get('ids', ''));
    
    // 🔥 CORRECCIÓN: Usar los nombres correctos de los campos
    $productos = Producto::whereIn('id_producto', $ids) // Cambiado a id_producto
        ->select(
            'id_producto as id', 
            'nombre_producto as nombre', 
            'precio_producto as precio', 
            'stock_producto as stock_disponible', 
            'estado_producto as estado'
        )
        ->get()
        ->keyBy('id');
    
    return response()->json([
        'success' => true,
        'productos' => $productos
    ]);
}

// Endpoint adicional para validación completa
public function validarProductoCompleto($id)
{
    $producto = Producto::where('id_producto', $id)->first(); // Cambiado a id_producto
    
    if (!$producto) {
        return response()->json([
            'disponible' => false,
            'mensaje' => 'Producto no encontrado'
        ]);
    }
    
    // 🔥 CORRECCIÓN: Verificar si el estado es "descontinuado"
    $estaDescontinuado = $producto->estado_producto === 'descontinuado';
    
    return response()->json([
        'disponible' => $producto->estado_producto === 'disponible' && !$estaDescontinuado,
        'stock_disponible' => $producto->stock_producto,
        'precio_actual' => $producto->precio_producto,
        'nombre' => $producto->nombre_producto
    ]);
}
}

