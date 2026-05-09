<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class PerfilController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $usuario = $request->user();
        
        // Obtener las compras del usuario con detalles completos
        $compras = DB::table('pedidos')
            ->join('ventas', 'pedidos.id_venta', '=', 'ventas.id_venta')
            ->join('clientes', 'ventas.id_cliente', '=', 'clientes.id_cliente')
            ->where('ventas.id_usuario', $usuario->id_usuario)
            ->select(
                'pedidos.id_pedido',
                'pedidos.fecha_pedido',
                'pedidos.total_pedido',
                'pedidos.estado_pedido',
                'pedidos.recojo_tienda',
                'ventas.id_venta',
                'clientes.nombre_cliente',
                'clientes.apellido_cliente'
            )
            ->orderBy('pedidos.fecha_pedido', 'desc')
            ->get();

        // Obtener los detalles de productos para cada compra
        foreach ($compras as $compra) {
            $compra->productos = DB::table('detalles_venta')
                ->join('productos', 'detalles_venta.id_producto', '=', 'productos.id_producto')
                ->where('detalles_venta.id_venta', $compra->id_venta)
                ->select(
                    'productos.id_producto',
                    'productos.nombre_producto',
                    'productos.imagen',
                    'detalles_venta.cantidad',
                    'detalles_venta.precio_unitario',
                    'detalles_venta.subtotal'
                )
                ->get();
        }

        return view('layouts.perfildelcliente', [
            'usuario' => $usuario,
            'compras' => $compras
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $usuario = $request->user();

        $validated = $request->validate([
            'nombre_usuario' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:usuarios,email,' . $usuario->id_usuario . ',id_usuario',
            'password' => [
                'nullable',
                'string',
                'min:8', // mínimo 8 caracteres
                'regex:/[A-Z]/', // al menos una letra mayúscula
                'regex:/[0-9]/', // al menos un número
                'regex:/[@$!%*?&]/', // al menos un carácter especial
                'confirmed' // valida que coincida con password_confirmation
            ]
        ], [
            // Mensajes personalizados
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.regex' => 'La contraseña debe incluir al menos una letra mayúscula, un número y un carácter especial.',
            'password.confirmed' => 'Las contraseñas no coinciden.'
        ]);

        $usuario->nombre_usuario = $validated['nombre_usuario'];
        $usuario->email = $validated['email'];

        if (!empty($validated['password'])) {
            $usuario->contrasena = bcrypt($validated['password']);
        }

        $usuario->save();

        return Redirect::route('perfil')->with('status', 'Perfil actualizado correctamente.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}