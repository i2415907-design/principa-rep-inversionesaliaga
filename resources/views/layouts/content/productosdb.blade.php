@php
    use Illuminate\Support\Str;
@endphp

<div class="p-6 bg-gray-100 min-h-screen">
  <!-- Mensajes de éxito/error -->
  @if(session('success'))
    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
      {{ session('success') }}
    </div>
  @endif

  @if(session('error'))
    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
      {{ session('error') }}
    </div>
  @endif

  <!-- Buscador y botón de añadir -->
  <div class="flex flex-col sm:flex-row justify-between items-center mb-4 gap-4">
    <div class="flex flex-col w-full sm:max-w-md">
      <div class="relative">
        <input
          type="text"
          id="buscadorProductos"
          placeholder="Buscar por nombre, descripción, marca, categoría, precio o stock..."
          class="w-full px-4 py-2 pl-10 pr-10 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-indigo-400"
          onkeyup="filtrarProductos()"
        />
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
          <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
        </div>
        <button
          type="button"
          id="limpiarBusqueda"
          onclick="limpiarBusqueda()"
          class="absolute inset-y-0 right-0 pr-3  items-center text-gray-400 hover:text-gray-600 hidden"
        >
          <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
      <div id="contadorResultados" class="text-sm text-gray-500 mt-1"></div>
    </div>
    
    <button
      onclick="abrirModal()"
      class="flex items-center justify-center gap-1 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 w-full sm:w-auto"
      title="Añadir producto"
    >
      <!-- Icono Plus -->
      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
      </svg>
      Añadir
    </button>
  </div>
{{-- resources/views/layouts/content/_formprod.blade.php --}}
<form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <!-- Tu formulario aquí -->
</form>

  <!-- Tabla para escritorio -->
  <div class="overflow-x-auto bg-white shadow rounded-lg hidden sm:block">
    <table class="min-w-full table-auto">
      <thead class="bg-gray-200 text-gray-700 uppercase text-sm font-semibold">
        <tr>
          <th class="px-4 py-3">Imagen</th>
          <th class="px-4 py-3">Nombre</th>
          <th class="px-4 py-3">Descripción</th>
          <th class="px-4 py-3">ID</th>
          <th class="px-4 py-3">Categoría</th>
          <th class="px-4 py-3">Marca</th>
          <th class="px-4 py-3">Precio</th>
          <th class="px-4 py-3">Stock</th>
          <th class="px-4 py-3">Acciones</th>
        </tr>
      </thead>
      <tbody class="text-gray-600 divide-y divide-gray-200">
        @foreach ($productos as $producto)
        <tr class="fila-producto" data-nombre="{{ strtolower($producto->nombre_producto) }}" data-descripcion="{{ strtolower($producto->descripcion_producto) }}" data-categoria="{{ strtolower($producto->categoria->nombre_cat ?? '') }}" data-marca="{{ strtolower($producto->marca ?? '') }}" data-precio="{{ $producto->precio_producto }}" data-stock="{{ $producto->stock_producto }}">
<td class="px-4 py-3 text-center">
@if($producto->imagen && !empty(trim($producto->imagen)))
    @php
        $filename = basename($producto->imagen);
    @endphp
    <img src="{{ route('images.products', ['filename' => $filename]) }}" alt="Imagen del producto" class="w-12 h-12 object-cover rounded">
@else
    --
@endif
</td>
          <td class="px-4 py-3">{{ $producto->nombre_producto }}</td>
          <td class="px-4 py-3">{{ Str::limit($producto->descripcion_producto, 30) }}</td>
          <td class="px-4 py-3">#{{ $producto->id_producto }}</td>
          <td class="px-4 py-3">{{ $producto->categoria->nombre_cat ?? 'sin categoría' }}</td>
          <td class="px-4 py-3">{{ $producto->marca }}</td>
          <td class="px-4 py-3">S/ {{ number_format($producto->precio_producto, 2) }}</td>
          <td class="px-4 py-3">{{ $producto->stock_producto }}</td>
        <td class="px-4 py-3">
            <x-botones-producto :producto="$producto" />
        </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <!-- Tarjetas responsivas para celular -->
  <div class="sm:hidden space-y-4">
    @foreach ($productos as $producto)
    <div class="tarjeta-producto bg-white rounded-lg shadow p-4" data-nombre="{{ strtolower($producto->nombre_producto) }}" data-descripcion="{{ strtolower($producto->descripcion_producto) }}" data-categoria="{{ strtolower($producto->categoria->nombre_cat ?? '') }}" data-marca="{{ strtolower($producto->marca ?? '') }}" data-precio="{{ $producto->precio_producto }}" data-stock="{{ $producto->stock_producto }}">
      <div class="flex justify-between items-center mb-2">
        <h3 class="font-bold text-lg">{{ $producto->nombre_producto }}</h3>
        <span class="text-sm text-gray-500">#{{ $producto->id_producto }}</span>
      </div>
