<?php

// app/Http/Controllers/Admin/MovimientoCajaController.php
namespace App\Http\Controllers\Admin;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\MovimientoCaja; // Asegúrate de usar tu modelo
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MovimientoCajaController extends Controller
{
    // Muestra la vista de Ingresos/Egresos y la tabla de movimientos
    public function index()
    {
        // 1. Obtener listado de movimientos paginados
        $movimientos = MovimientoCaja::with('usuario')
            ->orderByDesc('fecha')
            ->orderByDesc('id_movimiento')
            ->paginate(15);
        
        // 2. Calcular el balance total
        $balance = DB::table('movimientos_caja')
            ->select(DB::raw('SUM(CASE WHEN tipo = "ingreso" THEN monto ELSE -monto END) as balance_total'))
            ->value('balance_total') ?? 0;
            
        return view('inegresos.inegresos', compact('movimientos', 'balance'));
    }

    // Guarda un nuevo Ingreso o Egreso
public function store(Request $request)
{
    // 1. Validación de datos
    $request->validate([
        'tipo' => 'required|in:ingreso,egreso',
        'monto' => 'required|numeric|gt:0', 
        'concepto' => 'required|string|max:255',
    ]);
    
    // 2. Solución al problema de Auth
    if (!Auth::check()) {
        abort(403, 'Usuario no autenticado.');
    }
    $userId = Auth::user()->id_usuario; 
    
    // 3. Preparar los datos automáticamente
    $datosMovimiento = $request->only(['tipo', 'monto', 'concepto']);
    
    // Forzar la FECHA con el formato YYYY-MM-DD, y el ID de usuario
    $datosMovimiento['fecha'] = Carbon::now()->toDateString(); 
    $datosMovimiento['id_usuario'] = $userId;

    // 4. Crear el registro
    MovimientoCaja::create($datosMovimiento);

    return redirect()->route('admin.ingresosEgresos')->with('success', 'Movimiento de caja registrado automáticamente.');
}
}

