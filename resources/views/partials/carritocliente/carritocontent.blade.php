<h2 class="text-3xl font-bold mb-6 text-gray-800">🛒 Carrito de compras</h2>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
  <!-- Carrito a la izquierda (2/3 de ancho) -->
  <div class="md:col-span-2">
    <div id="carrito-vacio" class="text-center py-12">
      <div class="text-gray-400 text-6xl mb-4">🛒</div>
      <h3 class="text-xl font-semibold text-gray-600 mb-2">Tu carrito está vacío</h3>
      <p class="text-gray-500 mb-4">Agrega algunos productos para comenzar a comprar.</p>
      <a href="{{ route('home') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
        Ver productos
      </a>
    </div>

    <div id="carrito-contenido" class="hidden">
<table class="w-full border rounded-lg shadow-lg text-sm">
  <thead class="bg-orange-100 text-gray-700">
    <tr>
      <th class="p-3 text-center w-12">
        <input type="checkbox" id="seleccionar-todos" class="form-checkbox rounded text-orange-500 focus:ring-orange-400">
      </th>
      <th class="p-3 font-semibold w-16">Imagen</th>
      <th class="p-3 font-semibold w-32">Artículo</th>
      <th class="p-3 font-semibold w-48">Descripción</th> <!-- 🔥 ANCHO LIMITADO -->
      <th class="p-3 font-semibold w-20">Precio</th>
      <th class="p-3 font-semibold w-24">Cant.</th>
      <th class="p-3 font-semibold text-right w-20">Total</th>
      <th class="p-3 font-semibold text-center w-16">Eliminar</th>
    </tr>
  </thead>
        <tbody id="carrito-tbody" class="bg-white">
          <!-- Los productos se cargarán dinámicamente aquí -->
  </tbody>
</table>
    </div>
  </div>

  <!-- Resumen a la derecha (1/3 de ancho) -->
  <div class="bg-orange-50 border border-orange-200 p-4 rounded-lg shadow-sm">
    <div class="mb-4">
                  <div class="flex items-center space-x-3">
                <input type="checkbox" id="recojoTienda" name="recojo_tienda" class="h-5 w-5 text-orange-500" {{ !auth()->check() ? 'disabled' : '' }}>
                <label for="recojoTienda" class="text-sm font-medium">Recoger pedido en tienda</label>
            </div>
            <p class="mt-2 mb-2">Las entregas y envios solo estan disponibles en la provincia de <strong>Huancayo</strong> .</p>
            <p class="mt-2 mb-2">La fecha maxima de entrega son <strong>5 dias</strong> a partir de la compra .</p>
            <p class="mt-2 mb-2">¡Hey!<strong>su comprobante de pago</strong> se le entregara junto a su producto.</p>
    </div>
    
    <div class="mb-4">
  <label class="block mb-1 font-medium text-gray-700">Distrito</label>
  <select id="select-distrito" 
          class="w-full p-2 border border-gray-300 rounded-lg bg-white focus:ring-orange-400 focus:border-orange-400">
      <option value="">Cargando distritos...</option>
  </select>
</div>

    <p class="mb-2">Subtotal: <strong id="subtotal-text">S/ 0.00</strong></p>
    <p class="mb-2">Precio de envío: <strong id="envioText">S/ 0.00</strong></p>
    <p class="mb-4 text-lg font-bold">Total a pagar: <strong id="totalText">S/ 0.00</strong></p>

    @if(auth()->check())
    <form action="{{ route('checkout.checkoutcl') }}" method="GET">
        <button type="button" id="btn-continuar-compra" class="w-full bg-orange-500 text-white px-4 py-2 rounded-full hover:bg-orange-600 transition font-semibold" disabled>
        Continuar compra
      </button>
    </form>
    @else
    <div class="text-center mt-4 text-sm text-gray-600">
        <p class="mb-3">Para completar tu compra, inicia sesión o regístrate</p>
        <div class="flex gap-2">
          <a href="{{ route('login') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm">
            Iniciar sesión
          </a>
          <a href="{{ route('register') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition text-sm">
            Registrarse
          </a>
        </div>
        <p class="text-xs text-gray-500 mt-2">
          Tu carrito se mantendrá guardado
        </p>
    </div>
    @endif
  </div>
</div>

<script>
// Helper para leer cookies (si se necesita en el futuro)
function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
    return null;
}

// Variables globales para el cálculo de envío
    const recojoCheckbox = document.getElementById('recojoTienda');
    const envioText = document.getElementById('envioText');
    const totalText = document.getElementById('totalText');
