<!-- En el head de tu layout (agrega esta línea junto a las que ya tienes) -->
<script src="https://cdn.sheetjs.com/xlsx-0.20.2/package/dist/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<div x-data="reportes()">
    <!-- PESTAÑAS (sin cambios) -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-4 flex flex-wrap gap-2">
        <button @click="currentTab = 'pedidos'" :class="{'bg-blue-600 text-white': currentTab === 'pedidos', 'bg-gray-200 text-gray-700 hover:bg-gray-300': currentTab !== 'pedidos'}" class="px-4 py-2 text-sm rounded-md font-semibold transition">Pedidos</button>
        <button @click="currentTab = 'ventas'" :class="{'bg-blue-600 text-white': currentTab === 'ventas', 'bg-gray-200 text-gray-700 hover:bg-gray-300': currentTab !== 'ventas'}" class="px-4 py-2 text-sm rounded-md font-semibold transition">Ventas</button>
        <button @click="currentTab = 'inventario'" :class="{'bg-blue-600 text-white': currentTab === 'inventario', 'bg-gray-200 text-gray-700 hover:bg-gray-300': currentTab !== 'inventario'}" class="px-4 py-2 text-sm rounded-md font-semibold transition">Inventario</button>
        <button @click="currentTab = 'clientes'" :class="{'bg-blue-600 text-white': currentTab === 'clientes', 'bg-gray-200 text-gray-700 hover:bg-gray-300': currentTab !== 'clientes'}" class="px-4 py-2 text-sm rounded-md font-semibold transition">Clientes</button>
        <button @click="currentTab = 'top'" :class="{'bg-blue-600 text-white': currentTab === 'top', 'bg-gray-200 text-gray-700 hover:bg-gray-300': currentTab !== 'top'}" class="px-4 py-2 text-sm rounded-md font-semibold transition">TOP 20 Productos</button>
    </div>

    <!-- ENCABEZADO CON BOTONES DE EXPORTACIÓN (se han añadido Excel y CSV) -->
    <div class="bg-white p-4 rounded-lg shadow-md mb-4">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="flex flex-col lg:flex-row lg:items-center gap-4">
                <!-- TÍTULOS DE PESTAÑAS (sin cambios) -->
                <template x-if="currentTab === 'top'">
                    <div><h2 class="text-lg font-semibold text-gray-800">📊 TOP 20 Productos Más Vendidos</h2><p class="text-sm text-gray-600 mt-1">Ranking de productos por cantidad de ventas</p></div>
                </template>
                <template x-if="currentTab === 'clientes'">
                    <div><h2 class="text-lg font-semibold text-gray-800">👥 Mejores Clientes</h2><p class="text-sm text-gray-600 mt-1">Ranking de clientes por compras realizadas</p></div>
                </template>
                <template x-if="currentTab === 'inventario'">
                    <div><h2 class="text-lg font-semibold text-gray-800">📦 Inventario de Productos</h2><p class="text-sm text-gray-600 mt-1">Estado actual del stock y productos</p></div>
                </template>
                <template x-if="currentTab === 'ventas'">
                    <div><h2 class="text-lg font-semibold text-gray-800">💰 Reporte de Ventas</h2><p class="text-sm text-gray-600 mt-1">Historial detallado de todas las ventas</p></div>
                </template>
                <template x-if="currentTab === 'pedidos'">
                    <div><h2 class="text-lg font-semibold text-gray-800">🚚 Gestión de Pedidos</h2><p class="text-sm text-gray-600 mt-1">Seguimiento y estado de todos los pedidos</p></div>
                </template>

                <!-- FILTROS (sin cambios) -->
                <template x-if="currentTab === 'clientes'">
                    <div class="flex flex-wrap items-center gap-2">
                        <input type="text" x-model="filtrosClientes.busqueda" placeholder="Buscar por nombre, apellido o DNI..." class="px-3 py-2 border border-gray-300 rounded-md text-sm w-full lg:w-64" @keyup.enter="aplicarFiltrosClientes()"/>
                        <input type="number" x-model="filtrosClientes.min_compras" placeholder="Mín. compras" class="px-3 py-2 border border-gray-300 rounded-md text-sm w-full lg:w-32" @keyup.enter="aplicarFiltrosClientes()"/>
                        <button @click="aplicarFiltrosClientes()" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition text-sm">Aplicar</button>
                        <button @click="limpiarFiltrosClientes()" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition text-sm">Limpiar</button>
                    </div>
                </template>
                <template x-if="currentTab === 'inventario'">
                    <div class="flex flex-wrap items-center gap-2">
                        <input type="text" x-model="filtrosInventario.producto" placeholder="Buscar producto..." class="px-3 py-2 border border-gray-300 rounded-md text-sm w-full lg:w-64" @keyup.enter="aplicarFiltrosInventario()"/>
                        <select x-model="filtrosInventario.estado" class="px-3 py-2 border border-gray-300 rounded-md text-sm w-full lg:w-40"><option value="">Todos los estados</option><option value="disponible">Disponible</option><option value="poco_stock">Poco stock</option><option value="agotado">Agotado</option><option value="descontinuado">Descontinuado</option></select>
                        <input type="number" x-model="filtrosInventario.stock_minimo" placeholder="Stock mínimo" class="px-3 py-2 border border-gray-300 rounded-md text-sm w-full lg:w-32" @keyup.enter="aplicarFiltrosInventario()"/>
                        <button @click="aplicarFiltrosInventario()" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition text-sm">Aplicar</button>
                        <button @click="limpiarFiltrosInventario()" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition text-sm">Limpiar</button>
                    </div>
                </template>
                <template x-if="currentTab === 'ventas'">
                    <div class="flex flex-wrap items-center gap-2">
                        <input type="date" x-model="filtrosVentas.fecha" class="px-3 py-2 border border-gray-300 rounded-md text-sm w-full lg:w-40"/>
                        <input type="text" x-model="filtrosVentas.cliente" placeholder="Buscar cliente..." class="px-3 py-2 border border-gray-300 rounded-md text-sm w-full lg:w-64" @keyup.enter="aplicarFiltrosVentas()"/>
                        <input type="text" x-model="filtrosVentas.producto" placeholder="Buscar producto..." class="px-3 py-2 border border-gray-300 rounded-md text-sm w-full lg:w-64" @keyup.enter="aplicarFiltrosVentas()"/>
                        <button @click="aplicarFiltrosVentas()" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition text-sm">Aplicar</button>
                        <button @click="limpiarFiltrosVentas()" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition text-sm">Limpiar</button>
                    </div>
                </template>
                <template x-if="currentTab === 'pedidos'">
                    <div class="flex flex-wrap items-center gap-2">
                        <input type="date" x-model="filtrosPedidos.fecha" class="px-3 py-2 border border-gray-300 rounded-md text-sm w-full lg:w-40"/>
                        <select x-model="filtrosPedidos.estado" class="px-3 py-2 border border-gray-300 rounded-md text-sm w-full lg:w-40"><option value="">Todos los estados</option><option value="pendiente">Pendiente</option><option value="enviado">Enviado</option><option value="entregado">Entregado</option></select>
                        <input type="text" x-model="filtrosPedidos.cliente" placeholder="Buscar cliente..." class="px-3 py-2 border border-gray-300 rounded-md text-sm w-full lg:w-64" @keyup.enter="aplicarFiltrosPedidos()"/>
                        <button @click="aplicarFiltrosPedidos()" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition text-sm">Aplicar</button>
                        <button @click="limpiarFiltrosPedidos()" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition text-sm">Limpiar</button>
                    </div>
                </template>
            </div>

            <!-- GRUPO DE BOTONES DE EXPORTACIÓN (PDF, EXCEL, CSV) -->
            <div class="flex justify-end gap-2">
                <!-- TOP productos -->
                <template x-if="currentTab === 'top' && !loading && topProductos.length > 0">
                    <div class="flex gap-2">
                        <button @click="exportarPDF()" class="px-3 py-2 text-sm bg-red-600 text-white rounded hover:bg-red-700 flex items-center gap-1">📄 PDF</button>
                        <button @click="exportarExcel()" class="px-3 py-2 text-sm bg-green-600 text-white rounded hover:bg-green-700 flex items-center gap-1">📊 Excel</button>
                        <button @click="exportarCSV()" class="px-3 py-2 text-sm bg-blue-600 text-white rounded hover:bg-blue-700 flex items-center gap-1">📃 CSV</button>
                    </div>
                </template>

                <!-- Clientes -->
                <template x-if="currentTab === 'clientes' && !loading && clientes.length > 0">
                    <div class="flex gap-2">
                        <button @click="exportarPDFClientes()" class="px-3 py-2 text-sm bg-red-600 text-white rounded hover:bg-red-700">📄 PDF</button>
                        <button @click="exportarExcel()" class="px-3 py-2 text-sm bg-green-600 text-white rounded hover:bg-green-700">📊 Excel</button>
                        <button @click="exportarCSV()" class="px-3 py-2 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">📃 CSV</button>
                    </div>
                </template>

                <!-- Inventario -->
                <template x-if="currentTab === 'inventario' && !loading && inventario.length > 0">
                    <div class="flex gap-2">
                        <button @click="exportarPDFInventario()" class="px-3 py-2 text-sm bg-red-600 text-white rounded hover:bg-red-700">📄 PDF</button>
                        <button @click="exportarExcel()" class="px-3 py-2 text-sm bg-green-600 text-white rounded hover:bg-green-700">📊 Excel</button>
                        <button @click="exportarCSV()" class="px-3 py-2 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">📃 CSV</button>
                    </div>
                </template>

                <!-- Ventas -->
                <template x-if="currentTab === 'ventas' && !loading && ventas.length > 0">
                    <div class="flex gap-2">
                        <button @click="exportarPDFVentas()" class="px-3 py-2 text-sm bg-red-600 text-white rounded hover:bg-red-700">📄 PDF</button>
                        <button @click="exportarExcel()" class="px-3 py-2 text-sm bg-green-600 text-white rounded hover:bg-green-700">📊 Excel</button>
                        <button @click="exportarCSV()" class="px-3 py-2 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">📃 CSV</button>
                    </div>
                </template>

                <!-- Pedidos -->
                <template x-if="currentTab === 'pedidos' && !loading && pedidos.length > 0">
                    <div class="flex gap-2">
                        <button @click="exportarPDFPedidos()" class="px-3 py-2 text-sm bg-red-600 text-white rounded hover:bg-red-700">📄 PDF</button>
                        <button @click="exportarExcel()" class="px-3 py-2 text-sm bg-green-600 text-white rounded hover:bg-green-700">📊 Excel</button>
                        <button @click="exportarCSV()" class="px-3 py-2 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">📃 CSV</button>
                    </div>
                </template>

                <!-- Deshabilitado para otras pestañas -->
                <template x-if="currentTab !== 'top' && currentTab !== 'clientes' && currentTab !== 'inventario' && currentTab !== 'ventas' && currentTab !== 'pedidos'">
                    <button class="px-3 py-2 text-sm bg-gray-400 text-white rounded cursor-not-allowed" disabled>Exportar</button>
                </template>
            </div>
        </div>
    </div>

    <!-- CONTENIDO DE PESTAÑAS (exactamente igual, sin cambios) -->
    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <!-- TOP productos (sin cambios) -->
        <div x-show="currentTab === 'top'">
            <div x-show="loading" class="p-8 text-center"><div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div><p class="mt-2 text-gray-600">Cargando TOP 20 productos...</p></div>
            <div x-show="!loading && topProductos.length > 0" class="hidden sm:block">
                <table class="min-w-full table-auto"><thead class="bg-gray-200 text-gray-700 uppercase text-xs font-semibold"><tr><th class="px-4 py-3">#</th><th class="px-4 py-3">Código</th><th class="px-4 py-3">Producto</th><th class="px-4 py-3">Cantidad Vendida</th><th class="px-4 py-3">Fecha Última Venta</th><th class="px-4 py-3">Ingresos Generados</th></tr></thead><tbody class="text-gray-600 divide-y divide-gray-200 text-sm"><template x-for="(producto, index) in topProductos" :key="producto.codigo"><tr class="hover:bg-gray-50"><td class="px-4 py-3 text-center"><span x-text="index + 1" :class="{'bg-yellow-400 text-white px-2 py-1 rounded-full text-xs': index === 0,'bg-gray-300 text-gray-700 px-2 py-1 rounded-full text-xs': index === 1,'bg-orange-400 text-white px-2 py-1 rounded-full text-xs': index === 2,'text-gray-500': index > 2}"></span></td><td class="px-4 py-3 text-center font-mono text-sm" x-text="producto.codigo"></td><td class="px-4 py-3 font-medium" x-text="producto.producto"></td><td class="px-4 py-3 text-center font-semibold text-blue-600" x-text="producto.cantidad_vendida"></td><td class="px-4 py-3 text-sm" x-text="formatoFecha(producto.fecha_ultima_venta)"></td><td class="px-4 py-3 font-semibold text-green-600" x-text="formatoMoneda(producto.ingresos_generados)"></td></tr></template></tbody></table>
            </div>
            <div x-show="!loading && topProductos.length > 0" class="sm:hidden space-y-4 p-4"><template x-for="(producto, index) in topProductos" :key="producto.codigo"><div class="bg-white rounded-lg shadow p-4 border"><div class="flex justify-between items-start mb-2"><div class="flex items-center gap-2"><span x-text="index + 1" :class="{'bg-yellow-400 text-white px-2 py-1 rounded-full text-sm font-bold': index === 0,'bg-gray-300 text-gray-700 px-2 py-1 rounded-full text-sm font-bold': index === 1,'bg-orange-400 text-white px-2 py-1 rounded-full text-sm font-bold': index === 2,'bg-gray-200 text-gray-600 px-2 py-1 rounded-full text-sm': index > 2}"></span><h3 class="font-bold text-lg" x-text="producto.producto"></h3></div><span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-semibold" x-text="producto.codigo"></span></div><div class="grid grid-cols-2 gap-3 text-sm text-gray-700"><div class="text-center"><div class="text-gray-500 text-xs">Vendidos</div><div class="font-bold text-blue-600 text-lg" x-text="producto.cantidad_vendida"></div></div><div class="text-center"><div class="text-gray-500 text-xs">Última venta</div><div class="font-medium" x-text="formatoFecha(producto.fecha_ultima_venta)"></div></div><div class="col-span-2 text-center pt-2 border-t"><div class="text-gray-500 text-xs">Ingresos totales</div><div class="font-bold text-green-600 text-lg" x-text="formatoMoneda(producto.ingresos_generados)"></div></div></div></div></template></div>
            <div x-show="!loading && topProductos.length === 0" class="p-8 text-center"><div class="text-gray-400 text-4xl mb-4">📊</div><h3 class="text-lg font-semibold text-gray-600 mb-2">No hay datos de ventas</h3><p class="text-gray-500">No se encontraron productos vendidos en el sistema.</p></div>
        </div>

        <!-- CLIENTES (sin cambios) -->
        <div x-show="currentTab === 'clientes'">
            <div x-show="loading" class="p-8 text-center"><div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div><p class="mt-2 text-gray-600">Cargando clientes...</p></div>
            <div x-show="!loading && clientes.length > 0" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 p-4"><div class="bg-blue-50 p-4 rounded-lg border border-blue-200 text-center"><div class="text-blue-600 font-semibold text-sm">Total Clientes</div><div class="text-2xl font-bold text-blue-700" x-text="clientes.length"></div></div><div class="bg-green-50 p-4 rounded-lg border border-green-200 text-center"><div class="text-green-600 font-semibold text-sm">Total Compras</div><div class="text-2xl font-bold text-green-700" x-text="clientes.reduce((sum, c) => sum + parseInt(c.cantidad_compras || 0), 0)"></div></div><div class="bg-purple-50 p-4 rounded-lg border border-purple-200 text-center"><div class="text-purple-600 font-semibold text-sm">Total Gastado</div><div class="text-2xl font-bold text-purple-700" x-text="formatoMoneda(clientes.reduce((sum, c) => sum + parseFloat(c.total_gastado || 0), 0))"></div></div></div>
            <div x-show="!loading && clientes.length > 0" class="hidden sm:block"><table class="min-w-full table-auto"><thead class="bg-gray-200 text-gray-700 uppercase text-xs font-semibold"><tr><th class="px-4 py-3">#</th><th class="px-4 py-3">Cliente</th><th class="px-4 py-3">DNI</th><th class="px-4 py-3">Cantidad de Compras</th><th class="px-4 py-3">Total Gastado</th><th class="px-4 py-3">Email</th><th class="px-4 py-3">Teléfono</th></tr></thead><tbody class="text-gray-600 divide-y divide-gray-200 text-sm"><template x-for="(cliente, index) in clientes" :key="cliente.codigo"><tr class="hover:bg-gray-50"><td class="px-4 py-3 text-center"><span x-text="index + 1" :class="{'bg-yellow-400 text-white px-2 py-1 rounded-full text-xs': index === 0,'bg-gray-300 text-gray-700 px-2 py-1 rounded-full text-xs': index === 1,'bg-orange-400 text-white px-2 py-1 rounded-full text-xs': index === 2,'text-gray-500': index > 2}"></span></td><td class="px-4 py-3 font-medium" x-text="cliente.cliente"></td><td class="px-4 py-3 text-center font-mono" x-text="cliente.dni"></td><td class="px-4 py-3 text-center font-semibold text-blue-600" x-text="cliente.cantidad_compras"></td><td class="px-4 py-3 font-semibold text-green-600" x-text="formatoMoneda(cliente.total_gastado)"></td><td class="px-4 py-3 text-sm text-gray-500" x-text="cliente.email || 'N/A'"></td><td class="px-4 py-3" x-text="cliente.telefono || 'N/A'"></td></tr></template></tbody></table></div>
            <div x-show="!loading && clientes.length > 0" class="sm:hidden space-y-4 p-4"><template x-for="(cliente, index) in clientes" :key="cliente.codigo"><div class="bg-white rounded-lg shadow p-4 border"><div class="flex justify-between items-start mb-2"><div class="flex items-center gap-2"><span x-text="index + 1" :class="{'bg-yellow-400 text-white px-2 py-1 rounded-full text-sm font-bold': index === 0,'bg-gray-300 text-gray-700 px-2 py-1 rounded-full text-sm font-bold': index === 1,'bg-orange-400 text-white px-2 py-1 rounded-full text-sm font-bold': index === 2,'bg-gray-200 text-gray-600 px-2 py-1 rounded-full text-sm': index > 2}"></span><h3 class="font-bold text-lg" x-text="cliente.cliente"></h3></div><span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-semibold" x-text="cliente.codigo"></span></div><div class="grid grid-cols-2 gap-3 text-sm text-gray-700"><div class="text-center"><div class="text-gray-500 text-xs">DNI</div><div class="font-mono" x-text="cliente.dni"></div></div><div class="text-center"><div class="text-gray-500 text-xs">Compras</div><div class="font-bold text-blue-600 text-lg" x-text="cliente.cantidad_compras"></div></div><div class="col-span-2 text-center"><div class="text-gray-500 text-xs">Total Gastado</div><div class="font-bold text-green-600 text-lg" x-text="formatoMoneda(cliente.total_gastado)"></div></div><div class="col-span-2 text-center pt-2 border-t"><div class="text-gray-500 text-xs">Contacto</div><div class="text-sm" x-text="cliente.email || cliente.telefono || 'Sin contacto'"></div></div></div></div></template></div>
            <div x-show="!loading && clientes.length === 0" class="p-8 text-center"><div class="text-gray-400 text-4xl mb-4">👥</div><h3 class="text-lg font-semibold text-gray-600 mb-2">No hay clientes registrados</h3><p class="text-gray-500">No se encontraron clientes que cumplan con los criterios de búsqueda.</p></div>
        </div>

        <!-- INVENTARIO (sin cambios) -->
        <div x-show="currentTab === 'inventario'">
            <div x-show="loading" class="p-8 text-center"><div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div><p class="mt-2 text-gray-600">Cargando inventario...</p></div>
            <div x-show="!loading && inventario.length > 0" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6 p-4"><div class="bg-blue-50 p-4 rounded-lg border border-blue-200 text-center"><div class="text-blue-600 font-semibold text-sm">Total Productos</div><div class="text-2xl font-bold text-blue-700" x-text="inventario.length"></div></div><div class="bg-green-50 p-4 rounded-lg border border-green-200 text-center"><div class="text-green-600 font-semibold text-sm">Stock Total</div><div class="text-2xl font-bold text-green-700" x-text="inventario.reduce((sum, p) => sum + parseInt(p.stock || 0), 0)"></div></div><div class="bg-orange-50 p-4 rounded-lg border border-orange-200 text-center"><div class="text-orange-600 font-semibold text-sm">Poco Stock (1-4)</div><div class="text-2xl font-bold text-orange-700" x-text="inventario.filter(p => parseInt(p.stock || 0) >= 1 && parseInt(p.stock || 0) <= 4).length"></div></div><div class="bg-red-50 p-4 rounded-lg border border-red-200 text-center"><div class="text-red-600 font-semibold text-sm">Agotados</div><div class="text-2xl font-bold text-red-700" x-text="inventario.filter(p => parseInt(p.stock || 0) === 0).length"></div></div></div>
            <div x-show="!loading && inventario.length > 0" class="hidden sm:block"><table class="min-w-full table-auto"><thead class="bg-gray-200 text-gray-700 uppercase text-xs font-semibold"><tr><th class="px-4 py-3">Código</th><th class="px-4 py-3">Producto</th><th class="px-4 py-3">Descripción</th><th class="px-4 py-3">Precio</th><th class="px-4 py-3">Stock</th><th class="px-4 py-3">Estado</th><th class="px-4 py-3">Categoría</th><th class="px-4 py-3">Marca</th></tr></thead><tbody class="text-gray-600 divide-y divide-gray-200 text-sm"><template x-for="(producto, index) in inventario" :key="producto.codigo"><tr class="hover:bg-gray-50"><td class="px-4 py-3 text-center font-mono text-sm" x-text="producto.codigo"></td><td class="px-4 py-3 font-medium" x-text="producto.producto"></td><td class="px-4 py-3 text-sm text-gray-500 max-w-xs truncate" :title="producto.descripcion" x-text="producto.descripcion || 'Sin descripción'"></td><td class="px-4 py-3 font-semibold text-green-600" x-text="formatoMoneda(producto.precio)"></td><td class="px-4 py-3 text-center"><span x-text="producto.stock" :class="{'bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs font-semibold': producto.stock < 5,'bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-semibold': producto.stock >= 5 && producto.stock < 10,'bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-semibold': producto.stock >= 10}"></span></td><td class="px-4 py-3"><span x-text="calcularEstadoProducto(producto.stock, producto.estado)" :class="getClaseEstadoProducto(producto.stock, producto.estado)"></span></td><td class="px-4 py-3 text-sm" x-text="producto.categoria"></td><td class="px-4 py-3 text-sm" x-text="producto.marca || 'N/A'"></td></tr></template></tbody></table></div>
            <div x-show="!loading && inventario.length > 0" class="sm:hidden space-y-4 p-4"><template x-for="(producto, index) in inventario" :key="producto.codigo"><div class="bg-white rounded-lg shadow p-4 border"><div class="flex justify-between items-start mb-2"><div class="flex items-center gap-2"><h3 class="font-bold text-lg" x-text="producto.producto"></h3><span x-text="calcularEstadoProducto(producto.stock, producto.estado)" :class="getClaseEstadoProducto(producto.stock, producto.estado)"></span></div><span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-semibold" x-text="producto.codigo"></span></div><div class="mb-3"><div class="text-gray-500 text-xs">Descripción</div><div class="text-sm text-gray-700" x-text="producto.descripcion || 'Sin descripción'"></div></div><div class="grid grid-cols-2 gap-3 text-sm text-gray-700"><div class="text-center"><div class="text-gray-500 text-xs">Precio</div><div class="font-bold text-green-600" x-text="formatoMoneda(producto.precio)"></div></div><div class="text-center"><div class="text-gray-500 text-xs">Stock</div><div class="font-bold" :class="{'text-red-600': producto.stock < 5,'text-yellow-600': producto.stock >= 5 && producto.stock < 10,'text-green-600': producto.stock >= 10}" x-text="producto.stock"></div></div><div class="text-center"><div class="text-gray-500 text-xs">Categoría</div><div class="font-medium" x-text="producto.categoria"></div></div><div class="text-center"><div class="text-gray-500 text-xs">Marca</div><div class="font-medium" x-text="producto.marca || 'N/A'"></div></div></div></div></template></div>
            <div x-show="!loading && inventario.length === 0" class="p-8 text-center"><div class="text-gray-400 text-4xl mb-4">📦</div><h3 class="text-lg font-semibold text-gray-600 mb-2">No hay productos en inventario</h3><p class="text-gray-500">No se encontraron productos que cumplan con los criterios de búsqueda.</p></div>
        </div>

        <!-- VENTAS (sin cambios) -->
        <div x-show="currentTab === 'ventas'">
            <div x-show="loading" class="p-8 text-center"><div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div><p class="mt-2 text-gray-600">Cargando ventas...</p></div>
            <div x-show="!loading && ventas.length > 0" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 p-4"><div class="bg-blue-50 p-4 rounded-lg border border-blue-200 text-center"><div class="text-blue-600 font-semibold text-sm">Total Ventas</div><div class="text-2xl font-bold text-blue-700" x-text="ventas.length"></div></div><div class="bg-green-50 p-4 rounded-lg border border-green-200 text-center"><div class="text-green-600 font-semibold text-sm">Ingresos Totales</div><div class="text-2xl font-bold text-green-700" x-text="formatoMoneda(ventas.reduce((sum, v) => sum + parseFloat(v.total || 0), 0))"></div></div><div class="bg-purple-50 p-4 rounded-lg border border-purple-200 text-center"><div class="text-purple-600 font-semibold text-sm">Productos Vendidos</div><div class="text-2xl font-bold text-purple-700" x-text="ventas.reduce((sum, v) => sum + parseInt(v.cantidad || 0), 0)"></div></div></div>
            <div x-show="!loading && ventas.length > 0" class="hidden sm:block"><table class="min-w-full table-auto"><thead class="bg-gray-200 text-gray-700 uppercase text-xs font-semibold"><tr><th class="px-4 py-3">Fecha</th><th class="px-4 py-3">Código Venta</th><th class="px-4 py-3">Cliente</th><th class="px-4 py-3">Productos</th><th class="px-4 py-3">Cantidad</th><th class="px-4 py-3">Total</th></tr></thead><tbody class="text-gray-600 divide-y divide-gray-200 text-sm"><template x-for="(venta, index) in ventas" :key="venta.codigo"><tr class="hover:bg-gray-50"><td class="px-4 py-3 text-sm" x-text="formatoFecha(venta.fecha)"></td><td class="px-4 py-3 text-center font-mono text-sm" x-text="venta.codigo"></td><td class="px-4 py-3 font-medium" x-text="venta.cliente"></td><td class="px-4 py-3 text-sm text-gray-500 max-w-xs" :title="venta.producto" x-text="venta.producto"></td><td class="px-4 py-3 text-center font-semibold text-blue-600" x-text="venta.cantidad"></td><td class="px-4 py-3 font-semibold text-green-600" x-text="formatoMoneda(venta.total)"></td></tr></template></tbody></table></div>
            <div x-show="!loading && ventas.length > 0" class="sm:hidden space-y-4 p-4"><template x-for="(venta, index) in ventas" :key="venta.codigo"><div class="bg-white rounded-lg shadow p-4 border"><div class="flex justify-between items-start mb-2"><div class="flex items-center gap-2"><h3 class="font-bold text-lg" x-text="venta.codigo"></h3></div><span class="text-sm text-gray-500" x-text="formatoFecha(venta.fecha)"></span></div><div class="mb-3"><div class="text-gray-500 text-xs">Cliente</div><div class="font-medium" x-text="venta.cliente"></div></div><div class="mb-3"><div class="text-gray-500 text-xs">Productos</div><div class="text-sm text-gray-700" x-text="venta.producto"></div></div><div class="grid grid-cols-2 gap-3 text-sm text-gray-700"><div class="text-center"><div class="text-gray-500 text-xs">Cantidad</div><div class="font-bold text-blue-600" x-text="venta.cantidad"></div></div><div class="text-center"><div class="text-gray-500 text-xs">Total</div><div class="font-bold text-green-600" x-text="formatoMoneda(venta.total)"></div></div></div></div></template></div>
            <div x-show="!loading && ventas.length === 0" class="p-8 text-center"><div class="text-gray-400 text-4xl mb-4">💰</div><h3 class="text-lg font-semibold text-gray-600 mb-2">No hay ventas registradas</h3><p class="text-gray-500">No se encontraron ventas que cumplan con los criterios de búsqueda.</p></div>
        </div>

        <!-- PEDIDOS (sin cambios) -->
        <div x-show="currentTab === 'pedidos'">
            <div x-show="loading" class="p-8 text-center"><div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div><p class="mt-2 text-gray-600">Cargando pedidos...</p></div>
            <div x-show="!loading && pedidos.length > 0" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 p-4"><div class="bg-blue-50 p-4 rounded-lg border border-blue-200 text-center"><div class="text-blue-600 font-semibold text-sm">Total Pedidos</div><div class="text-2xl font-bold text-blue-700" x-text="pedidos.length"></div></div><div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200 text-center"><div class="text-yellow-600 font-semibold text-sm">Pendientes</div><div class="text-2xl font-bold text-yellow-700" x-text="pedidos.filter(p => p.estado === 'pendiente').length"></div></div><div class="bg-green-50 p-4 rounded-lg border border-green-200 text-center"><div class="text-green-600 font-semibold text-sm">Entregados</div><div class="text-2xl font-bold text-green-700" x-text="pedidos.filter(p => p.estado === 'entregado').length"></div></div></div>
            <div x-show="!loading && pedidos.length > 0" class="hidden sm:block"><table class="min-w-full table-auto"><thead class="bg-gray-200 text-gray-700 uppercase text-xs font-semibold"><tr><th class="px-4 py-3">Código</th><th class="px-4 py-3">Cliente</th><th class="px-4 py-3">Productos</th><th class="px-4 py-3">Fecha Pedido</th><th class="px-4 py-3">Fecha Entrega</th><th class="px-4 py-3">Monto Total</th><th class="px-4 py-3">Distrito</th><th class="px-4 py-3">Recojo Tienda</th><th class="px-4 py-3">Estado</th></tr></thead><tbody class="text-gray-600 divide-y divide-gray-200 text-sm"><template x-for="(pedido, index) in pedidos" :key="pedido.codigo"><tr class="hover:bg-gray-50"><td class="px-4 py-3 text-center font-mono text-sm" x-text="pedido.codigo"></td><td class="px-4 py-3 font-medium" x-text="pedido.cliente"></td><td class="px-4 py-3 text-sm text-gray-500 max-w-xs" :title="pedido.detalles" x-text="pedido.detalles"></td><td class="px-4 py-3 text-sm" x-text="formatoFecha(pedido.fecha_pedido)"></td><td class="px-4 py-3 text-sm" x-text="formatoFecha(calcularFechaEntrega(pedido.fecha_pedido))"></td><td class="px-4 py-3 font-semibold text-green-600" x-text="formatoMoneda(pedido.monto_total)"></td><td class="px-4 py-3 text-sm" x-text="pedido.distrito"></td><td class="px-4 py-3 text-center"><span x-text="pedido.recojo_tienda" :class="{'bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs': pedido.recojo_tienda === 'Sí','bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-xs': pedido.recojo_tienda === 'No'}"></span></td><td class="px-4 py-3"><span x-text="pedido.estado" :class="{'bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs': pedido.estado === 'pendiente','bg-orange-100 text-orange-800 px-2 py-1 rounded-full text-xs': pedido.estado === 'enviado','bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs': pedido.estado === 'entregado'}"></span></td></tr></template></tbody></table></div>
            <div x-show="!loading && pedidos.length > 0" class="sm:hidden space-y-4 p-4"><template x-for="(pedido, index) in pedidos" :key="pedido.codigo"><div class="bg-white rounded-lg shadow p-4 border"><div class="flex justify-between items-start mb-2"><div class="flex items-center gap-2"><h3 class="font-bold text-lg" x-text="pedido.codigo"></h3><span x-text="pedido.estado" :class="{'bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs': pedido.estado === 'pendiente','bg-orange-100 text-orange-800 px-2 py-1 rounded-full text-xs': pedido.estado === 'enviado','bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs': pedido.estado === 'entregado'}"></span></div><span class="text-sm text-gray-500" x-text="formatoFecha(pedido.fecha_pedido)"></span></div><div class="mb-3"><div class="text-gray-500 text-xs">Cliente</div><div class="font-medium" x-text="pedido.cliente"></div></div><div class="mb-3"><div class="text-gray-500 text-xs">Productos</div><div class="text-sm text-gray-700" x-text="pedido.detalles"></div></div><div class="grid grid-cols-2 gap-3 text-sm text-gray-700"><div class="text-center"><div class="text-gray-500 text-xs">Fecha Entrega</div><div class="font-medium" x-text="formatoFecha(calcularFechaEntrega(pedido.fecha_pedido))"></div></div><div class="text-center"><div class="text-gray-500 text-xs">Total</div><div class="font-bold text-green-600" x-text="formatoMoneda(pedido.monto_total)"></div></div><div class="text-center"><div class="text-gray-500 text-xs">Distrito</div><div class="font-medium" x-text="pedido.distrito"></div></div><div class="text-center"><div class="text-gray-500 text-xs">Recojo</div><div class="font-medium" :class="{'text-green-600': pedido.recojo_tienda === 'Sí', 'text-gray-600': pedido.recojo_tienda === 'No'}" x-text="pedido.recojo_tienda"></div></div></div></div></template></div>
            <div x-show="!loading && pedidos.length === 0" class="p-8 text-center"><div class="text-gray-400 text-4xl mb-4">🚚</div><div class="text-lg font-semibold text-gray-600 mb-2">No hay pedidos registrados</div><div class="text-gray-500">No se encontraron pedidos que cumplan con los criterios de búsqueda.</div></div>
        </div>

        <div x-show="currentTab !== 'top' && currentTab !== 'clientes' && currentTab !== 'inventario' && currentTab !== 'ventas' && currentTab !== 'pedidos'" class="p-8 text-center text-gray-500"><div class="text-4xl mb-4">📋</div><h3 class="text-lg font-semibold mb-2">Pestaña en desarrollo</h3><p>Esta funcionalidad estará disponible próximamente.</p></div>
    </div>
