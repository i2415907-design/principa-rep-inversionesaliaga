<!-- _formprod_edit.blade.php - Formulario para editar productos -->

<form id="formEditarProducto" action="" method="POST" enctype="multipart/form-data" class="space-y-4">
  @csrf
  @method('PUT')
  
  <!-- ID del producto (hidden) -->
  <input type="hidden" id="edit_id_producto" name="id_producto">

  <!-- Nombre del producto -->
  <div>
    <label class="block text-sm font-medium text-gray-700">Nombre</label>
    <input type="text" id="edit_nombre_producto" name="nombre_producto" class="w-full px-4 py-2 border rounded" required>
    @error('nombre_producto')
      <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
  </div>

  <!-- Descripción -->
  <div>
    <label class="block text-sm font-medium text-gray-700">Descripción</label>
    <textarea id="edit_descripcion_producto" name="descripcion_producto" rows="3" class="w-full px-4 py-2 border rounded" required></textarea>
    @error('descripcion_producto')
      <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
  </div>

  <!-- Imagen -->
  <div>
    <label class="block text-sm font-medium text-gray-700">Imagen</label>
    <input type="file" name="imagen" accept="image/*" class="w-full">
    <small class="text-gray-500">Deja vacío para mantener la imagen actual</small>
  </div>

  <!-- Categoría -->
  <div>
    <label class="block text-sm font-medium text-gray-700">Categoría</label>
    <select id="edit_id_categoria" name="id_categoria" class="w-full px-4 py-2 border rounded" required>
      @foreach ($categorias as $cat)
        <option value="{{ $cat->id_categoria }}">{{ $cat->nombre_cat }}</option>
      @endforeach
    </select>
    @error('id_categoria')
      <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
  </div>

  <!-- Marca -->
  <div>
    <label class="block text-sm font-medium text-gray-700">Marca</label>
    <input type="text" id="edit_marca" name="marca" class="w-full px-4 py-2 border rounded" required>
    @error('marca')
      <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
  </div>

  <!-- Precio -->
  <div>
    <label class="block text-sm font-medium text-gray-700">Precio</label>
    <input type="number" id="edit_precio_producto" name="precio_producto" step="0.01" min="0.01" class="w-full px-4 py-2 border rounded" required oninput="if(this.value < 0) this.value = '';">
    @error('precio_producto')
      <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
  </div>

  <!-- Stock -->
  <div>
    <label class="block text-sm font-medium text-gray-700">Stock</label>
    <input type="number" id="edit_stock_producto" name="stock_producto" step="0.00" min="0.00" class="w-full px-4 py-2 border rounded" required oninput="if(this.value < 0) this.value = '';">
    @error('stock_producto')
      <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
  </div>

  <!-- Botones -->
  <div class="flex justify-end gap-2">
    <button type="button" onclick="cerrarModalEditar()" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
      Cancelar
    </button>
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
      Actualizar
    </button>
  </div>
</form> 