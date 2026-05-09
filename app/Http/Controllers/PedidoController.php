<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Usuario;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\Venta;
use Illuminate\Support\Facades\Log;

class PedidoController extends Controller
{
    /**
     * Muestra la lista de pedidos en el panel de administración.
     */
public function indexAdmin(Request $request)
{
    // Construir la consulta base con carga ansiosa
    $query = Pedido::with([
        'cliente',      
        'venta.detalles.producto',
        'encargado',
        'distrito'
    ]);

    // Aplicar filtro por estado si se especifica
    if ($request->has('estado') && $request->estado != '') {
        $query->where('estado_pedido', $request->estado);
    }

    // Ordenar por los pedidos más recientes primero (ya lo tienes)
    $pedidos = $query->orderBy('fecha_pedido', 'desc')
                    ->paginate(15); 

    $vendedores = Usuario::whereIn('rol', ['vendedor', 'repartidor', 'admin'])->get(['id_usuario', 'nombre_usuario']);
    $estados = ['pendiente', 'enviado', 'entregado'];

    return view('pedidos.pedidosadm', compact('pedidos', 'vendedores', 'estados'));
}

    /**
     * Actualiza el estado y el encargado de un pedido específico.
     */
    public function updatePedido(Request $request, $id)
    {
        // 1. Validar los datos del formulario
        $request->validate([
            'estado_pedido' => ['required', Rule::in(['pendiente', 'enviado', 'entregado'])],
            'id_encargado' => 'nullable|exists:usuarios,id_usuario', 
        ]);

        $pedido = Pedido::findOrFail($id);
        
        // DEBUG: Verificar datos recibidos
        Log::info('Actualizando pedido:', [
            'pedido_id' => $id,
            'estado_pedido' => $request->estado_pedido,
            'id_encargado' => $request->id_encargado,
            'estado_actual' => $pedido->estado_pedido
        ]);

        DB::beginTransaction();

        try {
            // 2. Actualizar la VENTA si el pedido llega al estado final
            $estado = strtolower($request->estado_pedido);

            if ($estado === 'entregado') {
                Venta::where('id_venta', $pedido->id_venta)->update(['estado_venta' => 'Completada']);
                
                Log::info('Venta marcada como completada:', [
                    'venta_id' => $pedido->id_venta,
                    'pedido_id' => $id
                ]);
            }

            // 3. Actualizar los campos del pedido
            $pedido->estado_pedido = $estado;
            $pedido->id_encargado = $request->id_encargado; 
            $pedido->save();

            DB::commit();

            Log::info('Pedido actualizado exitosamente:', [
                'pedido_id' => $id,
                'nuevo_estado' => $estado,
                'nuevo_encargado' => $request->id_encargado
            ]);

            return redirect()->route('admin.pedidos')->with('success', 'El pedido N° ' . $id . ' ha sido actualizado a: ' . $request->estado_pedido . '.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error al actualizar pedido: ' . $e->getMessage(), [
                'pedido_id' => $id,
                'estado_pedido' => $request->estado_pedido,
                'id_encargado' => $request->id_encargado,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()->withErrors('Hubo un error al actualizar el pedido. Consulte los logs para más detalles.');
        }
    }

    // Elimina el método index() duplicado o manten solo uno
public function index(Request $request)
{
    return $this->indexAdmin($request);
}
    
}