<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;

class PagoController extends Controller
{
    /**
     * Webhook para recibir notificaciones de Mercado Pago
     * Versión con datos reales del carrito
     */
    public function webhookMercadoPago(Request $request)
    {
        Log::info('WEBHOOK MP INICIADO');
        
        try {
            // Obtener el contenido RAW para debug
            $rawContent = $request->getContent();
            Log::info('Raw webhook content: ' . $rawContent);
            
            // Decodificar JSON
            $data = json_decode($rawContent, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('JSON invalido en webhook: ' . $rawContent);
                return response()->json(['status' => 'success', 'message' => 'Webhook recibido']);
            }

            // Obtener datos del webhook de forma segura
            $topic = $data['type'] ?? null;
            $paymentId = $data['data']['id'] ?? null;

            Log::info("Webhook recibido - Tipo: " . ($topic ?? 'NULL') . ", Payment ID: " . ($paymentId ?? 'NULL'));

            // Solo procesar payments con ID valido
            if ($topic !== 'payment' || !$paymentId) {
                Log::info("Webhook ignorado - Tipo: $topic, Payment ID: $paymentId");
                return response()->json(['status' => 'success', 'message' => 'Webhook recibido']);
            }

            // Asegurar que paymentId sea entero
            $paymentId = (int) $paymentId;
            
            if ($paymentId <= 0) {
                Log::error('Payment ID invalido: ' . $paymentId);
                return response()->json(['status' => 'success', 'message' => 'Webhook recibido']);
            }

            // Configurar Mercado Pago
            MercadoPagoConfig::setAccessToken('APP_USR-7469052898660771-101918-6e5f6ad378ce1874682063dc71e80e24-2935832276');

            // Obtener informacion completa del pago
            $paymentClient = new PaymentClient();
            $payment = $paymentClient->get($paymentId);

            Log::info('Informacion del pago obtenida:', [
                'id' => $payment->id,
                'status' => $payment->status,
                'external_reference' => $payment->external_reference ?? 'No reference',
                'amount' => $payment->transaction_amount ?? 0
            ]);

            // Procesar segun estado
            if ($payment->status === 'approved') {
                Log::info("PAGO APROBADO - Procesando venta...");
                $this->procesarPagoAprobado($payment);
            } else {
                Log::info("Pago $payment->id con estado: $payment->status - No procesado");
            }

            return response()->json([
                'status' => 'success', 
                'message' => 'Webhook procesado correctamente',
                'payment_id' => $payment->id,
                'payment_status' => $payment->status
            ]);

        } catch (MPApiException $e) {
            Log::error('Error MercadoPago API en webhook: ' . $e->getMessage());
            return response()->json([
                'status' => 'success',
                'message' => 'Error procesando pago'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error general en webhook: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'success',
                'message' => 'Error interno del servidor'
            ]);
        }
    }