const subtotalText = document.getElementById('subtotal-text');
const btnContinuarCompra = document.getElementById('btn-continuar-compra');

// Cargar productos del carrito al cargar la página

async function cargarProductosDelCarrito() {
    // Primero validar productos contra la base de datos
    const carritoValido = await validarProductosCarrito();
    
    if (carritoValido.length === 0) {
        mostrarCarritoVacio();
        return;
    }
    
    mostrarProductosDelCarrito(carritoValido);
}

function mostrarCarritoVacio() {
    document.getElementById('carrito-vacio').classList.remove('hidden');
    document.getElementById('carrito-contenido').classList.add('hidden');
    
    // Actualizar totales a 0
    actualizarTotales([]);
    
    // Deshabilitar botón de continuar compra
    if (btnContinuarCompra) {
        btnContinuarCompra.disabled = true;
    }
}

function mostrarProductosDelCarrito(carrito) {
    document.getElementById('carrito-vacio').classList.add('hidden');
    document.getElementById('carrito-contenido').classList.remove('hidden');
    
    const tbody = document.getElementById('carrito-tbody');
    tbody.innerHTML = '';
    
    carrito.forEach((item, index) => {
        
        
        // 🔥 TRUNCAR DESCRIPCIÓN si es muy larga
        const descripcionTruncada = item.descripcion 
            ? (item.descripcion.length > 100 
                ? item.descripcion.substring(0, 100) + '...' 
                : item.descripcion)
            : '';
        
        const row = document.createElement('tr');
        row.className = 'border-t hover:bg-gray-50 transition';
        row.innerHTML = `
            <td class="p-3 text-center">
                <input type="checkbox" name="seleccionados[]" value="${item.id}" class="form-checkbox rounded text-orange-500 focus:ring-orange-400">
            </td>
<td class="p-3 text-center">
    ${item.imagen ? 
        `<img src="/img/products/${item.imagen.split('/').pop()}" alt="${item.nombre}" class="w-12 h-12 object-cover rounded mx-auto">`
        : `<div class="w-12 h-12 bg-gray-200 rounded mx-auto flex items-center justify-center">
            <span class="text-gray-400 text-xs">Sin imagen</span>
           </div>`}
</td>
            <td class="p-3 font-medium">${item.nombre}</td>
            <td class="p-3 text-sm text-gray-600 max-w-48 truncate" title="${item.descripcion || ''}">${descripcionTruncada}</td>
            <td class="p-3 font-medium">S/ ${parseFloat(item.precio).toFixed(2)}</td>
            <td class="p-3 text-center">
                <div class="flex items-center justify-center space-x-2">
                    <button onclick="cambiarCantidad(${index}, -1)" class="w-6 h-6 bg-gray-200 rounded-full flex items-center justify-center hover:bg-gray-300 transition">-</button>
                    <span class="w-8 text-center font-medium">${item.cantidad}</span>
                    <button onclick="cambiarCantidad(${index}, 1)" class="w-6 h-6 bg-gray-200 rounded-full flex items-center justify-center hover:bg-gray-300 transition">+</button>
                </div>
            </td>
            <td class="p-3 font-medium text-right">S/ ${(item.precio * item.cantidad).toFixed(2)}</td>
            <td class="p-3 text-center">
                <button onclick="eliminarProducto(${index})" class="text-red-600 hover:text-red-800 transition" title="Eliminar producto">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </td>
        `;
        tbody.appendChild(row);
    });
    
    // Actualizar totales
    actualizarTotales(carrito);
    
    // Habilitar botón de continuar compra si hay productos
    if (btnContinuarCompra) {
        btnContinuarCompra.disabled = false;
    }

    validarBotonContinuar();
    actualizarCheckboxSeleccionarTodos();
}

