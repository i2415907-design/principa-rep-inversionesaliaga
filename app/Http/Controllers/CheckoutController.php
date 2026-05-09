<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Pedido;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    public function index()
    {
        $checkoutData = session('checkout_data', []);
        
        if (empty($checkoutData) || empty($checkoutData['productos'])) {
            return redirect()->route('carrito.carritocliente')->with('mensaje', 'No hay productos seleccionados para el checkout.');
        }
        
        return view('checkout.checkoutcl', compact('checkoutData'));
    }

    public function procesarCompra(Request $request)
    {
        try {
            // Validación completa de datos
            $validator = Validator::make($request->all(), [
                'nombres' => 'required|string|max:100|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
                'apellidos' => 'required|string|max:100|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
                'dni' => 'required|digits:8|numeric',
                'cel' => 'required|digits:9|numeric',
                'correo_alt' => 'nullable|email|max:100',
                'codigo_postal' => $request->recojo_tienda ? 'nullable' : 'required|digits:5|numeric',
                'ubicacion' => $request->recojo_tienda ? 'nullable' : 'required|string|max:255',
                'referencias' => $request->recojo_tienda ? 'nullable' : 'required|string|max:500',
                'metodo_pago' => 'required|in:yape,plin',
                'recojo_tienda' => 'required|boolean',
            ], [
                'nombres.required' => 'El campo nombres es obligatorio.',
                'nombres.regex' => 'Los nombres solo pueden contener letras y espacios.',
                'apellidos.required' => 'El campo apellidos es obligatorio.',
                'apellidos.regex' => 'Los apellidos solo pueden contener letras y espacios.',
                'dni.required' => 'El DNI es obligatorio.',
                'dni.digits' => 'El DNI debe tener exactamente 8 digitos.',
                'dni.numeric' => 'El DNI solo puede contener numeros.',
                'cel.required' => 'El celular es obligatorio.',
                'cel.digits' => 'El celular debe tener exactamente 9 digitos.',
                'cel.numeric' => 'El celular solo puede contener numeros.',
                'correo_alt.email' => 'El correo alternativo debe ser una direccion valida.',
                'codigo_postal.required' => 'El codigo postal es obligatorio para envios.',
                'codigo_postal.digits' => 'El codigo postal debe tener 5 digitos.',
                'ubicacion.required' => 'La ubicacion es obligatoria para envios.',
                'referencias.required' => 'Las referencias son obligatorias para envios.',
                'metodo_pago.required' => 'Debes seleccionar un metodo de pago.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            
            $usuarioAutenticado = auth()->user();
            $usuarioId = $usuarioAutenticado ? $usuarioAutenticado->id_usuario : null;
            
            // Guardar cliente en la base de datos
            $cliente = Cliente::create([
                'doc_ident' => $request->dni,
                'nombre_cliente' => $request->nombres,
                'apellido_cliente' => $request->apellidos,
                'email_cliente' => $request->correo_alt,
                'telefono_cliente' => $request->cel,
                'direccion_cliente' => $request->recojo_tienda ? 'RECOJO EN TIENDA' : $request->ubicacion,
                'fecha_registro' => now(),
            ]);

            // Guardar datos en sesión para el PagoController
            session([
                'cliente_validado' => true,
                'cliente_id' => $cliente->id_cliente,
                'usuario_id' => $usuarioId, // 🔥 ESTA ES LA CLAVE
                'datos_pago' => [
                    'nombres' => $request->nombres,
                    'apellidos' => $request->apellidos,
                    'dni' => $request->dni,
                    'cel' => $request->cel,
                    'correo_alt' => $request->correo_alt,
                    'codigo_postal' => $request->codigo_postal,
                    'ubicacion' => $request->ubicacion,
                    'referencias' => $request->referencias,
                    'metodo_pago' => $request->metodo_pago,
                    'recojo_tienda' => $request->recojo_tienda,
                ]
            ]);

            // Retornar JSON para el JavaScript
            return response()->json([
                'success' => true,
                'message' => 'Cliente registrado exitosamente',
                'cliente_id' => $cliente->id_cliente
            ]);

        } catch (\Exception $e) {
            \Log::error('Error en procesarCompra: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la compra: ' . $e->getMessage()
            ], 500);
        }
    }

    public function procesarPago(Request $request)
    {
        return view('checkout.checkoutpagos');
    }
}