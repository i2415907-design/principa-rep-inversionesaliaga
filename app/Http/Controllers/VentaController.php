<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Cliente;
use App\Models\Pedido;

class VentaController extends Controller
{
public function index()
{
    $ventas = Venta::with([
        'detalles.producto', 
        'cliente',  // Ahora cargará correctamente los clientes
        'usuario'
    ])
    ->orderBy('fecha_venta', 'desc')
    ->get();

    return view('ventasadm.ventasview', compact('ventas'));
}

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'id_producto' => 'required|integer',
                'cantidad' => 'required|integer|min:1',
                'precio_unitario' => 'nullable|numeric|min:0',
                'id_cliente' => 'required|integer'
            ]);

            $producto = Producto::findOrFail($request->id_producto);
            
            // Validar que haya stock suficiente
            if ($producto->stock_producto < $request->cantidad) {
                return redirect()->back()->with('error', 'Stock insuficiente. Stock disponible: ' . $producto->stock_producto . ' unidades.');
            }
            
            // Si no se proporciona precio, usar el precio del producto
            $precioUnitario = $request->precio_unitario ?? $producto->precio_producto;
            $subtotal = $request->cantidad * $precioUnitario;

            // Registrar venta
            $venta = Venta::create([
                'id_cliente' => $request->id_cliente,
                'id_usuario' => Auth::id(),
                'fecha_venta' => now(),
                'total_venta' => $subtotal,
                'tipo' => 'venta'
            ]);

            // Registrar detalle
            DetalleVenta::create([
                'id_venta' => $venta->id_venta,
                'id_producto' => $request->id_producto,
                'cantidad' => $request->cantidad,
                'precio_unitario' => $precioUnitario,
                'subtotal' => $subtotal,
            ]);

            // Actualizar stock
            $producto->stock_producto -= $request->cantidad;
            $producto->save();

            DB::commit();

            return redirect()->back()->with('success', 'Venta registrada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al registrar la venta: ' . $e->getMessage());
        }
        return $this->storeCompleta($request);
    }

    public function storeDevolucion(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $request->validate([
                'id_producto' => 'required|integer',
                'cantidad' => 'required|integer|min:1',
            ]);

            $producto = Producto::findOrFail($request->id_producto);
            
            // Para devoluciones, el precio es 0 y el total es 0
            $precioUnitario = 0;
            $subtotal = 0;

            // Registrar devolución como una venta con tipo "devolucion"
            $venta = Venta::create([
                'id_cliente' => null, // Cliente genérico para devoluciones
                'id_usuario' => Auth::id(),
                'fecha_venta' => now(),
                'total_venta' => $subtotal,
                'tipo' => 'devolucion'
            ]);

            // Registrar detalle de devolución
            DetalleVenta::create([
                'id_venta' => $venta->id_venta,
                'id_producto' => $request->id_producto,
                'cantidad' => $request->cantidad,
                'precio_unitario' => $precioUnitario,
                'subtotal' => $subtotal,
            ]);

            // Actualizar stock (sumar para devoluciones)
            $producto->stock_producto += $request->cantidad;
            $producto->save();

            DB::commit();

            return redirect()->back()->with('success', 'Devolución registrada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al registrar devolución: ' . $e->getMessage());
        }
    }

    /**
     * Obtener datos del producto por ID para autocompletar formulario
     */
    public function obtenerProducto($id)
    {
        try {
            $producto = Producto::findOrFail($id);
            
            return response()->json([
                'success' => true,
                'producto' => [
                    'id' => $producto->id_producto,
                    'nombre' => $producto->nombre_producto,
                    'precio' => $producto->precio_producto,
                    'stock' => $producto->stock_producto,
                    'descripcion' => $producto->descripcion_producto
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado'
            ], 404);
        }
    }

public function simularOnline()
{
    try {
        $productos = Producto::where('estado_producto', 'disponible')
                             ->where('stock_producto', '>', 0)
                             ->get();
        
        // Cargar distritos usando DB::table
        $distritos = DB::table('distrito')->get();
        
        return view('ventasadm.simular-online', compact('productos', 'distritos'));
        
    } catch (\Exception $e) {
        return redirect()->route('admin.pedidos')
                       ->with('error', 'Error al cargar el formulario: ' . $e->getMessage());
    }
}

/**
 * Procesar venta online simulada
 */
/**
 * Procesar venta online simulada
 */
public function procesarVentaOnline(Request $request)
{
    DB::beginTransaction();

    try {
        // 1. Validación (mantener igual)
        $request->validate([
            'doc_ident' => 'required|string',
            'nombre_cliente' => 'required|string',
            'apellido_cliente' => 'required|string',
            'email_cliente' => 'required|email',
            'telefono_cliente' => 'nullable|string',
            'direccion_cliente' => 'nullable|string',
            'referencia_ped' => 'required|string',
            'codigo_postal' => 'nullable|string',
            'id_distrito' => 'required|integer|exists:distrito,id_distrito',
            'productos' => 'required|array|min:1',
            'productos.*.id_producto' => 'required|exists:productos,id_producto',
            'productos.*.cantidad' => 'required|integer|min:1'
        ]);

        // 2. MODIFICACIÓN: Buscar cliente por DNI y ACTUALIZAR sus datos
        $cliente = Cliente::where('doc_ident', $request->doc_ident)->first();
        
        if ($cliente) {
            // Si el cliente ya existe, ACTUALIZAR sus datos con los nuevos
            $cliente->update([
                'nombre_cliente' => $request->nombre_cliente,
                'apellido_cliente' => $request->apellido_cliente,
                'email_cliente' => $request->email_cliente,
                'telefono_cliente' => $request->telefono_cliente,
                'direccion_cliente' => $request->direccion_cliente
            ]);
        } else {
            // Si no existe, crear nuevo cliente
            $cliente = Cliente::create([
                'doc_ident' => $request->doc_ident,
                'nombre_cliente' => $request->nombre_cliente,
                'apellido_cliente' => $request->apellido_cliente,
                'email_cliente' => $request->email_cliente,
                'telefono_cliente' => $request->telefono_cliente,
                'direccion_cliente' => $request->direccion_cliente,
                'fecha_registro' => now()
            ]);
        }

        // El resto del código permanece igual...
        // 3. Obtener costo de envío del distrito
        $distrito = DB::table('distrito')->where('id_distrito', $request->id_distrito)->first();
        $costoEnvio = $request->recojo_tienda ? 0 : $distrito->precio_envio;

        // 4. Calcular total y verificar stock
        $subtotalProductos = 0;
        $detallesVenta = [];

        foreach ($request->productos as $productoData) {
            $producto = Producto::find($productoData['id_producto']);
            
            if ($producto->stock_producto < $productoData['cantidad']) {
                throw new \Exception("Stock insuficiente para: {$producto->nombre_producto}. Stock disponible: {$producto->stock_producto}");
            }

            $subtotal = $producto->precio_producto * $productoData['cantidad'];
            $subtotalProductos += $subtotal;

            $detallesVenta[] = [
                'id_producto' => $producto->id_producto,
                'cantidad' => $productoData['cantidad'],
                'precio_unitario' => $producto->precio_producto,
                'subtotal' => $subtotal
            ];
        }

        // 5. Calcular total final (productos + envío)
        $totalVenta = $subtotalProductos + $costoEnvio;

        // 6. Crear venta
        $venta = Venta::create([
            'id_cliente' => $cliente->id_cliente,
            'id_usuario' => Auth::id(),
            'fecha_venta' => now(),
            'total_venta' => $totalVenta,
            'tipo' => 'venta'
        ]);

        // 7. Crear detalles de venta y actualizar stock
        foreach ($detallesVenta as $detalle) {
            DetalleVenta::create([
                'id_venta' => $venta->id_venta,
                'id_producto' => $detalle['id_producto'],
                'cantidad' => $detalle['cantidad'],
                'precio_unitario' => $detalle['precio_unitario'],
                'subtotal' => $detalle['subtotal']
            ]);

            // Actualizar stock
            $producto = Producto::find($detalle['id_producto']);
            $producto->stock_producto -= $detalle['cantidad'];
            
            if ($producto->stock_producto <= 0) {
                $producto->estado_producto = 'agotado';
            }
            
            $producto->save();
        }

        // 8. Crear pedido con distrito
        $pedido = Pedido::create([
            'id_venta' => $venta->id_venta,
            'estado_pedido' => 'pendiente',
            'total_pedido' => $totalVenta,
            'fecha_pedido' => now(),
            'id_cliente' => $cliente->id_cliente,
            'id_distrito' => $request->id_distrito,
            'referencia_ped' => $request->referencia_ped,
            'codigo_postal' => $request->codigo_postal,
            'recojo_tienda' => $request->recojo_tienda ?? false
        ]);

        DB::commit();

        $mensajeEnvio = $request->recojo_tienda ? "Recojo en tienda" : "Envío a {$distrito->nombre_distr} (S/ {$distrito->precio_envio})";

        return redirect()->route('admin.pedidos')->with('success', 
            "✅ Venta online simulada exitosamente! \n" .
            "• Venta #{$venta->id_venta} creada \n" .
            "• Pedido #{$pedido->id_pedido} generado \n" .
            "• {$mensajeEnvio} \n" .
            "• Stock actualizado correctamente"
        );

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->withErrors('Error al procesar venta online: ' . $e->getMessage())->withInput();
    }
}
public function buscarProductos(Request $request)
{
    try {
        $query = $request->get('q');
        
        $productos = Producto::where('nombre_producto', 'LIKE', "%{$query}%")
                            ->where('estado_producto', 'disponible')
                            ->where('stock_producto', '>', 0)
                            ->limit(10)
                            ->get(['id_producto', 'nombre_producto', 'precio_producto', 'stock_producto']);
        
        return response()->json([
            'success' => true,
            'productos' => $productos
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al buscar productos'
        ]);
    }
}

/**
 * Procesar venta completa (nuevo formulario)
 */
public function storeCompleta(Request $request)
{
    DB::beginTransaction();

    try {
        // Validación mejorada - email opcional
        $request->validate([
            'doc_ident' => 'required|string|size:8',
            'nombre_cliente' => 'required|string|max:100',
            'apellido_cliente' => 'required|string|max:100',
            'email_cliente' => 'nullable|email|max:100', // Cambiado a nullable
            'telefono_cliente' => 'nullable|string|size:9',
            'productos' => 'required|array|min:1',
            'productos.*.id_producto' => 'required|exists:productos,id_producto',
            'productos.*.cantidad' => 'required|integer|min:1'
        ]);

        // Crear o obtener cliente
$cliente = Cliente::where('doc_ident', $request->doc_ident)->first();

if ($cliente) {
    // Actualizar datos existentes
    $cliente->update([
        'nombre_cliente' => $request->nombre_cliente,
        'apellido_cliente' => $request->apellido_cliente,
        'email_cliente' => $request->email_cliente,
        'telefono_cliente' => $request->telefono_cliente
    ]);
} else {
    // Crear nuevo cliente
    $cliente = Cliente::create([
        'doc_ident' => $request->doc_ident,
        'nombre_cliente' => $request->nombre_cliente,
        'apellido_cliente' => $request->apellido_cliente,
        'email_cliente' => $request->email_cliente,
        'telefono_cliente' => $request->telefono_cliente,
        'fecha_registro' => now()
    ]);
}

        // Procesar productos y calcular total
        $totalVenta = 0;
        $detallesVenta = [];

        foreach ($request->productos as $productoData) {
            $producto = Producto::find($productoData['id_producto']);
            
            if ($producto->stock_producto < $productoData['cantidad']) {
                throw new \Exception("Stock insuficiente para: {$producto->nombre_producto}");
            }

            $subtotal = $producto->precio_producto * $productoData['cantidad'];
            $totalVenta += $subtotal;

            $detallesVenta[] = [
                'id_producto' => $producto->id_producto,
                'cantidad' => $productoData['cantidad'],
                'precio_unitario' => $producto->precio_producto,
                'subtotal' => $subtotal
            ];
        }

        // Crear venta
        $venta = Venta::create([
            'id_cliente' => $cliente->id_cliente,
            'id_usuario' => Auth::id(),
            'fecha_venta' => now(),
            'total_venta' => $totalVenta,
            'tipo' => 'venta'
        ]);

        // Crear detalles y actualizar stock
        foreach ($detallesVenta as $detalle) {
            DetalleVenta::create([
                'id_venta' => $venta->id_venta,
                'id_producto' => $detalle['id_producto'],
                'cantidad' => $detalle['cantidad'],
                'precio_unitario' => $detalle['precio_unitario'],
                'subtotal' => $detalle['subtotal']
            ]);

            $producto = Producto::find($detalle['id_producto']);
            $producto->stock_producto -= $detalle['cantidad'];
            
            if ($producto->stock_producto <= 0) {
                $producto->estado_producto = 'agotado';
            }
            
            $producto->save();
        }

        DB::commit();

        // Mensaje de éxito adaptado
        $mensajeCliente = "Cliente: {$request->nombre_cliente} {$request->apellido_cliente}";
        $mensajeEmail = $request->email_cliente ? "• Email: {$request->email_cliente}" : "• Email: No proporcionado";

        return redirect()->route('ventasadm.ventasview')->with('success', 
            "✅ Venta registrada exitosamente!\n" .
            "• {$mensajeCliente}\n" .
            "• DNI: {$request->doc_ident}\n" .
            "{$mensajeEmail}\n" .
            "• Total: S/ {$totalVenta}\n" .
            "• Stock actualizado correctamente"
        );

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->withErrors('Error al registrar venta: ' . $e->getMessage())->withInput();
    }
}


/**
 * Obtener información del cliente por ID
 */
public function obtenerCliente($id)
{
    try {
        $cliente = Cliente::find($id);
        
        if ($cliente) {
            return response()->json([
                'success' => true,
                'cliente' => [
                    'id_cliente' => $cliente->id_cliente,
                    'doc_ident' => $cliente->doc_ident,
                    'nombre_cliente' => $cliente->nombre_cliente,
                    'apellido_cliente' => $cliente->apellido_cliente,
                    'email_cliente' => $cliente->email_cliente,
                    'telefono_cliente' => $cliente->telefono_cliente
                ]
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Cliente no encontrado'
            ], 404);
        }
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al obtener información del cliente'
        ], 500);
    }
}
public function generarBoleta($id)
{
    try {
        // Obtener la venta con relaciones
        $venta = Venta::with(['cliente', 'detalles.producto'])->findOrFail($id);
        
        // Calcular IGV (18%)
        $igvPorcentaje = 0.18;
        
        // Preparar datos para la boleta
        $datosBoleta = [
            'venta' => $venta,
            'fecha_emision' => Carbon::parse($venta->fecha_venta)->format('d/m/Y'),
            'hora_emision' => Carbon::parse($venta->fecha_venta)->format('H:i:s'),
            'numero_boleta' => str_pad($venta->id_venta, 8, '0', STR_PAD_LEFT),
            'igv_porcentaje' => $igvPorcentaje * 100, // 18%
        ];

        // Generar PDF
        $pdf = PDF::loadView('boletas.boleta_venta', $datosBoleta);
        
        return $pdf->download("boleta_venta_{$venta->id_venta}.pdf");

    } catch (\Exception $e) {
        \Log::error('Error generando boleta: ' . $e->getMessage());
        return response()->json(['error' => 'Error al generar la boleta'], 500);
    }
}
public function obtenerDatosBoleta($id)
{
    try {
        $venta = Venta::with(['cliente', 'detalles.producto'])->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'venta' => $venta
        ]);
        
    } catch (\Exception $e) {
        \Log::error('Error obteniendo datos para boleta: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'error' => 'Venta no encontrada'
        ], 404);
    }
}
}