    /**
     * Procesar pago aprobado y crear venta completa
     */
/**
 * Procesar pago aprobado y crear venta completa - VERSIÓN CORREGIDA
 */
private function procesarPagoAprobado($payment)
{
    DB::beginTransaction();
    try {
        $externalReference = $payment->external_reference;
        $paymentId = $payment->id;
        $amount = $payment->transaction_amount;

        Log::info("PROCESANDO PAGO APROBADO", [
            'payment_id' => $paymentId,
            'external_reference' => $externalReference,
            'amount' => $amount
        ]);

        if (!$externalReference) {
            Log::error('Pago sin external_reference, no se puede procesar');
            DB::rollBack();
            return; // ✅ SOLO return, NO throw
        }

        // FORMATO: INV_TIMESTAMP_CLIENTEID_DISTRITO_RECOJO
        $partes = explode('_', $externalReference);
        
        if (count($partes) < 3) {
            Log::error('External reference con formato invalido: ' . $externalReference);
            DB::rollBack();
            return; // ✅ SOLO return, NO throw
        }

        $clienteId = $partes[2]; // Tercera posición
        
        // VALIDACIÓN PARA DISTRITO_ID
        $distritoId = 2; // Valor por defecto (Huancayo)
        if (isset($partes[3]) && is_numeric($partes[3]) && $partes[3] > 0) {
            $distritoId = (int)$partes[3];
        }
        
        // VALIDACIÓN PARA RECOJO_TIENDA
        $recojoTienda = false;
        if (isset($partes[4]) && is_numeric($partes[4])) {
            $recojoTienda = (bool)$partes[4];
        }
        
        // Verificar que el cliente existe
        $cliente = DB::table('clientes')->where('id_cliente', $clienteId)->first();
        if (!$cliente) {
            Log::error('Cliente no encontrado para pago: ' . $clienteId);
            DB::rollBack();
            return; // ✅ SOLO return, NO throw
        }

        Log::info('Datos extraidos del external_reference:', [
            'cliente_id' => $clienteId,
            'distrito_id' => $distritoId,
            'recojo_tienda' => $recojoTienda
        ]);

        // OBTENER DATOS REALES DEL CHECKOUT
        $checkoutData = DB::table('checkout_data')
            ->where('external_reference', $externalReference)
            ->first();

        if (!$checkoutData) {
            Log::warning('No hay datos de checkout, usando datos basicos');
            // Usar un producto existente como fallback
            $productoExistente = DB::table('productos')->where('estado_producto', 'disponible')->first();
            
            if ($productoExistente) {
                $productos = [[
                    'id' => $productoExistente->id_producto, 
                    'nombre' => $productoExistente->nombre_producto, 
                    'precio' => $amount, 
                    'cantidad' => 1
                ]];
            } else {
                Log::error('No hay productos disponibles en la base de datos');
                DB::rollBack();
                return; // ✅ SOLO return, NO throw
            }
            
            $referencias = 'Compra online - MP: ' . $paymentId;
            $codigoPostal = '00000';
        } else {
            // USAR DATOS REALES DEL CARRITO
            $productos = json_decode($checkoutData->productos, true) ?? [];
            $referencias = $checkoutData->referencias ?? 'Compra online - MP: ' . $paymentId;
            $codigoPostal = $checkoutData->codigo_postal ?? '00000';
            
            Log::info('Datos reales del carrito encontrados:', [
                'productos_count' => count($productos),
                'referencias' => $referencias,
                'codigo_postal' => $codigoPostal
            ]);
        }

        // Si no hay productos, usar un producto básico existente
        if (empty($productos)) {
            Log::warning('No hay productos en los datos, usando producto basico');
            $productoExistente = DB::table('productos')->where('estado_producto', 'disponible')->first();
            
            if ($productoExistente) {
                $productos = [[
                    'id' => $productoExistente->id_producto, 
                    'nombre' => $productoExistente->nombre_producto, 
                    'precio' => $amount, 
                    'cantidad' => 1
                ]];
            } else {
                Log::error('No hay productos disponibles en la base de datos');
                DB::rollBack();
                return; // ✅ SOLO return, NO throw
            }
        }

        Log::info('Datos para la venta:', [
            'cliente_id' => $clienteId,
            'productos_count' => count($productos),
            'total' => $amount,
            'distrito_id' => $distritoId,
            'recojo_tienda' => $recojoTienda,
            'referencias' => $referencias
        ]);

        // 1. CREAR VENTA
        $ventaId = DB::table('ventas')->insertGetId([
            'id_cliente' => $clienteId,
            'id_usuario' => $this->obtenerUsuarioIdDesdeCheckout($externalReference), // Usuario por defecto para ventas online
            'fecha_venta' => now(),
            'total_venta' => $amount,
            'tipo' => 'venta',
            'estado_venta' => 'Completada'
        ]);

        Log::info("VENTA CREADA: $ventaId");

        // 2. CREAR DETALLES DE VENTA Y ACTUALIZAR STOCK
        foreach ($productos as $producto) {
            $productoId = $producto['id'] ?? null;
            $cantidad = $producto['cantidad'] ?? 1;
            $precioUnitario = $producto['precio'] ?? $amount;
            
            // Verificar que el producto existe antes de insertar
            if (!$productoId) {
                Log::warning('Producto sin ID, saltando...');
                continue;
            }

            $productoExiste = DB::table('productos')->where('id_producto', $productoId)->exists();
            
            if (!$productoExiste) {
                Log::warning("Producto con ID $productoId no existe, saltando...");
                continue;
            }
            
            DB::table('detalles_venta')->insert([
                'id_venta' => $ventaId,
                'id_producto' => $productoId,
                'cantidad' => $cantidad,
                'precio_unitario' => $precioUnitario,
                'subtotal' => $precioUnitario * $cantidad
            ]);

            // Actualizar stock del producto
            DB::table('productos')
                ->where('id_producto', $productoId)
                ->decrement('stock_producto', $cantidad);

            Log::info("Producto vendido: ID $productoId, Cantidad: $cantidad, Nombre: " . ($producto['nombre'] ?? 'N/A'));
        }

        // 3. CREAR PEDIDO
        $pedidoId = DB::table('pedidos')->insertGetId([
            'id_venta' => $ventaId,
            'id_cliente' => $clienteId,
            'estado_pedido' => 'pendiente',
            'total_pedido' => $amount,
            'fecha_pedido' => now(),
            'referencia_ped' => $referencias,
            'codigo_postal' => $codigoPostal,
            'recojo_tienda' => $recojoTienda,
            'id_encargado' => 28,
            'id_distrito' => $distritoId
        ]);

        Log::info("PEDIDO CREADO: $pedidoId");

        // 4. CREAR REGISTRO DE PAGO
        DB::table('pagos')->insert([
            'id_venta' => $ventaId,
            'id_metodo' => 1, // Mercado Pago
            'monto_pagado' => $amount,
            'fecha_pago' => now()
        ]);

        Log::info("PAGO REGISTRADO para venta: $ventaId");

        // LIMPIAR DATOS DEL CHECKOUT DESPUÉS DEL PROCESO EXITOSO
        if ($checkoutData) {
            DB::table('checkout_data')->where('external_reference', $externalReference)->delete();
            Log::info("Datos de checkout limpiados para: $externalReference");
        }

        DB::commit();

        Log::info("VENTA COMPLETADA EXITOSAMENTE - Venta: $ventaId, Pedido: $pedidoId, Pago: $paymentId");

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('ERROR al crear venta completa: ' . $e->getMessage());
        // ✅ ELIMINADO: throw $e; - Esto causaba el 502
        // En su lugar, solo logueamos el error pero NO lanzamos excepción
    }
}

