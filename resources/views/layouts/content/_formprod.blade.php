<!-- _form.blade.php -->

<form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
  @csrf

  <!-- Nombre del producto -->
  <div>
    <label class="block text-sm font-medium text-gray-700">Nombre</label>
    <input type="text" name="nombre_producto" class="w-full px-4 py-2 border rounded" required>
  </div>

  <!-- Descripción -->
  <div>
    <label class="block text-sm font-medium text-gray-700">Descripción</label>
    <textarea name="descripcion_producto" rows="3" class="w-full px-4 py-2 border rounded" required></textarea>
  </div>

  <!-- Imagen -->
  <div>
    <label class="block text-sm font-medium text-gray-700">Imagen</label>
    <input type="file" name="imagen" accept="image/*" class="w-full">
  </div>

  <!-- Categoría -->
  <div>
    <label class="block text-sm font-medium text-gray-700">Categoría</label>
    <select name="id_categoria" class="w-full px-4 py-2 border rounded">
      @foreach ($categorias as $cat)
        <option value="{{ $cat->id_categoria }}">{{ $cat->nombre_cat }}</option>
      @endforeach
    </select>
  </div>

  <!-- Marca -->
  <div>
    <label class="block text-sm font-medium text-gray-700">Marca</label>
    <input type="text" name="marca" class="w-full px-4 py-2 border rounded">
  </div>

  <!-- Precio -->
  <div>
    <label class="block text-sm font-medium text-gray-700">Precio</label>
    <input   type="number" name="precio_producto" step="0.01" min="0.01" class="w-full px-4 py-2 border rounded" required oninput="if(this.value < 0) this.value = '';">
  </div>

  <!-- Stock -->
  <div>
    <label class="block text-sm font-medium text-gray-700">Stock</label>
    <input type="number" name="stock_producto" step="0.00" min="0.00" class="w-full px-4 py-2 border rounded" required oninput="if(this.value < 0) this.value = '';">
  </div>

  <!-- Botón -->
  <div class="text-right">
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
      Guardar
    </button>
  </div>
</form>
