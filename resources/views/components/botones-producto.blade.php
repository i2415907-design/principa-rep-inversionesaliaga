@props(['producto', 'align' => 'justify-between'])

<div class="flex {{ $align }} items-center gap-2">

    <!-- Botón Editar -->
    <button 
        onclick="abrirModalEditar({{ $producto->id_producto }}, '{{ addslashes($producto->nombre_producto) }}', '{{ addslashes($producto->descripcion_producto) }}', {{ $producto->id_categoria }}, '{{ addslashes($producto->marca ?? '') }}', {{ $producto->precio_producto }}, {{ $producto->stock_producto }})"
        class="px-3 py-1 text-sm bg-orange-500 text-white rounded-md hover:bg-orange-600 transition flex items-center gap-1 shadow">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
        </svg>
        Editar
    </button>

    @if ($producto->estado_producto === 'descontinuado')
        <!-- Botón Reactivar (solo si está descontinuado) -->
        <form action="{{ route('productos.reactivar', $producto->id_producto) }}" 
              method="POST" 
              onsubmit="return confirm('¿Deseas reactivar este producto?')">
            @csrf
            @method('PUT')
            <button type="submit" 
                class="px-3 py-1 text-sm bg-blue-600 text-white rounded-md hover:bg-blue-700 transition flex items-center gap-1 shadow">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 4v6h6M20 20v-6h-6M4 10a8.001 8.001 0 0115.9 1.1M20 14a8.001 8.001 0 01-15.9-1.1" />
                </svg>
                Reactivar
            </button>
        </form>
    @else
        <!-- Botón Eliminar/Descontinuar (solo si NO está descontinuado) -->
        <button 
            onclick="abrirModalEliminar({{ $producto->id_producto }}, '{{ addslashes($producto->nombre_producto) }}')"
            class="px-3 py-1 text-sm bg-red-600 text-white rounded-md hover:bg-red-700 transition flex items-center gap-1 shadow">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m-1-4H10a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1z" />
            </svg>
            Elm/desc
        </button>
    @endif

</div>