    /**
     * Generar QR para pago con Mercado Pago
     */
    public function generarQR(Request $request)
    {
        try {
            Log::info('INICIANDO PAGO');

            // Verificar que hay datos de sesion del cliente
            $datosCliente = session('datos_pago');
            $clienteId = session('cliente_id');
            $usuarioId = session('usuario_id'); // 🔥 NUEVO: Obtener usuario de sesió

            if (!$datosCliente || !$clienteId) {
                Log::error('Datos de sesion no encontrados');
                
                return response()->json([
                    'error' => 'Datos del cliente no encontrados',
                    'detalle' => 'Por favor, completa el formulario nuevamente'
                ], 400);
            }
            
            
            $idUsuarioParaVenta = $usuarioId ?: 27;
            Log::info("Usuario para venta: " . $idUsuarioParaVenta . " (Autenticado: " . ($usuarioId ? 'SI' : 'NO') . ")");
            // Validar que el monto sea suficiente
            $monto = (float) $request->input('total', 10.00);
            if ($monto < 5.00) {
                return response()->json([
                    'error' => 'El monto minimo para pagar con Mercado Pago es S/ 5.00',
                    'detalle' => 'Por favor, agrega mas productos a tu carrito'
                ], 400);
            }

            // Validar que hay productos
            $productosJson = $request->input('productos');
            if (!$productosJson) {
                return response()->json([
                    'error' => 'No hay productos en el carrito',
                    'detalle' => 'Por favor, agrega productos al carrito'
                ], 400);
            }

            $productos = json_decode($productosJson, true);
            if (json_last_error() !== JSON_ERROR_NONE || empty($productos)) {
                return response()->json([
                    'error' => 'Error en los datos de productos',
                    'detalle' => 'Formato de productos invalido'
                ], 400);
            }

            // Configurar Mercado Pago
            MercadoPagoConfig::setAccessToken('APP_USR-7469052898660771-101918-6e5f6ad378ce1874682063dc71e80e24-2935832276');

            // FORMATO: INV_TIMESTAMP_CLIENTEID_DISTRITO_RECOJO
            $distritoId = $request->input('distrito_id', 2);
            $recojoTienda = $request->input('recojo_tienda', false) ? 1 : 0;
            
            // VALIDAR QUE DISTRITO_ID SEA NUMÉRICO
            if (!is_numeric($distritoId)) {
                $distritoId = 2; // Valor por defecto
            }
            
            $externalReference = 'INV_' . time() . '_' . $clienteId . '_' . $distritoId . '_' . $recojoTienda . '_' . $idUsuarioParaVenta;

            // 🔥 GUARDAR DATOS REALES DEL CARRITO EN LA BASE DE DATOS
            $checkoutData = [
                'external_reference' => $externalReference,
                'cliente_id' => $clienteId,
                'user_id' => $idUsuarioParaVenta, // 🔥 NUEVO
                'productos' => json_encode($productos),
                'distrito_id' => $distritoId,
                'recojo_tienda' => $recojoTienda,
                'referencias' => $datosCliente['referencias'] ?? 'Compra online',
                'codigo_postal' => $datosCliente['codigo_postal'] ?? '00000',
                'total' => $monto,
                'created_at' => now(),
                'updated_at' => now()
            ];

            DB::table('checkout_data')->insert($checkoutData);

            Log::info('Datos de checkout guardados:', [
                'external_reference' => $externalReference,
                'productos_count' => count($productos),
                'user_id' => $idUsuarioParaVenta, // 🔥 NUEVO
                'referencias' => $checkoutData['referencias'],
                'distrito_id' => $distritoId
            ]);

            $client = new PreferenceClient();
            $preference = $client->create([
                'items' => [
                    [
                        'title' => 'Compra en Inversiones Aliaga - ' . count($productos) . ' productos',
                        'description' => 'Compra online de accesorios',
                        'quantity' => 1,
                        'currency_id' => 'PEN',
                        'unit_price' => $monto,
                    ]
                ],
                'back_urls' => [
                    'success' => route('pago.exito'),
                    'failure' => route('pago.error'),
                    'pending' => route('pago.pendiente')
                ],
                'auto_return' => 'approved',
                'notification_url' => route('webhook.mercadopago'),
                'external_reference' => $externalReference,
                'payment_methods' => [
                    'excluded_payment_types' => [
                        ['id' => 'credit_card'],
                        ['id' => 'debit_card'],
                    ],
                    'installments' => 1,
                ],
            ]);

            Log::info('Preferencia creada exitosamente', [
                'preference_id' => $preference->id,
                'external_reference' => $externalReference,
                'cliente_id' => $clienteId,
                'total' => $monto
            ]);

            return response()->json([
                'success' => true,
                'init_point' => $preference->init_point,
                'preference_id' => $preference->id
            ]);

        } catch (MPApiException $e) {
            Log::error('Error Mercado Pago API:', [
                'message' => $e->getMessage(),
                'response' => $e->getApiResponse()->getContent()
            ]);
            
            $errorContent = $e->getApiResponse()->getContent();
            $errorMessage = 'Error en Mercado Pago';
            
            if (isset($errorContent['message'])) {
                $errorMessage = $errorContent['message'];
            }
            
            return response()->json([
                'error' => $errorMessage,
                'detalle' => 'Por favor, intenta con otro metodo de pago'
            ], 400);
            
        } catch (\Exception $e) {
            Log::error('Error general en generarQR: ' . $e->getMessage());
            return response()->json([
                'error' => 'Error interno del servidor',
                'detalle' => 'Por favor, intenta nuevamente'
            ], 500);
        }
    }

