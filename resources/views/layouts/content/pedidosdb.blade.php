<div class="p-6 bg-gray-50 min-h-screen">
    <!-- Header con breadcrumb sutil -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Gestión de Pedidos</h1>
        <p class="text-sm text-gray-500 mt-1">Administra y da seguimiento a todos los pedidos</p>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-lg shadow-sm flex items-center">
            <svg class="w-4 h-4 mr-2 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="text-sm">{{ session('success') }}</span>
        </div>
    @endif
    
    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-lg shadow-sm flex items-center">
            <svg class="w-4 h-4 mr-2 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="text-sm">Error al procesar: {{ $errors->first() }}</span>
        </div>
    @endif

    @if($pedidos->count() > 0)
        <!-- Filtros con diseño mejorado -->
        <div class="mb-6 p-5 bg-white rounded-xl border border-gray-200 shadow-sm">
            {{-- FIX: Icono reducido de w-3.5 h-3.5 a w-3 h-3 para que no se vea desproporcionado --}}
            <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-3 flex items-center">
                <svg class="w-3 h-3 mr-1.5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                Filtros
            </h3>
            <form action="{{ route('admin.pedidos') }}" method="GET" class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-[200px]">
                    <label for="filtro_estado" class="block text-xs font-medium text-gray-500 mb-1">Estado del pedido</label>
                    <select name="estado" id="filtro_estado" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        <option value="">Todos los estados</option>
                        <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="enviado" {{ request('estado') == 'enviado' ? 'selected' : '' }}>Enviado</option>
                        <option value="entregado" {{ request('estado') == 'entregado' ? 'selected' : '' }}>Entregado</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-sm text-sm font-medium flex items-center">
                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Aplicar
                    </button>
                    <a href="{{ route('admin.pedidos') }}" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition text-sm font-medium flex items-center">
                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Limpiar
                    </a>
                </div>
            </form>
            
            <!-- Mostrar filtro activo -->
            @if(request('estado'))
                <div class="mt-3 p-2 bg-blue-50 rounded-lg border border-blue-100">
                    <p class="text-xs text-blue-700 flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Mostrando pedidos con estado: <strong class="ml-1">{{ ucfirst(request('estado')) }}</strong>
                    </p>
                </div>
            @endif
        </div>

        <!-- Grid de pedidos -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
            @foreach($pedidos as $pedido)
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-all duration-200 cursor-pointer overflow-hidden" 
                     onclick="openModal({{ $pedido->id_pedido }})">
                    
                    <!-- Cabecera con número de pedido -->
                    <div class="px-3 py-2 flex justify-between items-center border-b border-gray-100 bg-gray-50">
                        <span class="text-2xs text-gray-400 uppercase tracking-wider">Pedido</span>
                        <span class="text-xs font-medium text-gray-600 bg-white px-2 py-0.5 rounded-full border border-gray-200">#{{ $pedido->id_pedido }}</span>
                    </div>
                    
                    <!-- Imagen del primer producto -->
                    <div class="relative h-36 bg-gray-100">
                        @php
                            $tieneImagen = false;
                            $imagenSrc = '';
                            $altText = 'Producto';
                            
                            if ($pedido->venta && 
                                $pedido->venta->detalles && 
                                $pedido->venta->detalles->first() && 
                                $pedido->venta->detalles->first()->producto && 
                                !empty($pedido->venta->detalles->first()->producto->imagen)) {
                                
                                $imagenProducto = $pedido->venta->detalles->first()->producto->imagen;
                                $filename = basename($imagenProducto);
                                $imagenSrc = route('images.products', ['filename' => $filename]);
                                $altText = $pedido->venta->detalles->first()->producto->nombre_producto;
                                $tieneImagen = true;
                            }
                        @endphp
                        
                        @if($tieneImagen)
                            <img src="{{ $imagenSrc }}" 
                                 alt="{{ $altText }}"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                        
                        {{-- FIX: Reemplazadas clases Tailwind dinámicas (no detectadas por JIT) por estilos inline seguros --}}
                        <div class="absolute top-2 right-2">
                            @php $estado = $pedido->estado_pedido; @endphp

                            @if($estado == 'pendiente')
                                <span class="inline-flex px-2 py-0.5 text-xs font-medium rounded-full text-white shadow-sm" style="background-color: #f59e0b;">
                                    Pendiente
                                </span>
                            @elseif($estado == 'enviado')
                                <span class="inline-flex px-2 py-0.5 text-xs font-medium rounded-full text-white shadow-sm" style="background-color: #0ea5e9;">
                                    Enviado
                                </span>
                            @elseif($estado == 'entregado')
                                <span class="inline-flex px-2 py-0.5 text-xs font-medium rounded-full text-white shadow-sm" style="background-color: #059669;">
                                    Entregado
                                </span>
                            @else
                                <span class="inline-flex px-2 py-0.5 text-xs font-medium rounded-full text-white shadow-sm" style="background-color: #6b7280;">
                                    {{ ucfirst($estado) }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Contenido de la tarjeta -->
                    <div class="p-3">
                        <!-- Producto principal -->
                        <div class="mb-2">
                            <h3 class="font-medium text-gray-800 text-sm line-clamp-1">
                                @if($pedido->venta && $pedido->venta->detalles && $pedido->venta->detalles->first() && $pedido->venta->detalles->first()->producto)
                                    {{ $pedido->venta->detalles->first()->producto->nombre_producto }}
                                @else
                                    Producto no disponible
                                @endif
                            </h3>
                            @if($pedido->venta && $pedido->venta->detalles && $pedido->venta->detalles->count() > 1)
                                <p class="text-2xs text-gray-400 mt-0.5">+{{ $pedido->venta->detalles->count() - 1 }} productos más</p>
                            @endif
                        </div>

                        <!-- Información del cliente con iconos pequeños -->
                        <div class="space-y-1 mb-2">
                            <div class="flex items-center text-2xs text-gray-600">
                                <svg class="w-3 h-3 mr-1 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span class="line-clamp-1">{{ $pedido->cliente ? ($pedido->cliente->nombre_cliente . ' ' . ($pedido->cliente->apellido_cliente ?? '')) : 'Cliente no disponible' }}</span>
                            </div>
                            <div class="flex items-center text-2xs text-gray-600">
                                <svg class="w-3 h-3 mr-1 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <span>{{ $pedido->cliente ? ($pedido->cliente->telefono_cliente ?? 'N/A') : 'N/A' }}</span>
                            </div>
                        </div>

                        <!-- Total y fecha -->
                        <div class="flex justify-between items-center pt-2 border-t border-gray-100">
                            <div>
                                <p class="text-2xs text-gray-400">Total</p>
                                <p class="text-sm font-semibold text-gray-800">
                                    S/ {{ number_format($pedido->venta->total_venta ?? 0, 2) }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-2xs text-gray-400">Fecha</p>
                                <p class="text-2xs font-medium text-gray-500">
                                    {{ \Carbon\Carbon::parse($pedido->fecha_pedido)->format('d/m/Y') }}
                                </p>
                            </div>
                        </div>

                        <!-- Encargado sutil -->
                        <div class="mt-1.5 text-right">
                            <span class="text-2xs text-gray-400">
                                {{ $pedido->encargado ? $pedido->encargado->nombre_usuario : 'Sin asignar' }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Paginación -->
        <div class="mt-8">
            {{ $pedidos->links() }}
        </div>
    @else
        <div class="bg-white rounded-xl border border-gray-200 p-12 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
            </div>
            <h3 class="text-base font-medium text-gray-700 mb-1">No hay pedidos</h3>
            <p class="text-sm text-gray-500">No se encontraron pedidos para mostrar.</p>
        </div>
    @endif
</div>

<!-- Modal (con iconos más pequeños) -->
<div id="pedidoModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden items-center justify-center z-50 transition-opacity duration-300">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-4xl p-6 transform scale-95 transition-transform duration-300 max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center border-b border-gray-200 pb-3 mb-6">
            <h3 class="text-lg font-semibold text-gray-800">Pedido <span id="modalPedidoId" class="text-blue-600"></span></h3>
            <button type="button" onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form id="updateForm" method="POST" onsubmit="return confirmUpdate(event)">
            @csrf
            
            <!-- Información del Cliente -->
            <div class="mb-6 p-5 bg-gray-50 rounded-lg border border-gray-200">
                <h4 class="text-sm font-medium text-gray-700 mb-3 flex items-center">
                    <svg class="w-4 h-4 mr-1.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Información del Cliente
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-xs text-gray-500 mb-0.5">Nombre Completo</p>
                        <p class="text-sm text-gray-700 font-medium" id="modalClienteNombre"></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-0.5">Teléfono</p>
                        <p class="text-sm text-gray-700" id="modalClienteCelular"></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-0.5">Email</p>
                        <p class="text-sm text-gray-700" id="modalClienteEmail"></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-0.5">DNI</p>
                        <p class="text-sm text-gray-700" id="modalClienteDNI"></p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-xs text-gray-500 mb-0.5">Dirección del Cliente</p>
                        <p class="text-sm text-gray-700" id="modalDireccionCliente"></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-0.5">Distrito de Entrega</p>
                        <p class="text-sm text-gray-700" id="modalDistrito"></p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-xs text-gray-500 mb-0.5">Referencia de Entrega</p>
                        <p class="text-sm text-gray-700" id="modalReferencia"></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-0.5">Recojo en Tienda</p>
                        <p class="text-sm text-gray-700" id="modalRecojoTienda"></p>
                    </div>
                </div>
            </div>

            <!-- Información de la Venta -->
            <div class="mb-6 p-5 bg-gray-50 rounded-lg border border-gray-200">
                <h4 class="text-sm font-medium text-gray-700 mb-3 flex items-center">
                    <svg class="w-4 h-4 mr-1.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Información de la Venta
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-500 mb-0.5">Total Venta</p>
                        <p class="text-base font-semibold text-gray-800" id="modalTotalVenta"></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-0.5">Fecha de Pedido</p>
                        <p class="text-sm text-gray-700" id="modalFechaPedido"></p>
                    </div>
                </div>
            </div>

            <!-- Productos del Pedido -->
            <div class="mb-6 p-5 bg-gray-50 rounded-lg border border-gray-200">
                <h4 class="text-sm font-medium text-gray-700 mb-3 flex items-center">
                    <svg class="w-4 h-4 mr-1.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    Productos del Pedido
                </h4>
                <div id="modalProductos" class="space-y-2">
                    <!-- Los productos se cargarán dinámicamente -->
                </div>
            </div>
            
            <!-- Controles de Gestión -->
            <div class="mb-6 p-5 bg-gray-50 rounded-lg border border-gray-200">
                <h4 class="text-sm font-medium text-gray-700 mb-3 flex items-center">
                    <svg class="w-4 h-4 mr-1.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Gestión del Pedido
                </h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="modalEstado" class="block text-xs font-medium text-gray-500 mb-1">Estado del Pedido</label>
                        <select id="modalEstado" name="estado_pedido" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            @foreach($estados as $estado)
                                <option value="{{ $estado }}">{{ ucfirst($estado) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="modalEncargado" class="block text-xs font-medium text-gray-500 mb-1">Asignar Repartidor/Vendedor</label>
                        <select id="modalEncargado" name="id_encargado" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <option value="">-- Sin Asignar --</option>
                            @foreach($vendedores as $vendedor)
                                <option value="{{ $vendedor->id_usuario }}">{{ $vendedor->nombre_usuario }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition text-sm font-medium">
                    Cancelar
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-sm text-sm font-medium">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>

<!-- El script se mantiene IDÉNTICO -->
<script>
    // La data se pasa desde el controlador (paginado)
    const pedidosData = @json($pedidos->items()); 

    function openModal(pedidoId) {
        const pedido = pedidosData.find(p => p.id_pedido === pedidoId);
        
        if (!pedido) {
            console.error("Pedido no encontrado en los datos locales.", pedidoId);
            return;
        }

        // 1. Llenar los campos de información del cliente
        document.getElementById('modalPedidoId').textContent = '#' + pedido.id_pedido;
        document.getElementById('modalClienteNombre').textContent = pedido.cliente ? (pedido.cliente.nombre_cliente + ' ' + (pedido.cliente.apellido_cliente || '')) : 'Cliente Eliminado';
        document.getElementById('modalClienteCelular').textContent = pedido.cliente ? (pedido.cliente.telefono_cliente || 'N/A') : 'N/A';
        document.getElementById('modalClienteEmail').textContent = pedido.cliente ? (pedido.cliente.email_cliente || 'N/A') : 'N/A';
        document.getElementById('modalClienteDNI').textContent = pedido.cliente ? (pedido.cliente.doc_ident || 'N/A') : 'N/A';
        
        document.getElementById('modalDireccionCliente').textContent = pedido.cliente ? (pedido.cliente.direccion_cliente || 'No especificada') : 'No especificada';
        
        document.getElementById('modalReferencia').textContent = pedido.referencia_ped || 'No especificada';
        document.getElementById('modalDistrito').textContent = pedido.distrito ? pedido.distrito.nombre_distr : 'No especificado';
        document.getElementById('modalRecojoTienda').textContent = pedido.recojo_tienda ? 'Sí' : 'No';
        
        document.getElementById('modalTotalVenta').textContent = 'S/ ' + (pedido.venta ? parseFloat(pedido.venta.total_venta).toFixed(2) : '0.00');
        document.getElementById('modalFechaPedido').textContent = formatFechaParaModal(pedido.fecha_pedido);

        // 2. Cargar productos del pedido
        const productosContainer = document.getElementById('modalProductos');
        productosContainer.innerHTML = '';
        
        if (pedido.venta && pedido.venta.detalles) {
            pedido.venta.detalles.forEach((detalle, index) => {
                const productoDiv = document.createElement('div');
                productoDiv.className = 'flex justify-between items-center p-2 bg-white rounded border border-gray-200 text-sm';
                productoDiv.innerHTML = `
                    <div class="flex items-center space-x-3">
                        <span class="text-xs font-medium text-gray-400 w-4">${index + 1}.</span>
                        <span class="text-sm text-gray-700">${detalle.producto ? detalle.producto.nombre_producto : 'Producto no disponible'}</span>
                    </div>
                    <div class="text-right">
                        <span class="text-xs text-gray-500">${detalle.cantidad} x </span>
                        <span class="text-sm font-medium text-gray-800">S/ ${parseFloat(detalle.subtotal).toFixed(2)}</span>
                    </div>
                `;
                productosContainer.appendChild(productoDiv);
            });
        } else {
            productosContainer.innerHTML = '<p class="text-sm text-gray-500">No hay productos disponibles</p>';
        }

        // 3. Llenar los campos editables
        let estadoParaSelect = pedido.estado_pedido ? pedido.estado_pedido : 'pendiente';
        document.getElementById('modalEstado').value = estadoParaSelect;
        document.getElementById('modalEncargado').value = pedido.id_encargado || '';

        // 4. Establecer la acción del formulario
        const form = document.getElementById('updateForm');
        form.action = '{{ route("admin.pedidos.update", ["id" => "TEMP_ID"]) }}'.replace('TEMP_ID', pedido.id_pedido);

        // 5. Mostrar el modal
        const modal = document.getElementById('pedidoModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function formatFechaParaModal(fechaString) {
        if (!fechaString) return 'Fecha no disponible';
        
        try {
            if (fechaString instanceof Date && !isNaN(fechaString.getTime())) {
                return fechaString.toLocaleDateString('es-PE', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
            }
            
            if (typeof fechaString === 'string') {
                let date;
                
                if (fechaString.includes('T')) {
                    date = new Date(fechaString);
                }
                else if (fechaString.includes(' ')) {
                    date = new Date(fechaString.replace(' ', 'T'));
                }
                else {
                    date = new Date(fechaString + 'T00:00:00');
                }
                
                if (!isNaN(date.getTime())) {
                    return date.toLocaleDateString('es-ES', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                }
            }
            
            console.warn('No se pudo parsear la fecha:', fechaString);
            return 'Fecha inválida';
            
        } catch (error) {
            console.error('Error formateando fecha:', fechaString, error);
            return 'Error fecha';
        }
    }

    function closeModal() {
        const modal = document.getElementById('pedidoModal');
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }

    function confirmUpdate(event) {
        const estadoActual = document.getElementById('modalEstado').value.toLowerCase();
        const pedidoId = document.getElementById('modalPedidoId').textContent;

        let mensaje = `¿Está seguro de guardar los cambios para el pedido ${pedidoId}?`;

        if (estadoActual === 'entregado') {
             mensaje += "\n\n⚠️ ATENCIÓN: Al confirmar como 'Entregado', la Venta también se marcará como Completada.";
        }
        
        const isConfirmed = confirm(mensaje);
        
        if (!isConfirmed) {
            event.preventDefault();
            return false;
        }
        return true;
    }
</script>