async function cambiarCantidad(index, cambio) {
    const carrito = JSON.parse(localStorage.getItem('carrito') || '[]');

    if (carrito[index]) {
        const nuevaCantidad = carrito[index].cantidad + cambio;

        // Validaciones básicas
        if (nuevaCantidad < 1) {
            eliminarProducto(index);
            return;
        }

        if (nuevaCantidad > 10) {
            mostrarNotificacion("⚠️ Solo puedes agregar hasta 10 unidades de este producto");
            return;
        }

        // 🔥 VALIDAR STOCK EN TIEMPO REAL
        try {
            const response = await fetch(`/api/producto/${carrito[index].id}/validar-completo`);
            const productoData = await response.json();
            
            // Verificar si el producto existe y está disponible
            if (!productoData.disponible) {
                mostrarNotificacion("⚠️ Este producto ya no está disponible");
                eliminarProducto(index);
                return;
            }
            
            // Verificar stock
            if (productoData.stock_disponible < nuevaCantidad) {
                mostrarNotificacion(`⚠️ Solo hay ${productoData.stock_disponible} unidades disponibles`);
                return;
            }
            
        } catch (error) {
            console.error('Error al verificar producto:', error);
            // Continuar sin validación si hay error
        }

        carrito[index].cantidad = nuevaCantidad;
        localStorage.setItem('carrito', JSON.stringify(carrito));
        actualizarTotales(carrito);
        mostrarProductosDelCarrito(carrito);

        // Sincronizar con la BD si está autenticado
        if ({{ auth()->check() ? 'true' : 'false' }}) {
            const producto = carrito[index];
            if (producto) {
                try {
                    const response = await fetch(`/api/carrito/item/${producto.id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        credentials: 'same-origin',
                        body: JSON.stringify({ cantidad: producto.cantidad })
                    });
                    
                    const result = await response.json();
                    if (!result.success) {
                        mostrarNotificacion(`⚠️ ${result.message}`);
                        // Revertir cambio en localStorage si falla
                        carrito[index].cantidad -= cambio;
                        localStorage.setItem('carrito', JSON.stringify(carrito));
                        cargarProductosDelCarrito();
                    }
                } catch (error) {
                    console.error('Error al sincronizar con BD:', error);
                }
            }
        }
    }
}

function eliminarProducto(index) {
    const carrito = JSON.parse(localStorage.getItem('carrito') || '[]');
    
    if (carrito[index]) {
        const productoId = carrito[index].id; // Guardar ID para actualizar catálogo
        carrito.splice(index, 1);
        localStorage.setItem('carrito', JSON.stringify(carrito));
        cargarProductosDelCarrito();

        // 🔥 ACTUALIZAR BOTÓN EN CATÁLOGO
        actualizarBotonCatalogo(productoId, false);

        if ({{ auth()->check() ? 'true' : 'false' }}) {
            fetch(`/api/carrito/item/${productoId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
        }
    }
    validarBotonContinuar();
}

function actualizarTotales(carrito) {
    // Obtener solo los productos seleccionados
    const productosSeleccionados = obtenerProductosSeleccionados(carrito);
    
    // Calcular subtotal basado en productos seleccionados
    const subtotal = productosSeleccionados.reduce((sum, item) => sum + (item.precio * item.cantidad), 0);
    
    // 🔥 CALCULAR ENVÍO CORRECTAMENTE (NO SIEMPRE CERO)
    const selectDistrito = document.getElementById('select-distrito');
    const recojoCheckbox = document.getElementById('recojoTienda');
    
    let envio = 0.0;
    
    // Si NO es recojo en tienda Y hay distrito seleccionado, calcular envío
    if (recojoCheckbox && !recojoCheckbox.checked && selectDistrito && selectDistrito.value) {
        const selectedOption = selectDistrito.options[selectDistrito.selectedIndex];
        envio = parseFloat(selectedOption?.dataset?.precio || 0);
    }
    
    const total = subtotal + envio;
    
    subtotalText.textContent = `S/ ${subtotal.toFixed(2)}`;
    envioText.textContent = `S/ ${envio.toFixed(2)}`;
    totalText.textContent = `S/ ${total.toFixed(2)}`;
    
    // Validar botón de continuar compra
    validarBotonContinuar();
}

// Seleccionar todos los productos
document.getElementById('seleccionar-todos').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('input[name="seleccionados[]"]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
    
    // Actualizar totales inmediatamente
    const carrito = JSON.parse(localStorage.getItem('carrito') || '[]');
    actualizarTotales(carrito);
});

document.addEventListener('change', function(e) {
    if (e.target.matches('input[name="seleccionados[]"]')) {
        const carrito = JSON.parse(localStorage.getItem('carrito') || '[]');
        actualizarTotales(carrito);
        
        // Actualizar también el checkbox "Seleccionar todos"
        actualizarCheckboxSeleccionarTodos();
    }
});

function actualizarCheckboxSeleccionarTodos() {
    const checkboxes = document.querySelectorAll('input[name="seleccionados[]"]');
    const seleccionarTodos = document.getElementById('seleccionar-todos');
    
    if (checkboxes.length === 0) {
        seleccionarTodos.checked = false;
        return;
    }
    
    const todosSeleccionados = Array.from(checkboxes).every(checkbox => checkbox.checked);
    seleccionarTodos.checked = todosSeleccionados;
}

// FUNCIÓN DEL CHECKBOX DE RECOGO EN TIENDA
function actualizarTotal(recojo, subtotalActual = 0) {
    const envio = recojo ? 0 : 0; // Por ahora envío gratis siempre
    const subtotal = subtotalActual || parseFloat(subtotalText.textContent.replace('S/ ', ''));
    
        if (envioText) envioText.textContent = `S/ ${envio.toFixed(2)}`;
        if (totalText) totalText.textContent = `S/ ${(subtotal + envio).toFixed(2)}`;
    
        // Guarda en localStorage para que el checkout lo lea
        localStorage.setItem('recojo_tienda', recojo ? '1' : '0');
    }

    if (recojoCheckbox) {
        // Aplica si ya estaba marcado antes
        if (localStorage.getItem('recojo_tienda') === '1') {
            recojoCheckbox.checked = true;
            const subtotalActual = parseFloat(subtotalText.textContent.replace('S/ ', ''));
            actualizarTotal(true, subtotalActual);
            
            // Deshabilitar el selector de distritos cuando se restaura el checkbox marcado
            const selectDistrito = document.getElementById('select-distrito');
            if (selectDistrito) {
                selectDistrito.disabled = true;
                selectDistrito.value = ''; // Limpiar selección
            }
        }
}

// Botón continuar compra
// Botón continuar compra - SOLO UN EVENT LISTENER
if (btnContinuarCompra) {
    btnContinuarCompra.addEventListener('click', async function() { // ← AGREGAR async AQUÍ
        try {
            const carritoValido = await validarProductosCarrito(); // ← Ahora funciona
            
            if (carritoValido.length === 0) {
                mostrarNotificacion('⚠️ No hay productos válidos en tu carrito');
                return;
            }
            
            const productosSeleccionados = obtenerProductosSeleccionados(carritoValido);
            
            if (productosSeleccionados.length === 0) {
                mostrarNotificacion('⚠️ Selecciona al menos un producto para continuar');
                return;
            }
            
            // Obtener datos de envío
            const selectDistrito = document.getElementById('select-distrito');
            const recojoCheckbox = document.getElementById('recojoTienda');
            const distritoSeleccionado = selectDistrito ? selectDistrito.value : '';
            const recojoEnTienda = recojoCheckbox ? recojoCheckbox.checked : false;
            
            // Calcular totales
            const subtotal = productosSeleccionados.reduce((sum, item) => sum + (item.precio * item.cantidad), 0);
            const precioEnvio = recojoEnTienda ? 0 : parseFloat(selectDistrito?.selectedOptions[0]?.dataset?.precio || 0);
            const total = subtotal + precioEnvio;
            
            // Preparar datos para enviar
            const datosCheckout = {
                productos: productosSeleccionados,
                subtotal: subtotal,
                precio_envio: precioEnvio,
                total: total,
                distrito_id: distritoSeleccionado,
                recojo_tienda: recojoEnTienda
            };
            
            console.log('📦 Enviando al checkout:', datosCheckout);
            
            // Guardar datos en sesión para el checkout
            const _csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            const response = await fetch('/api/carrito/guardar-checkout', {
                method: 'POST',
                credentials: 'include',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': _csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(datosCheckout)
            });
            
            if (!response.ok) {
                throw new Error('Error al guardar checkout');
            }
            
            // Redirigir al checkout
            window.location.href = '{{ route("checkout.checkoutcl") }}';
            
        } catch (error) {
            console.error('Error en checkout:', error);
            mostrarNotificacion('⚠️ Error al procesar la compra. Intenta nuevamente.');
        }
    });
}

// Función para obtener productos seleccionados
function obtenerProductosSeleccionados(carrito) {
    const checkboxes = document.querySelectorAll('input[name="seleccionados[]"]:checked');
    const productosSeleccionados = [];
    
    console.log('Checkboxes seleccionados:', checkboxes.length);
    console.log('Carrito completo:', carrito);
    
    checkboxes.forEach(checkbox => {
        const productoId = parseInt(checkbox.value);
        const producto = carrito.find(item => item.id === productoId);
        if (producto) {
            console.log('Producto encontrado:', producto);
            productosSeleccionados.push(producto);
        }
    });
    
    console.log('Productos seleccionados para checkout:', productosSeleccionados);
    return productosSeleccionados;
}

// Verificar si el usuario está autenticado y sincronizar si es necesario
// Cargar productos al inicio (ya manejado más abajo)

// Función para sincronizar automáticamente cuando el usuario inicia sesión
let sincronizando = false;
let cargandoDesdeBD = false;

function sincronizarCarritoAutomaticamente() {
    if (sincronizando || cargandoDesdeBD) {
        console.log('⏳ Sincronización omitida (ya en progreso)');
        return;
    }
    
    const carrito = JSON.parse(localStorage.getItem('carrito') || '[]');
    if (carrito.length > 0 && {{ auth()->check() ? 'true' : 'false' }}) {
        sincronizando = true;
        console.log('🔄 Iniciando sincronización...');
        
        const _csrfToken2 = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        fetch('/api/carrito/sincronizar', {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': _csrfToken2,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ carrito: carrito })
        })
        .then(response => {
            if (!response.ok) return;
            return response.json().catch(() => ({}));
        })
        .then(data => {
            if (data && data.success) {
                console.log('✅ Sincronización completa');
                
                // 🔥 SOLUCIÓN: NO recargar desde BD inmediatamente
                // Solo actualizar la vista con el carrito actual
                const carritoActual = JSON.parse(localStorage.getItem('carrito') || '[]');
                mostrarProductosDelCarrito(carritoActual);
                
                sincronizando = false;
            }
        })
        .catch(err => {
            console.error('❌ Error al sincronizar carrito:', err);
            sincronizando = false;
        });
    }
}

// Cargar carrito desde la base de datos (para usuarios autenticados)
function cargarCarritoDesdeDB() {
    if ({{ auth()->check() ? 'true' : 'false' }}) {
        // 🔥 EVITAR CARGA MÚLTIPLE
        if (cargandoDesdeBD) {
            console.log('⏳ Carga desde BD ya en progreso, omitiendo...');
            return;
        }
        
        cargandoDesdeBD = true;
        console.log('📥 Cargando carrito desde BD...');
        
        fetch('/api/carrito/obtener', { 
            credentials: 'same-origin', 
            headers: { 'X-Requested-With': 'XMLHttpRequest' } 
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('✅ Carrito desde DB:', data.carrito.length, 'productos');
                
                if (data.carrito.length > 0) {
                    // 🔥 REEMPLAZAR COMPLETAMENTE el carrito local
                    localStorage.setItem('carrito', JSON.stringify(data.carrito));
                    mostrarProductosDelCarrito(data.carrito);
                    console.log('🔄 Carrito actualizado desde BD');
                } else {
                    console.log('ℹ️ BD vacía, manteniendo carrito local');
                    const carritoLocal = JSON.parse(localStorage.getItem('carrito') || '[]');
                    mostrarProductosDelCarrito(carritoLocal);
                }
            }
        }).catch(error => {
            console.error('❌ Error al cargar desde BD, usando localStorage');
            const carritoLocal = JSON.parse(localStorage.getItem('carrito') || '[]');
            mostrarProductosDelCarrito(carritoLocal);
        })
        .finally(() => {
            cargandoDesdeBD = false; // 🔓 DESBLOQUEAR
        });
    }
}

// Función para agregar producto al carrito (llamada desde el home)
function agregarProductoAlCarrito(producto) {
    const carrito = JSON.parse(localStorage.getItem('carrito') || '[]');

    // Buscar si el producto ya existe en el carrito
    const productoExistente = carrito.find(item => item.id === producto.id);

    if (productoExistente) {
        if (productoExistente.cantidad >= 10) {
            mostrarNotificacion("⚠️ Límite de 10 unidades alcanzado para este producto");
            return;
        }
        productoExistente.cantidad += 1;
    } else {
        carrito.push({
            id: producto.id,
            nombre: producto.nombre,
            descripcion: producto.descripcion,
            precio: producto.precio,
            imagen: producto.imagen || '',
            cantidad: 1
        });
    }

    localStorage.setItem('carrito', JSON.stringify(carrito));

    // 🔄 Si está logueado, sincroniza con backend
    if ({{ auth()->check() ? 'true' : 'false' }}) {
        sincronizarCarritoAutomaticamente();
    }

    mostrarNotificacion("🛒 Producto agregado al carrito");
}

// Función para mostrar notificaciones
function mostrarNotificacion(mensaje) {
    // Crear notificación temporal
    const notificacion = document.createElement('div');
    notificacion.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
    notificacion.textContent = mensaje;
    
    document.body.appendChild(notificacion);
    
    // Remover después de 3 segundos
    setTimeout(() => {
        notificacion.remove();
    }, 3000);
}

// En lugar de usar polling, sincronizamos una sola vez al cargar si el usuario está autenticado
document.addEventListener('DOMContentLoaded', function() {
    limpiarDuplicadosCarrito();
    const estaAutenticado = {{ auth()->check() ? 'true' : 'false' }};
    const carritoLocal = JSON.parse(localStorage.getItem('carrito') || '[]');
    
    console.log('🎯 Inicializando carrito. Autenticado:', estaAutenticado, 'Productos locales:', carritoLocal.length);
    
    // 🔥 FORZAR VALIDACIÓN INICIAL PARA TODOS LOS USUARIOS
    validarProductosCarrito().then(carritoValido => {
        if (carritoValido.length === 0) {
            mostrarCarritoVacio();
        } else {
            // Después de validar, proceder con la lógica normal
            if (estaAutenticado) {
                if (carritoValido.length > 0) {
                    console.log('🔄 Hay productos válidos, sincronizando...');
                    setTimeout(() => {
                        sincronizarCarritoAutomaticamente();
                    }, 500);
                } else {
                    console.log('📥 No hay productos válidos, cargando desde BD...');
                    cargarCarritoDesdeDB();
                }
            } else {
                console.log('👤 Usuario no autenticado, mostrando carrito válido');
                mostrarProductosDelCarrito(carritoValido);
            }
        }
    }).catch(error => {
        console.error('Error validando productos:', error);
        // En caso de error, mostrar carrito sin validar
        if (carritoLocal.length === 0) {
            mostrarCarritoVacio();
        } else {
            mostrarProductosDelCarrito(carritoLocal);
        }
    });
});
document.addEventListener('DOMContentLoaded', async () => {
    try {
        const response = await fetch('/api/distritos');
        if (!response.ok) throw new Error('Respuesta no OK: ' + response.status);
        let distritos = await response.json();

        if (!Array.isArray(distritos)) distritos = [];

        distritos.sort((a, b) => (a.nombre_distr || '').localeCompare(b.nombre_distr || '', 'es', { sensitivity: 'base' }));

        const select = document.getElementById('select-distrito');
        const envioText = document.getElementById('envioText');
        const subtotalText = document.getElementById('subtotal-text');
        const totalText = document.getElementById('totalText');
        const recojoCheckbox = document.getElementById('recojoTienda');
        const botonContinuar = document.getElementById('btn-continuar-compra');

        if (!select) throw new Error('No se encontró el elemento select-distrito.');

        select.innerHTML = '<option value="">Selecciona tu distrito</option>';
        distritos.forEach(d => {
            const option = document.createElement('option');
            option.value = d.id_distrito;
            option.textContent = d.nombre_distr;
            option.dataset.precio = (d.precio_envio !== undefined && d.precio_envio !== null)
                ? parseFloat(d.precio_envio).toFixed(2)
                : '0.00';
            select.appendChild(option);
        });

        function leerSubtotal() {
            try {
                return parseFloat((subtotalText?.textContent || 'S/ 0.00').replace('S/ ', '')) || 0;
            } catch {
                return 0;
            }
        }

function actualizarPrecio() {
    const selectDistrito = document.getElementById('select-distrito');
    const recojoCheckbox = document.getElementById('recojoTienda');
    
    let precioEnvio = 0.0;
    
    // 🔥 CALCULAR ENVÍO CORRECTAMENTE
    if (recojoCheckbox && !recojoCheckbox.checked && selectDistrito && selectDistrito.value) {
        const selectedOption = selectDistrito.options[selectDistrito.selectedIndex];
        precioEnvio = parseFloat(selectedOption?.dataset?.precio || 0);
    }
    
    // Obtener subtotal de productos SELECCIONADOS
    const carrito = JSON.parse(localStorage.getItem('carrito') || '[]');
    const productosSeleccionados = obtenerProductosSeleccionados(carrito);
    const subtotal = productosSeleccionados.reduce((sum, item) => sum + (item.precio * item.cantidad), 0);
    
    const total = subtotal + precioEnvio;

    if (envioText) envioText.textContent = `S/ ${precioEnvio.toFixed(2)}`;
    if (totalText) totalText.textContent = `S/ ${total.toFixed(2)}`;
    if (subtotalText) subtotalText.textContent = `S/ ${subtotal.toFixed(2)}`;
}

        // Evento: cambio de distrito
        select.addEventListener('change', () => {
            actualizarPrecio();
            validarBotonContinuar();
            if (botonContinuar) {
                const distritoSeleccionado = select.value !== '';
                const recojoMarcado = !!(recojoCheckbox && recojoCheckbox.checked);
                botonContinuar.disabled = !(distritoSeleccionado || recojoMarcado);
            }
        });

        // Evento: recojo en tienda
        if (recojoCheckbox) {
            recojoCheckbox.addEventListener('change', () => {
                const checked = recojoCheckbox.checked;

                // Bloquear o habilitar el select de distritos
                select.disabled = checked;
                if (checked) {
                    select.value = ''; // limpiamos selección
                    envioText.textContent = 'S/ 0.00';
                }

                // Guardar el estado en localStorage
                localStorage.setItem('recojo_tienda', checked ? '1' : '0');

                actualizarPrecio();

                // Validar botón de compra
                if (botonContinuar) {
                    const distritoSeleccionado = select.value !== '';
                    const recojoMarcado = recojoCheckbox.checked;
                    botonContinuar.disabled = !(distritoSeleccionado || recojoMarcado);
                }
                validarBotonContinuar(); 
            });
        }

        if (botonContinuar) {
            const distritoSeleccionado = select.value !== '';
            const recojoMarcado = !!(recojoCheckbox && recojoCheckbox.checked);
            botonContinuar.disabled = !(distritoSeleccionado || recojoMarcado);

            botonContinuar.addEventListener('click', (e) => {
            const distritoSeleccionadoNow = select.value !== '';
            const recojoMarcadoNow = !!(recojoCheckbox && recojoCheckbox.checked);
    
            if (!distritoSeleccionadoNow && !recojoMarcadoNow) {
            e.preventDefault();
            mostrarNotificacion('⚠️ Selecciona un distrito de entrega o marca "Recoger pedido en tienda"');
            return;
                }
            });
        }

        actualizarPrecio();

        // Verificar estado inicial del checkbox después de cargar distritos
        verificarEstadoInicialCheckbox();

    } catch (error) {
        console.error('Error cargando distritos:', error);
        const select = document.getElementById('select-distrito');
        if (select) select.innerHTML = '<option>Error al cargar distritos</option>';
    }
});

async function validarProductosCarrito() {
    try {
        const carrito = JSON.parse(localStorage.getItem('carrito') || '[]');
        
        if (carrito.length === 0) return [];

        // Obtener IDs de productos para validar
        const productoIds = carrito.map(item => item.id).join(',');
        
        const response = await fetch(`/api/productos/validar?ids=${productoIds}`);
        
        if (!response.ok) {
            throw new Error('Error al validar productos');
        }
        
        const data = await response.json();
        
        if (!data.success || !data.productos) {
            throw new Error('Respuesta inválida del servidor');
        }
        
        // 🔥 CORRECCIÓN: Filtrar productos con estado "descontinuado"
        const carritoValido = carrito.filter(item => {
            const productoValido = data.productos[item.id];
            
            // Debug: verificar qué datos recibimos
            console.log('Validando producto:', {
                id: item.id,
                nombre: item.nombre,
                productoValido: productoValido,
                estado: productoValido?.estado,
                stock: productoValido?.stock_disponible
            });
            
            return productoValido && 
                   productoValido.estado === 'disponible' && // No "descontinuado"
                   productoValido.stock_disponible >= item.cantidad;
        });
        
        // Si hay diferencias, actualizar el carrito Y LA VISTA
        if (carritoValido.length !== carrito.length) {
            localStorage.setItem('carrito', JSON.stringify(carritoValido));
            
            // 🔥 ACTUALIZAR LA VISTA INMEDIATAMENTE
            if (carritoValido.length === 0) {
                mostrarCarritoVacio();
            } else {
                mostrarProductosDelCarrito(carritoValido);
            }
            
            // Mostrar notificación de productos removidos
            const productosRemovidos = carrito.length - carritoValido.length;
            if (productosRemovidos > 0) {
                mostrarNotificacion(`ℹ️ ${productosRemovidos} producto(s) no disponible(s) fueron removidos del carrito`);
            }
        }
        
        return carritoValido;
        
    } catch (error) {
        console.error('Error validando productos:', error);
        // En caso de error, mantener el carrito actual
        const carrito = JSON.parse(localStorage.getItem('carrito') || '[]');
        return carrito;
    }
}

function validarBotonContinuar() {
    if (!btnContinuarCompra) return;
    
    const carrito = JSON.parse(localStorage.getItem('carrito') || '[]');
    const productosSeleccionados = obtenerProductosSeleccionados(carrito);
    const tieneProductosSeleccionados = productosSeleccionados.length > 0;
    
    if (!tieneProductosSeleccionados) {
        btnContinuarCompra.disabled = true;
        return;
    }
    
    const selectDistrito = document.getElementById('select-distrito');
    const recojoCheckbox = document.getElementById('recojoTienda');
    
    const distritoSeleccionado = selectDistrito ? selectDistrito.value !== '' : false;
    const recojoMarcado = recojoCheckbox ? recojoCheckbox.checked : false;
    
    // 🔥 VALIDACIÓN MEJORADA: Solo habilitar si hay productos SELECCIONADOS Y (distrito seleccionado O recojo en tienda)
    btnContinuarCompra.disabled = !(tieneProductosSeleccionados && (distritoSeleccionado || recojoMarcado));
}

// Función para verificar el estado inicial del checkbox y aplicar la lógica correspondiente
function verificarEstadoInicialCheckbox() {
    const recojoCheckbox = document.getElementById('recojoTienda');
    const selectDistrito = document.getElementById('select-distrito');
    
    if (recojoCheckbox && selectDistrito) {
        // Si el checkbox está marcado, deshabilitar el selector de distritos
        if (recojoCheckbox.checked) {
            selectDistrito.disabled = true;
            selectDistrito.value = '';
        } else {
            selectDistrito.disabled = false;
        }
        
        // Actualizar el estado del botón de continuar compra
        const botonContinuar = document.getElementById('btn-continuar-compra');
        if (botonContinuar) {
            const distritoSeleccionado = selectDistrito.value !== '';
            const recojoMarcado = recojoCheckbox.checked;
            botonContinuar.disabled = !(distritoSeleccionado || recojoMarcado);
        }
    }
}

function actualizarBotonCatalogo(productoId, enCarrito) {
    // Buscar todos los botones en el catálogo
    document.querySelectorAll('button[onclick*="agregarAlCarrito"]').forEach(boton => {
        const onclickText = boton.getAttribute('onclick');
        const match = onclickText && onclickText.match(/agregarAlCarrito\((\d+),/);
        
        if (match && parseInt(match[1]) === productoId) {
            if (enCarrito) {
                // Bloquear botón
                boton.innerHTML = '✅ En carrito';
                boton.disabled = true;
                boton.classList.remove('bg-orange-600', 'hover:bg-orange-700');
                boton.classList.add('bg-green-600', 'cursor-not-allowed');
                boton.removeAttribute('onclick');
            } else {
                // Restaurar botón
                boton.innerHTML = '🛒 Agregar al carrito';
                boton.disabled = false;
                boton.classList.remove('bg-green-600', 'cursor-not-allowed');
                boton.classList.add('bg-orange-600', 'hover:bg-orange-700');
                // Aquí necesitarías restaurar el onclick, pero es complejo
                // Mejor recargar la página o usar event listeners en lugar de onclick
            }
        }
    });
}

function fusionarCarritos(local, bd) {
    console.log('🔄 Iniciando fusión de carritos:', {
        local: local.map(i => ({id: i.id, cantidad: i.cantidad})),
        bd: bd.map(i => ({id: i.id, cantidad: i.cantidad}))
    });
    
    // Crear un Map para evitar duplicados
    const carritoMap = new Map();
    
    // Primero agregar todos los items de BD
    bd.forEach(item => {
        carritoMap.set(item.id, { ...item, fuente: 'bd' });
    });
    
    // Luego agregar items de local SOLO si no existen en BD
    local.forEach(item => {
        if (!carritoMap.has(item.id)) {
            carritoMap.set(item.id, { ...item, fuente: 'local' });
        }
        // Si ya existe en BD, NO agregar desde local (evitar duplicados)
    });
    
    const fusionado = Array.from(carritoMap.values());
    
    console.log('✅ Fusión completada:', {
        fusionado: fusionado.map(i => ({id: i.id, cantidad: i.cantidad, fuente: i.fuente})),
        totalItems: fusionado.length
    });
    
    return fusionado;
}
function limpiarDuplicadosCarrito() {
    let carrito = JSON.parse(localStorage.getItem('carrito') || '[]');
    
    // Usar Map para eliminar duplicados por ID
    const carritoUnico = Array.from(
        new Map(carrito.map(item => [item.id, item])).values()
    );
    
    if (carrito.length !== carritoUnico.length) {
        localStorage.setItem('carrito', JSON.stringify(carritoUnico));
        console.log('🔄 Duplicados eliminados:', carrito.length - carritoUnico.length);
    }
    
    return carritoUnico;
}

function mostrarProductosRemovidos(productosRemovidos) {
    if (productosRemovidos.length === 0) return;
    
    const mensaje = `Los siguientes productos ya no están disponibles:\n${productosRemovidos.map(p => `• ${p.nombre}`).join('\n')}`;
    
    // Puedes usar un modal más elegante en lugar de alert
    if (confirm(mensaje + '\n\n¿Deseas continuar con tu compra?')) {
        // El usuario acepta continuar
        cargarProductosDelCarrito();
    } else {
        // El usuario quiere volver a la tienda
        window.location.href = '{{ route('home') }}';
    }
}
</script>