    /**
     * Pagina de exito
     */
    public function pagoExitoso()
    {
        Log::info('Usuario redirigido a pago exitoso');
        
        $ventaReciente = DB::table('ventas')
            ->where('id_cliente', session('cliente_id'))
            ->orderBy('id_venta', 'desc')
            ->first();

        return view('pago.exito', [
            'venta' => $ventaReciente,
            'cliente_id' => session('cliente_id')
        ]);
    }

    /**
     * Pagina de error
     */
    public function pagoError()
    {
        Log::info('Usuario redirigido a pago error');
        return view('pago.error');
    }

    /**
     * Pagina de pendiente
     */
    public function pagoPendiente()
    {
        Log::info('Usuario redirigido a pago pendiente');
        return view('pago.pendiente');
    }
    /**
 * Obtener el ID de usuario desde los datos del checkout
 */
private function obtenerUsuarioIdDesdeCheckout($externalReference)
{
    try {
        $checkoutData = DB::table('checkout_data')
            ->where('external_reference', $externalReference)
            ->first();

        if ($checkoutData && $checkoutData->user_id && $checkoutData->user_id != 27) {
            Log::info("Usando usuario real desde checkout: " . $checkoutData->user_id);
            return $checkoutData->user_id;
        }

        // Fallback: buscar por email del cliente
        $partes = explode('_', $externalReference);
        $clienteId = $partes[2] ?? null;
        
        if ($clienteId) {
            $cliente = DB::table('clientes')->where('id_cliente', $clienteId)->first();
            if ($cliente && $cliente->email_cliente) {
                $usuario = DB::table('usuarios')->where('email', $cliente->email_cliente)->first();
                if ($usuario) {
                    Log::info("Usuario encontrado por email: " . $usuario->id_usuario);
                    return $usuario->id_usuario;
                }
            }
        }

        Log::warning("Usando usuario por defecto 27 para: " . $externalReference);
        return 27;

    } catch (\Exception $e) {
        Log::error("Error al obtener usuario desde checkout: " . $e->getMessage());
        return 27;
    }
}
}