</div>

<script>
function reportes() {
    return {
        currentTab: 'top',
        loading: false,
        exportando: false,
        usuarioActual: '{{ auth()->user()->name ?? "Usuario" }}',
        
        topProductos: [],
        clientes: [],
        inventario: [],
        ventas: [],
        pedidos: [],
        
        filtrosClientes: { busqueda: '', min_compras: '' },
        filtrosInventario: { producto: '', estado: '', stock_minimo: '' },
        filtrosVentas: { fecha: '', cliente: '', producto: '' },
        filtrosPedidos: { fecha: '', estado: '', cliente: '' },

        init() {
            console.log('🔄 Inicializando reportes...');
            this.cargarTopProductos();
            this.$watch('currentTab', (value) => {
                if (value === 'top') this.cargarTopProductos();
                else if (value === 'clientes') this.cargarClientes();
                else if (value === 'inventario') this.cargarInventario();
                else if (value === 'ventas') this.cargarVentas();
                else if (value === 'pedidos') this.cargarPedidos();
            });
        },

        // ----- FUNCIONES DE CARGA (sin cambios) -----
        async cargarTopProductos() {
            this.loading = true;
            try {
                const response = await fetch(`/api/reportes/top-productos`);
                const data = await response.json();
                if (data.success) this.topProductos = data.top_productos || [];
                else this.topProductos = [];
            } catch (error) { console.error(error); this.topProductos = []; }
            finally { this.loading = false; }
        },
        async cargarClientes() {
            this.loading = true;
            try {
                const params = new URLSearchParams();
                if (this.filtrosClientes.busqueda) params.append('busqueda', this.filtrosClientes.busqueda);
                if (this.filtrosClientes.min_compras) params.append('min_compras', this.filtrosClientes.min_compras);
                const response = await fetch(`/api/reportes/clientes?${params}`);
                const data = await response.json();
                if (data.success) this.clientes = data.clientes || [];
                else this.clientes = [];
            } catch (error) { console.error(error); this.clientes = []; }
            finally { this.loading = false; }
        },
        async cargarInventario() {
            this.loading = true;
            try {
                const params = new URLSearchParams();
                if (this.filtrosInventario.producto) params.append('producto', this.filtrosInventario.producto);
                if (this.filtrosInventario.estado) params.append('estado', this.filtrosInventario.estado);
                if (this.filtrosInventario.stock_minimo) params.append('stock_minimo', this.filtrosInventario.stock_minimo);
                const response = await fetch(`/api/reportes/inventario?${params}`);
                const data = await response.json();
                if (data.success) this.inventario = data.inventario || [];
                else this.inventario = [];
            } catch (error) { console.error(error); this.inventario = []; }
            finally { this.loading = false; }
        },
        async cargarVentas() {
            this.loading = true;
            try {
                const params = new URLSearchParams();
                if (this.filtrosVentas.fecha) params.append('fecha', this.filtrosVentas.fecha);
                if (this.filtrosVentas.cliente) params.append('cliente', this.filtrosVentas.cliente);
                if (this.filtrosVentas.producto) params.append('producto', this.filtrosVentas.producto);
                const response = await fetch(`/api/reportes/ventas?${params}`);
                const data = await response.json();
                if (data.success) this.ventas = data.ventas || [];
                else this.ventas = [];
            } catch (error) { console.error(error); this.ventas = []; }
            finally { this.loading = false; }
        },
        async cargarPedidos() {
            this.loading = true;
            try {
                const params = new URLSearchParams();
                if (this.filtrosPedidos.fecha) params.append('fecha', this.filtrosPedidos.fecha);
                if (this.filtrosPedidos.estado) params.append('estado', this.filtrosPedidos.estado);
                if (this.filtrosPedidos.cliente) params.append('cliente', this.filtrosPedidos.cliente);
                const response = await fetch(`/api/reportes/pedidos?${params}`);
                const data = await response.json();
                if (data.success) this.pedidos = data.pedidos || [];
                else this.pedidos = [];
            } catch (error) { console.error(error); this.pedidos = []; }
            finally { this.loading = false; }
        },

        // ----- FILTROS (sin cambios) -----
        aplicarFiltrosClientes() { this.cargarClientes(); },
        limpiarFiltrosClientes() { this.filtrosClientes = { busqueda: '', min_compras: '' }; this.cargarClientes(); },
        aplicarFiltrosInventario() { this.cargarInventario(); },
        limpiarFiltrosInventario() { this.filtrosInventario = { producto: '', estado: '', stock_minimo: '' }; this.cargarInventario(); },
        aplicarFiltrosVentas() { this.cargarVentas(); },
        limpiarFiltrosVentas() { this.filtrosVentas = { fecha: '', cliente: '', producto: '' }; this.cargarVentas(); },
        aplicarFiltrosPedidos() { this.cargarPedidos(); },
        limpiarFiltrosPedidos() { this.filtrosPedidos = { fecha: '', estado: '', cliente: '' }; this.cargarPedidos(); },

        // ----- FUNCIONES AUXILIARES (sin cambios) -----
        calcularFechaEntrega(fechaPedido) { if (!fechaPedido) return 'N/A'; const fecha = new Date(fechaPedido); fecha.setDate(fecha.getDate() + 7); return fecha.toISOString().split('T')[0]; },
        calcularEstadoProducto(stock, estado) { const stockNum = parseInt(stock || 0); if (estado === 'descontinuado') return 'Descontinuado'; if (estado === 'agotado') return 'Agotado'; if (estado === 'poco_stock') return 'Poco stock'; return 'Disponible'; },
        getClaseEstadoProducto(stock, estado) { if (estado === 'descontinuado') return 'bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-xs'; if (estado === 'agotado') return 'bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs'; if (estado === 'poco_stock') return 'bg-orange-100 text-orange-800 px-2 py-1 rounded-full text-xs'; return 'bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs'; },
        formatoMoneda(monto) { if (!monto) return 'S/ 0.00'; return new Intl.NumberFormat('es-PE', { style: 'currency', currency: 'PEN' }).format(monto); },
        formatoFecha(fecha) { if (!fecha) return 'N/A'; try { let date; if (fecha instanceof Date && !isNaN(fecha.getTime())) date = fecha; else if (typeof fecha === 'string') { if (fecha.includes('T')) date = new Date(fecha); else if (fecha.includes(' ')) date = new Date(fecha.replace(' ', 'T')); else date = new Date(fecha + 'T00:00:00'); } if (!isNaN(date.getTime())) return date.toLocaleDateString('es-PE', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' }); return 'Fecha inválida'; } catch (error) { return 'Error fecha'; } },

        // ========== NUEVAS FUNCIONES: EXPORTAR EXCEL Y CSV ==========
        exportarExcel() {
            if (this.exportando) return;
            this.exportando = true;
            try {
                let columnas = [], datos = [], nombreHoja = '';
                switch (this.currentTab) {
                    case 'top':
                        nombreHoja = 'TOP_Productos';
                        columnas = ['#', 'Código', 'Producto', 'Cantidad Vendida', 'Fecha Última Venta', 'Ingresos Generados'];
                        datos = this.topProductos.map((p, idx) => [
                            idx + 1, p.codigo, p.producto, p.cantidad_vendida,
                            this.formatoFecha(p.fecha_ultima_venta), this.formatoMoneda(p.ingresos_generados)
                        ]);
                        break;
                    case 'clientes':
                        nombreHoja = 'Mejores_Clientes';
                        columnas = ['#', 'Cliente', 'DNI', 'Cantidad Compras', 'Total Gastado', 'Email', 'Teléfono'];
                        datos = this.clientes.map((c, idx) => [
                            idx + 1, c.cliente, c.dni, c.cantidad_compras,
                            this.formatoMoneda(c.total_gastado), c.email || 'N/A', c.telefono || 'N/A'
                        ]);
                        break;
                    case 'inventario':
                        nombreHoja = 'Inventario';
                        columnas = ['Código', 'Producto', 'Descripción', 'Precio', 'Stock', 'Estado', 'Categoría', 'Marca'];
                        datos = this.inventario.map(p => [
                            p.codigo, p.producto, p.descripcion || 'Sin descripción',
                            this.formatoMoneda(p.precio), p.stock,
                            this.calcularEstadoProducto(p.stock, p.estado),
                            p.categoria, p.marca || 'N/A'
                        ]);
                        break;
                    case 'ventas':
                        nombreHoja = 'Ventas';
                        columnas = ['Fecha', 'Código Venta', 'Cliente', 'Productos', 'Cantidad', 'Total'];
                        datos = this.ventas.map(v => [
                            this.formatoFecha(v.fecha), v.codigo, v.cliente, v.producto, v.cantidad, this.formatoMoneda(v.total)
                        ]);
                        break;
                    case 'pedidos':
                        nombreHoja = 'Pedidos';
                        columnas = ['Código', 'Cliente', 'Productos', 'Fecha Pedido', 'Fecha Entrega', 'Monto Total', 'Distrito', 'Recojo Tienda', 'Estado'];
                        datos = this.pedidos.map(p => [
                            p.codigo, p.cliente, p.detalles,
                            this.formatoFecha(p.fecha_pedido),
                            this.formatoFecha(this.calcularFechaEntrega(p.fecha_pedido)),
                            this.formatoMoneda(p.monto_total), p.distrito,
                            p.recojo_tienda,
                            p.estado.charAt(0).toUpperCase() + p.estado.slice(1)
                        ]);
                        break;
                    default: return;
                }
                this.generarExcel(nombreHoja, columnas, datos);
            } catch (error) {
                console.error('Error exportando a Excel:', error);
                alert('Error al generar el archivo Excel.');
            } finally {
                this.exportando = false;
            }
        },

        generarExcel(hojaNombre, columnas, datos) {
            const wsData = [columnas, ...datos];
            const ws = XLSX.utils.aoa_to_sheet(wsData);
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, hojaNombre);
            XLSX.writeFile(wb, `${hojaNombre}_${new Date().toISOString().slice(0,19).replace(/:/g, '-')}.xlsx`);
        },

        exportarCSV() {
            if (this.exportando) return;
            this.exportando = true;
            try {
                let columnas = [], datos = [], nombreArchivo = '';
                switch (this.currentTab) {
                    case 'top':
                        nombreArchivo = 'TOP_Productos';
                        columnas = ['#', 'Código', 'Producto', 'Cantidad Vendida', 'Fecha Última Venta', 'Ingresos Generados'];
                        datos = this.topProductos.map((p, idx) => [
                            idx + 1, p.codigo, p.producto, p.cantidad_vendida,
                            this.formatoFecha(p.fecha_ultima_venta), this.formatoMoneda(p.ingresos_generados)
                        ]);
                        break;
                    case 'clientes':
                        nombreArchivo = 'Mejores_Clientes';
                        columnas = ['#', 'Cliente', 'DNI', 'Cantidad Compras', 'Total Gastado', 'Email', 'Teléfono'];
                        datos = this.clientes.map((c, idx) => [
                            idx + 1, c.cliente, c.dni, c.cantidad_compras,
                            this.formatoMoneda(c.total_gastado), c.email || 'N/A', c.telefono || 'N/A'
                        ]);
                        break;
                    case 'inventario':
                        nombreArchivo = 'Inventario';
                        columnas = ['Código', 'Producto', 'Descripción', 'Precio', 'Stock', 'Estado', 'Categoría', 'Marca'];
                        datos = this.inventario.map(p => [
                            p.codigo, p.producto, p.descripcion || 'Sin descripción',
                            this.formatoMoneda(p.precio), p.stock,
                            this.calcularEstadoProducto(p.stock, p.estado),
                            p.categoria, p.marca || 'N/A'
                        ]);
                        break;
                    case 'ventas':
                        nombreArchivo = 'Ventas';
                        columnas = ['Fecha', 'Código Venta', 'Cliente', 'Productos', 'Cantidad', 'Total'];
                        datos = this.ventas.map(v => [
                            this.formatoFecha(v.fecha), v.codigo, v.cliente, v.producto, v.cantidad, this.formatoMoneda(v.total)
                        ]);
                        break;
                    case 'pedidos':
                        nombreArchivo = 'Pedidos';
                        columnas = ['Código', 'Cliente', 'Productos', 'Fecha Pedido', 'Fecha Entrega', 'Monto Total', 'Distrito', 'Recojo Tienda', 'Estado'];
                        datos = this.pedidos.map(p => [
                            p.codigo, p.cliente, p.detalles,
                            this.formatoFecha(p.fecha_pedido),
                            this.formatoFecha(this.calcularFechaEntrega(p.fecha_pedido)),
                            this.formatoMoneda(p.monto_total), p.distrito,
                            p.recojo_tienda,
                            p.estado.charAt(0).toUpperCase() + p.estado.slice(1)
                        ]);
                        break;
                    default: return;
                }
                this.generarCSV(nombreArchivo, columnas, datos);
            } catch (error) {
                console.error('Error exportando a CSV:', error);
                alert('Error al generar el archivo CSV.');
            } finally {
                this.exportando = false;
            }
        },

        generarCSV(nombre, columnas, datos) {
            const filas = [columnas, ...datos];
            const contenido = filas.map(fila =>
                fila.map(celda => {
                    if (celda === undefined || celda === null) return '';
                    let str = String(celda);
                    if (str.includes(',') || str.includes('"') || str.includes('\n')) {
                        str = '"' + str.replace(/"/g, '""') + '"';
                    }
                    return str;
                }).join(',')
            ).join('\n');
            const blob = new Blob(["\uFEFF" + contenido], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            const url = URL.createObjectURL(blob);
            link.href = url;
            link.setAttribute('download', `${nombre}_${new Date().toISOString().slice(0,19).replace(/:/g, '-')}.csv`);
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            URL.revokeObjectURL(url);
        },

        // ----- FUNCIONES EXISTENTES DE PDF (sin modificar, solo se mantienen) -----
        async exportarPDF() { /* igual que antes */ },
        async exportarPDFClientes() { /* igual */ },
        async exportarPDFInventario() { /* igual */ },
        async exportarPDFVentas() { /* igual */ },
        async exportarPDFPedidos() { /* igual */ },
        crearContenidoPDF() { /* igual */ },
        crearContenidoPDFClientes() { /* igual */ },
        crearContenidoPDFInventario() { /* igual */ },
        crearContenidoPDFVentas() { /* igual */ },
        crearContenidoPDFPedidos() { /* igual */ }
    }
}
</script>

<style>
.animate-spin { animation: spin 1s linear infinite; }
@keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
.table-auto { border-collapse: collapse; width: 100%; }
.table-auto th, .table-auto td { padding: 12px 16px; text-align: left; border-bottom: 1px solid #e5e7eb; }
.table-auto th { background-color: #f9fafb; font-weight: 600; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.05em; }
</style>