@if($producto->imagen && !empty(trim($producto->imagen)))
    @php
        $filename = basename($producto->imagen);
    @endphp
    <img src="{{ route('images.products', ['filename' => $filename]) }}" alt="Imagen del producto" class="w-full h-32 object-cover rounded mb-2">
@endif
      <p class="text-sm text-gray-700"><strong>Descripción:</strong> {{ Str::limit($producto->descripcion_producto, 100) }}</p>
      <p class="text-sm text-gray-700"><strong>Categoría:</strong> {{ $producto->categoria->nombre_cat ?? 'sin categoría' }}</p>
      <p class="text-sm text-gray-700"><strong>Marca:</strong> {{ $producto->marca }}</p>
      <p class="text-sm text-gray-700"><strong>Precio:</strong> S/ {{ number_format($producto->precio_producto, 2) }}</p>
      <p class="text-sm text-gray-700"><strong>Stock:</strong> {{ $producto->stock_producto }}</p>
      <x-botones-producto :producto="$producto" align="justify-end" />

    </div>
    @endforeach
  </div>
</div>
<!-- Modal para agregar -->
<div id="modalAgregar" class="fixed inset-0 bg-black bg-opacity-50  flex items-center justify-center z-50 hidden">
  <div class="bg-white rounded-lg shadow-lg w-full max-w-xl p-6 relative">
    <button onclick="cerrarModal()" class="absolute top-2 right-2 text-gray-600 hover:text-red-600">
      ✕
    </button>
    <h2 class="text-xl font-semibold mb-4">Añadir Producto</h2>
    @include('layouts.content._formprod', ['categorias' => $categorias])
  </div>
</div>

<!-- Modal para editar -->
<div id="modalEditar" class="fixed inset-0 bg-black bg-opacity-50  flex items-center justify-center z-50 hidden">
  <div class="bg-white rounded-lg shadow-lg w-full max-w-xl p-6 relative">
    <button onclick="cerrarModalEditar()" class="absolute top-2 right-2 text-gray-600 hover:text-red-600">
      ✕
    </button>
    <h2 class="text-xl font-semibold mb-4">Editar Producto</h2>
    @include('layouts.content._formprod_edit', ['categorias' => $categorias])
  </div>
</div>

<!-- Modal para eliminar -->
<div id="modalEliminar" class="fixed inset-0 bg-black bg-opacity-50  flex items-center justify-center z-50 hidden">
  <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
    <button onclick="cerrarModalEliminar()" class="absolute top-2 right-2 text-gray-600 hover:text-red-600">
      ✕
    </button>
    <div class="text-center">
      <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
        <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
        </svg>
      </div>
      <h3 class="text-lg font-medium text-gray-900 mb-2">¿Estás seguro?</h3>
      <p class="text-sm text-gray-500 mb-6">
        ¿Realmente quieres eliminar el producto "<span id="nombreProductoEliminar" class="font-semibold"></span>"?
        Esta acción no se puede deshacer.
      </p>
      <form id="formEliminarProducto" method="POST" class="flex justify-center gap-3">
        @csrf
        @method('DELETE')
        <button type="button" onclick="cerrarModalEliminar()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200">
          Cancelar
        </button>
        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700">
          Eliminar
        </button>
      </form>
    </div>
  </div>
</div>

