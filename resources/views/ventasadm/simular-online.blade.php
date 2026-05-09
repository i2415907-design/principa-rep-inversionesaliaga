<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simular Venta Online</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">🛒 Simular Venta Online</h1>
            <a href="{{ route('admin.pedidos') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                ← Volver a Pedidos
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('ventas.simular-online') }}" method="POST">
            @csrf

            <!-- Información del Cliente -->
            <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                <h2 class="text-lg font-semibold text-blue-800 mb-3">👤 Información del Cliente</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">DNI *</label>
                        <input type="text" name="doc_ident" required class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" placeholder="12345678">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nombre *</label>
                        <input type="text" name="nombre_cliente" required class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" placeholder="Juan">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Apellido *</label>
                        <input type="text" name="apellido_cliente" required class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" placeholder="Pérez">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email *</label>
                        <input type="email" name="email_cliente" required class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" placeholder="cliente@ejemplo.com">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Teléfono</label>
                        <input type="text" name="telefono_cliente" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" placeholder="987654321">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Dirección</label>
                        <input type="text" name="direccion_cliente" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" placeholder="Av. Principal 123">
                    </div>
                </div>
            </div>

            <!-- Información de Entrega -->
<div class="mb-6 p-4 bg-green-50 rounded-lg">
    <h2 class="text-lg font-semibold text-green-800 mb-3">🚚 Información de Entrega</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Referencia de Dirección *</label>
            <input type="text" name="referencia_ped" required class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" placeholder="Frente al parque, casa con reja blanca">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Código Postal</label>
            <input type="text" name="codigo_postal" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" placeholder="15001">
        </div>
        
        <!-- NUEVO CAMPO: Distrito -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Distrito *</label>
            <select name="id_distrito" required class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 distrito-select">
                <option value="">Seleccionar distrito</option>
                @foreach($distritos as $distrito)
                    <option value="{{ $distrito->id_distrito }}" data-precio-envio="{{ $distrito->precio_envio }}">
                        {{ $distrito->nombre_distr }} - S/ {{ $distrito->precio_envio }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700">Costo de Envío</label>
            <input type="text" id="costo-envio" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-100" value="S/ 0.00" readonly>
        </div>
        
        <div class="flex items-center">
            <input type="checkbox" name="recojo_tienda" value="1" id="recojo-tienda" class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
            <label class="ml-2 block text-sm text-gray-700">Recojo en tienda</label>
        </div>
    </div>
</div>

            <!-- Productos -->
            <div class="mb-6 p-4 bg-yellow-50 rounded-lg">
                <h2 class="text-lg font-semibold text-yellow-800 mb-3">🛍️ Productos</h2>
                
                <div id="productos-container">
                    <!-- Primer producto -->
                    <div class="producto-item grid grid-cols-1 md:grid-cols-4 gap-4 mb-4 p-3 bg-white rounded border">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Producto *</label>
                            <select name="productos[0][id_producto]" required class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 producto-select">
                                <option value="">Seleccionar producto</option>
                                @foreach($productos as $producto)
                                    <option value="{{ $producto->id_producto }}" data-precio="{{ $producto->precio_producto }}" data-stock="{{ $producto->stock_producto }}">
                                        {{ $producto->nombre_producto }} - S/ {{ $producto->precio_producto }} (Stock: {{ $producto->stock_producto }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Cantidad *</label>
                            <input type="number" name="productos[0][cantidad]" min="1" required class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 cantidad-input">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Precio Unitario</label>
                            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-100 precio-unitario" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Subtotal</label>
                            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-100 subtotal" readonly>
                        </div>
                    </div>
                </div>

                <button type="button" onclick="agregarProducto()" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                    ➕ Agregar Producto
                </button>

                <div class="mt-4 p-3 bg-gray-100 rounded">
                    <strong class="text-lg">Total: S/ <span id="total-venta">0.00</span></strong>
                </div>
            </div>

            <div class="flex justify-end space-x-3">
                <button type="reset" class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600">
                    🔄 Limpiar
                </button>
                <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded-md hover:bg-green-600">
                    ✅ Simular Venta Online
                </button>
            </div>
        </form>
    </div>

    <script>
        let productoCount = 1;

        function agregarProducto() {
            const container = document.getElementById('productos-container');
            const nuevoProducto = document.createElement('div');
            nuevoProducto.className = 'producto-item grid grid-cols-1 md:grid-cols-4 gap-4 mb-4 p-3 bg-white rounded border';
            nuevoProducto.innerHTML = `
                <div>
                    <label class="block text-sm font-medium text-gray-700">Producto *</label>
                    <select name="productos[${productoCount}][id_producto]" required class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 producto-select">
                        <option value="">Seleccionar producto</option>
                        @foreach($productos as $producto)
                            <option value="{{ $producto->id_producto }}" data-precio="{{ $producto->precio_producto }}" data-stock="{{ $producto->stock_producto }}">
                                {{ $producto->nombre_producto }} - S/ {{ $producto->precio_producto }} (Stock: {{ $producto->stock_producto }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Cantidad *</label>
                    <input type="number" name="productos[${productoCount}][cantidad]" min="1" required class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 cantidad-input">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Precio Unitario</label>
                    <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-100 precio-unitario" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Subtotal</label>
                    <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-100 subtotal" readonly>
                </div>
                <div class="md:col-span-4 flex justify-end">
                    <button type="button" onclick="eliminarProducto(this)" class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600">
                        ❌ Eliminar
                    </button>
                </div>
            `;
            container.appendChild(nuevoProducto);
            productoCount++;

            // Agregar event listeners al nuevo producto
            agregarEventListeners(nuevoProducto);
        }

        function eliminarProducto(button) {
            if (document.querySelectorAll('.producto-item').length > 1) {
                button.closest('.producto-item').remove();
                calcularTotal();
            } else {
                alert('Debe haber al menos un producto en la venta.');
            }
        }

        function agregarEventListeners(elemento) {
            const select = elemento.querySelector('.producto-select');
            const cantidadInput = elemento.querySelector('.cantidad-input');
            const precioUnitario = elemento.querySelector('.precio-unitario');
            const subtotal = elemento.querySelector('.subtotal');

            select.addEventListener('change', function() {
                const precio = this.options[this.selectedIndex]?.dataset.precio || '0';
                precioUnitario.value = 'S/ ' + parseFloat(precio).toFixed(2);
                calcularSubtotal(this);
            });

            cantidadInput.addEventListener('input', function() {
                calcularSubtotal(this);
            });
        }

        function calcularSubtotal(elemento) {
            const productoItem = elemento.closest('.producto-item');
            const select = productoItem.querySelector('select');
            const cantidadInput = productoItem.querySelector('.cantidad-input');
            const precioUnitario = productoItem.querySelector('.precio-unitario');
            const subtotal = productoItem.querySelector('.subtotal');

            const precio = select.options[select.selectedIndex]?.dataset.precio || '0';
            const cantidad = cantidadInput.value || '0';
            const subtotalCalculado = parseFloat(precio) * parseInt(cantidad);

            subtotal.value = 'S/ ' + subtotalCalculado.toFixed(2);
            calcularTotal();
        }

        function calcularTotal() {
            let total = 0;
            document.querySelectorAll('.subtotal').forEach(subtotal => {
                const valor = parseFloat(subtotal.value.replace('S/ ', '') || 0);
                total += valor;
            });
            document.getElementById('total-venta').textContent = total.toFixed(2);
        }

        // Agregar event listeners a los productos iniciales
        document.querySelectorAll('.producto-item').forEach(agregarEventListeners);

        // Función para actualizar el costo de envío
function actualizarCostoEnvio() {
    const distritoSelect = document.querySelector('.distrito-select');
    const recojoTienda = document.getElementById('recojo-tienda');
    const costoEnvioInput = document.getElementById('costo-envio');
    
    if (recojoTienda.checked) {
        costoEnvioInput.value = 'S/ 0.00';
        calcularTotalConEnvio();
        return;
    }
    
    const precioEnvio = distritoSelect.options[distritoSelect.selectedIndex]?.dataset.precioEnvio || '0';
    costoEnvioInput.value = 'S/ ' + parseFloat(precioEnvio).toFixed(2);
    calcularTotalConEnvio();
}

// Función para calcular total incluyendo envío
function calcularTotalConEnvio() {
    let subtotalProductos = 0;
    document.querySelectorAll('.subtotal').forEach(subtotal => {
        const valor = parseFloat(subtotal.value.replace('S/ ', '') || 0);
        subtotalProductos += valor;
    });
    
    const costoEnvio = parseFloat(document.getElementById('costo-envio').value.replace('S/ ', '') || 0);
    const total = subtotalProductos + costoEnvio;
    
    document.getElementById('total-venta').textContent = total.toFixed(2);
}

// Modifica la función agregarEventListeners para incluir el distrito
function agregarEventListeners(elemento) {
    const select = elemento.querySelector('.producto-select');
    const cantidadInput = elemento.querySelector('.cantidad-input');
    const precioUnitario = elemento.querySelector('.precio-unitario');
    const subtotal = elemento.querySelector('.subtotal');

    select.addEventListener('change', function() {
        const precio = this.options[this.selectedIndex]?.dataset.precio || '0';
        precioUnitario.value = 'S/ ' + parseFloat(precio).toFixed(2);
        calcularSubtotal(this);
    });

    cantidadInput.addEventListener('input', function() {
        calcularSubtotal(this);
    });
}

// Modifica calcularSubtotal para incluir envío
function calcularSubtotal(elemento) {
    const productoItem = elemento.closest('.producto-item');
    const select = productoItem.querySelector('select');
    const cantidadInput = productoItem.querySelector('.cantidad-input');
    const precioUnitario = productoItem.querySelector('.precio-unitario');
    const subtotal = productoItem.querySelector('.subtotal');

    const precio = select.options[select.selectedIndex]?.dataset.precio || '0';
    const cantidad = cantidadInput.value || '0';
    const subtotalCalculado = parseFloat(precio) * parseInt(cantidad);

    subtotal.value = 'S/ ' + subtotalCalculado.toFixed(2);
    calcularTotalConEnvio(); // Cambiado de calcularTotal a calcularTotalConEnvio
}

// Agrega event listeners para el distrito y recogo en tienda
document.addEventListener('DOMContentLoaded', function() {
    const distritoSelect = document.querySelector('.distrito-select');
    const recojoTienda = document.getElementById('recojo-tienda');
    
    if (distritoSelect) {
        distritoSelect.addEventListener('change', actualizarCostoEnvio);
    }
    
    if (recojoTienda) {
        recojoTienda.addEventListener('change', actualizarCostoEnvio);
    }
    
    // Agregar event listeners a los productos iniciales
    document.querySelectorAll('.producto-item').forEach(agregarEventListeners);
});
    </script>
</body>
</html>