<script>
  function abrirModal() {
    document.getElementById('modalAgregar').classList.remove('hidden');
  }

  function cerrarModal() {
    document.getElementById('modalAgregar').classList.add('hidden');
  }

  function abrirModalEditar(id, nombre, descripcion, categoria, marca, precio, stock) {
    // Llenar el formulario con los datos del producto
    document.getElementById('edit_id_producto').value = id;
    document.getElementById('edit_nombre_producto').value = nombre;
    document.getElementById('edit_descripcion_producto').value = descripcion;
    document.getElementById('edit_id_categoria').value = categoria;
    document.getElementById('edit_marca').value = marca;
    document.getElementById('edit_precio_producto').value = precio;
    document.getElementById('edit_stock_producto').value = stock;
    
    // Actualizar la acción del formulario
    document.getElementById('formEditarProducto').action = `/productos/${id}`;
    
    // Mostrar el modal
    document.getElementById('modalEditar').classList.remove('hidden');
  }

  function cerrarModalEditar() {
    document.getElementById('modalEditar').classList.add('hidden');
  }

  function abrirModalEliminar(id, nombre) {
    // Mostrar el nombre del producto en el modal
    document.getElementById('nombreProductoEliminar').textContent = nombre;
    
    // Actualizar la acción del formulario
    document.getElementById('formEliminarProducto').action = `/productos/${id}`;
    
    // Mostrar el modal
    document.getElementById('modalEliminar').classList.remove('hidden');
  }

  function cerrarModalEliminar() {
    document.getElementById('modalEliminar').classList.add('hidden');
  }

  // Función para filtrar productos
  function filtrarProductos() {
    const busqueda = document.getElementById('buscadorProductos').value.toLowerCase();
    const botonLimpiar = document.getElementById('limpiarBusqueda');
    
    // Mostrar/ocultar botón de limpiar
    if (busqueda.length > 0) {
      botonLimpiar.classList.remove('hidden');
    } else {
      botonLimpiar.classList.add('hidden');
    }
    
    // Filtrar filas de la tabla (escritorio)
    const filas = document.querySelectorAll('.fila-producto');
    filas.forEach(fila => {
      const nombre = fila.getAttribute('data-nombre') || '';
      const descripcion = fila.getAttribute('data-descripcion') || '';
      const categoria = fila.getAttribute('data-categoria') || '';
      const marca = fila.getAttribute('data-marca') || '';
      const precio = fila.getAttribute('data-precio') || '';
      const stock = fila.getAttribute('data-stock') || '';
      
      const coincide = 
        nombre.includes(busqueda) ||
        descripcion.includes(busqueda) ||
        categoria.includes(busqueda) ||
        marca.includes(busqueda) ||
        precio.toString().includes(busqueda) ||
        stock.toString().includes(busqueda);
      
      fila.style.display = coincide ? '' : 'none';
    });
    
    // Filtrar tarjetas móviles
    const tarjetas = document.querySelectorAll('.tarjeta-producto');
    tarjetas.forEach(tarjeta => {
      const nombre = tarjeta.getAttribute('data-nombre') || '';
      const descripcion = tarjeta.getAttribute('data-descripcion') || '';
      const categoria = tarjeta.getAttribute('data-categoria') || '';
      const marca = tarjeta.getAttribute('data-marca') || '';
      const precio = tarjeta.getAttribute('data-precio') || '';
      const stock = tarjeta.getAttribute('data-stock') || '';
      
      const coincide = 
        nombre.includes(busqueda) ||
        descripcion.includes(busqueda) ||
        categoria.includes(busqueda) ||
        marca.includes(busqueda) ||
        precio.toString().includes(busqueda) ||
        stock.toString().includes(busqueda);
      
      tarjeta.style.display = coincide ? '' : 'none';
    });
    
    // Mostrar mensaje si no hay resultados
    mostrarMensajeSinResultados();
    
    // Actualizar contador de resultados
    actualizarContadorResultados();
  }

  // Función para limpiar la búsqueda
  function limpiarBusqueda() {
    document.getElementById('buscadorProductos').value = '';
    document.getElementById('limpiarBusqueda').className = 'absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 hidden';
    
    // Mostrar todos los productos
    const filas = document.querySelectorAll('.fila-producto');
    const tarjetas = document.querySelectorAll('.tarjeta-producto');
    
    filas.forEach(fila => {
      fila.style.display = '';
    });
    
    tarjetas.forEach(tarjeta => {
      tarjeta.style.display = '';
    });
    
    // Remover mensaje de no resultados
    const mensajeAnterior = document.getElementById('mensajeSinResultados');
    if (mensajeAnterior) {
      mensajeAnterior.remove();
    }
    
    // Actualizar contador de resultados
    actualizarContadorResultados();
  }

  // Función para actualizar el contador de resultados
  function actualizarContadorResultados() {
    const busqueda = document.getElementById('buscadorProductos').value.toLowerCase();
    const filasVisibles = document.querySelectorAll('.fila-producto:not([style*="display: none"])');
    const contador = document.getElementById('contadorResultados');
    
    if (busqueda.length > 0) {
      const totalProductos = document.querySelectorAll('.fila-producto').length;
      contador.textContent = `Mostrando ${filasVisibles.length} de ${totalProductos} productos`;
    } else {
      contador.textContent = '';
    }
  }

  // Función para mostrar mensaje cuando no hay resultados
  function mostrarMensajeSinResultados() {
    const busqueda = document.getElementById('buscadorProductos').value.toLowerCase();
    const filasVisibles = document.querySelectorAll('.fila-producto:not([style*="display: none"])');
    const tarjetasVisibles = document.querySelectorAll('.tarjeta-producto:not([style*="display: none"])');
    
    // Remover mensaje anterior si existe
    const mensajeAnterior = document.getElementById('mensajeSinResultados');
    if (mensajeAnterior) {
      mensajeAnterior.remove();
    }
    
    // Si hay búsqueda pero no hay resultados, mostrar mensaje
    if (busqueda && filasVisibles.length === 0 && tarjetasVisibles.length === 0) {
      const tabla = document.querySelector('.overflow-x-auto');
      const tarjetasContainer = document.querySelector('.sm\\:hidden');
      
      const mensaje = document.createElement('div');
      mensaje.id = 'mensajeSinResultados';
      mensaje.className = 'text-center py-8 text-gray-500';
      mensaje.innerHTML = `
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">No se encontraron productos</h3>
        <p class="mt-1 text-sm text-gray-500">Intenta con otros términos de búsqueda.</p>
      `;
      
      if (window.innerWidth >= 640) { // Desktop
        tabla.appendChild(mensaje);
      } else { // Mobile
        tarjetasContainer.appendChild(mensaje);
      }
    }
  }

  // Limpiar búsqueda al cargar la página
  document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('buscadorProductos').value = '';
  });
</script>
