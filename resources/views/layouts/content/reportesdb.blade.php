<!-- En el head de tu layout -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<div x-data="reportes()">
    <!-- PESTAÑAS -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-4 flex flex-wrap gap-2">
        <button
            @click="currentTab = 'pedidos'"
            :class="{'bg-blue-600 text-white': currentTab === 'pedidos', 'bg-gray-200 text-gray-700 hover:bg-gray-300': currentTab !== 'pedidos'}"
            class="px-4 py-2 text-sm rounded-md font-semibold transition duration-150 ease-in-out"
        >
            Pedidos
        </button>
        <button
            @click="currentTab = 'ventas'"
            :class="{'bg-blue-600 text-white': currentTab === 'ventas', 'bg-gray-200 text-gray-700 hover:bg-gray-300': currentTab !== 'ventas'}"
            class="px-4 py-2 text-sm rounded-md font-semibold transition duration-150 ease-in-out"
        >
            Ventas
        </button>
        <button
            @click="currentTab = 'inventario'"
            :class="{'bg-blue-600 text-white': currentTab === 'inventario', 'bg-gray-200 text-gray-700 hover:bg-gray-300': currentTab !== 'inventario'}"
            class="px-4 py-2 text-sm rounded-md font-semibold transition duration-150 ease-in-out"
        >
            Inventario
        </button>
        <button
            @click="currentTab = 'clientes'"
            :class="{'bg-blue-600 text-white': currentTab === 'clientes', 'bg-gray-200 text-gray-700 hover:bg-gray-300': currentTab !== 'clientes'}"
            class="px-4 py-2 text-sm rounded-md font-semibold transition duration-150 ease-in-out"
        >
            Clientes
        </button>
        <button
            @click="currentTab = 'top'"
            :class="{'bg-blue-600 text-white': currentTab === 'top', 'bg-gray-200 text-gray-700 hover:bg-gray-300': currentTab !== 'top'}"
            class="px-4 py-2 text-sm rounded-md font-semibold transition duration-150 ease-in-out"
        >
            TOP 20 Productos
        </button>
    </div>

    <!-- ENCABEZADO CON BOTÓN EXPORTAR Y FILTROS -->
    <div class="bg-white p-4 rounded-lg shadow-md mb-4">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="flex flex-col lg:flex-row lg:items-center gap-4">
                <!-- TÍTULO DE LA PESTAÑA ACTUAL -->
                <template x-if="currentTab === 'top'">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">📊 TOP 20 Productos Más Vendidos</h2>
                        <p class="text-sm text-gray-600 mt-1">Ranking de productos por cantidad de ventas</p>
                    </div>
                </template>

                <template x-if="currentTab === 'clientes'">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">👥 Mejores Clientes</h2>
                        <p class="text-sm text-gray-600 mt-1">Ranking de clientes por compras realizadas</p>
                    </div>
                </template>

                <template x-if="currentTab === 'inventario'">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">📦 Inventario de Productos</h2>
                        <p class="text-sm text-gray-600 mt-1">Estado actual del stock y productos</p>
                    </div>
                </template>

                <template x-if="currentTab === 'ventas'">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">💰 Reporte de Ventas</h2>
                        <p class="text-sm text-gray-600 mt-1">Historial detallado de todas las ventas</p>
                    </div>
                </template>

                <template x-if="currentTab === 'pedidos'">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">🚚 Gestión de Pedidos</h2>
                        <p class="text-sm text-gray-600 mt-1">Seguimiento y estado de todos los pedidos</p>
                    </div>
                </template>

                <!-- TÍTULOS PARA OTRAS PESTAÑAS -->
                <template x-if="currentTab !== 'top' && currentTab !== 'clientes' && currentTab !== 'inventario' && currentTab !== 'ventas' && currentTab !== 'pedidos'">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800" x-text="'📋 ' + currentTab.charAt(0).toUpperCase() + currentTab.slice(1)"></h2>
                        <p class="text-sm text-gray-600 mt-1">Reporte detallado</p>
                    </div>
                </template>

                <!-- FILTROS PARA CLIENTES -->
                <template x-if="currentTab === 'clientes'">
                    <div class="flex flex-wrap items-center gap-2">
                        <input 
                            type="text" 
                            x-model="filtrosClientes.busqueda"
                            placeholder="Buscar por nombre, apellido o DNI..." 
                            class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500 w-full lg:w-64"
                            @keyup.enter="aplicarFiltrosClientes()"
                        />
                        <input 
                            type="number" 
                            x-model="filtrosClientes.min_compras"
                            placeholder="Mín. compras" 
                            class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500 w-full lg:w-32"
                            @keyup.enter="aplicarFiltrosClientes()"
                        />
                        <button 
                            @click="aplicarFiltrosClientes()"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition text-sm whitespace-nowrap"
                        >
                            Aplicar
                        </button>
                        <button 
                            @click="limpiarFiltrosClientes()"
                            class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition text-sm whitespace-nowrap"
                        >
                            Limpiar
                        </button>
                    </div>
                </template>

                <!-- FILTROS PARA INVENTARIO -->
                <template x-if="currentTab === 'inventario'">
                    <div class="flex flex-wrap items-center gap-2">
                        <input 
                            type="text" 
                            x-model="filtrosInventario.producto"
                            placeholder="Buscar producto..." 
                            class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500 w-full lg:w-64"
                            @keyup.enter="aplicarFiltrosInventario()"
                        />
                        <select 
                            x-model="filtrosInventario.estado"
                            class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500 w-full lg:w-40"
                        >
                            <option value="">Todos los estados</option>
                            <option value="disponible">Disponible</option>
                            <option value="poco_stock">Poco stock</option>
                            <option value="agotado">Agotado</option>
                            <option value="descontinuado">Descontinuado</option>
                        </select>
                        <input 
                            type="number" 
                            x-model="filtrosInventario.stock_minimo"
                            placeholder="Stock mínimo" 
                            class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500 w-full lg:w-32"
                            @keyup.enter="aplicarFiltrosInventario()"
                        />
                        <button 
                            @click="aplicarFiltrosInventario()"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition text-sm whitespace-nowrap"
                        >
                            Aplicar
                        </button>
                        <button 
                            @click="limpiarFiltrosInventario()"
                            class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition text-sm whitespace-nowrap"
                        >
                            Limpiar
                        </button>
                    </div>
                </template>

                <!-- FILTROS PARA VENTAS -->
                <template x-if="currentTab === 'ventas'">
                    <div class="flex flex-wrap items-center gap-2">
                        <input 
                            type="date" 
                            x-model="filtrosVentas.fecha"
                            class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500 w-full lg:w-40"
                        />
                        <input 
                            type="text" 
                            x-model="filtrosVentas.cliente"
                            placeholder="Buscar cliente..." 
                            class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500 w-full lg:w-64"
                            @keyup.enter="aplicarFiltrosVentas()"
                        />
                        <input 
                            type="text" 
                            x-model="filtrosVentas.producto"
                            placeholder="Buscar producto..." 
                            class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500 w-full lg:w-64"
                            @keyup.enter="aplicarFiltrosVentas()"
                        />
                        <button 
                            @click="aplicarFiltrosVentas()"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition text-sm whitespace-nowrap"
                        >
                            Aplicar
                        </button>
                        <button 
                            @click="limpiarFiltrosVentas()"
                            class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition text-sm whitespace-nowrap"
                        >
                            Limpiar
                        </button>
                    </div>
                </template>

                <!-- FILTROS PARA PEDIDOS -->
                <template x-if="currentTab === 'pedidos'">
                    <div class="flex flex-wrap items-center gap-2">
                        <input 
                            type="date" 
                            x-model="filtrosPedidos.fecha"
                            class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500 w-full lg:w-40"
                        />
                        <select 
                            x-model="filtrosPedidos.estado"
                            class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500 w-full lg:w-40"
                        >
                            <option value="">Todos los estados</option>
                            <option value="pendiente">Pendiente</option>
                            <option value="enviado">Enviado</option>
                            <option value="entregado">Entregado</option>
                        </select>
                        <input 
                            type="text" 
                            x-model="filtrosPedidos.cliente"
                            placeholder="Buscar cliente..." 
                            class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500 w-full lg:w-64"
                            @keyup.enter="aplicarFiltrosPedidos()"
                        />
                        <button 
                            @click="aplicarFiltrosPedidos()"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition text-sm whitespace-nowrap"
                        >
                            Aplicar
                        </button>
                        <button 
                            @click="limpiarFiltrosPedidos()"
                            class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition text-sm whitespace-nowrap"
                        >
                            Limpiar
                        </button>
                    </div>
                </template>
            </div>

            <!-- BOTÓN EXPORTAR PDF -->
            <div class="flex justify-end">
                <!-- BOTÓN EXPORTAR PDF - PARA TOP -->
                <template x-if="currentTab === 'top' && !loading && topProductos.length > 0">
                    <button 
                        @click="exportarPDF()"
                        class="px-4 py-2 text-sm bg-red-600 text-white rounded hover:bg-red-700 transition duration-150 ease-in-out flex items-center gap-2"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Exportar PDF
                    </button>
                </template>

                <!-- BOTÓN EXPORTAR PDF - PARA CLIENTES -->
                <template x-if="currentTab === 'clientes' && !loading && clientes.length > 0">
                    <button 
                        @click="exportarPDFClientes()"
                        class="px-4 py-2 text-sm bg-red-600 text-white rounded hover:bg-red-700 transition duration-150 ease-in-out flex items-center gap-2"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Exportar PDF
                    </button>
                </template>

                <!-- BOTÓN EXPORTAR PDF - PARA INVENTARIO -->
                <template x-if="currentTab === 'inventario' && !loading && inventario.length > 0">
                    <button 
                        @click="exportarPDFInventario()"
                        class="px-4 py-2 text-sm bg-red-600 text-white rounded hover:bg-red-700 transition duration-150 ease-in-out flex items-center gap-2"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Exportar PDF
                    </button>
                </template>

                <!-- BOTÓN EXPORTAR PDF - PARA VENTAS -->
                <template x-if="currentTab === 'ventas' && !loading && ventas.length > 0">
                    <button 
                        @click="exportarPDFVentas()"
                        class="px-4 py-2 text-sm bg-red-600 text-white rounded hover:bg-red-700 transition duration-150 ease-in-out flex items-center gap-2"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Exportar PDF
                    </button>
                </template>

                <!-- BOTÓN EXPORTAR PDF - PARA PEDIDOS -->
                <template x-if="currentTab === 'pedidos' && !loading && pedidos.length > 0">
                    <button 
                        @click="exportarPDFPedidos()"
                        class="px-4 py-2 text-sm bg-red-600 text-white rounded hover:bg-red-700 transition duration-150 ease-in-out flex items-center gap-2"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Exportar PDF
                    </button>
                </template>

                <!-- BOTÓN EXPORTAR DESHABILITADO PARA OTRAS PESTAÑAS -->
                <template x-if="currentTab !== 'top' && currentTab !== 'clientes' && currentTab !== 'inventario' && currentTab !== 'ventas' && currentTab !== 'pedidos'">
                    <button 
                        class="px-4 py-2 text-sm bg-gray-500 text-white rounded hover:bg-gray-600 transition duration-150 ease-in-out flex items-center gap-2"
                        disabled
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Exportar PDF
                    </button>
                </template>
            </div>
        </div>
    </div>

    <!-- CONTENIDO DE PESTAÑAS -->
    <div class="overflow-x-auto bg-white shadow rounded-lg">

        <!-- PESTAÑA TOP -->
        <div x-show="currentTab === 'top'">
            <!-- LOADING -->
            <div x-show="loading" class="p-8 text-center">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                <p class="mt-2 text-gray-600">Cargando TOP 20 productos...</p>
            </div>

            <!-- TABLA DESKTOP -->
            <div x-show="!loading && topProductos.length > 0" class="hidden sm:block">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-200 text-gray-700 uppercase text-xs font-semibold">
                        <tr>
                            <th class="px-4 py-3">#</th>
                            <th class="px-4 py-3">Código</th>
                            <th class="px-4 py-3">Producto</th>
                            <th class="px-4 py-3">Cantidad Vendida</th>
                            <th class="px-4 py-3">Fecha Última Venta</th>
                            <th class="px-4 py-3">Ingresos Generados</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 divide-y divide-gray-200 text-sm">
                        <template x-for="(producto, index) in topProductos" :key="producto.codigo">
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-center">
                                    <span x-text="index + 1" 
                                          :class="{
                                              'bg-yellow-400 text-white px-2 py-1 rounded-full text-xs': index === 0,
                                              'bg-gray-300 text-gray-700 px-2 py-1 rounded-full text-xs': index === 1,
                                              'bg-orange-400 text-white px-2 py-1 rounded-full text-xs': index === 2,
                                              'text-gray-500': index > 2
                                          }"></span>
                                </td>
                                <td class="px-4 py-3 text-center font-mono text-sm" x-text="producto.codigo"></td>
                                <td class="px-4 py-3 font-medium" x-text="producto.producto"></td>
                                <td class="px-4 py-3 text-center font-semibold text-blue-600" x-text="producto.cantidad_vendida"></td>
                                <td class="px-4 py-3 text-sm" x-text="formatoFecha(producto.fecha_ultima_venta)"></td>
                                <td class="px-4 py-3 font-semibold text-green-600" 
                                    x-text="formatoMoneda(producto.ingresos_generados)"></td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <!-- VISTA MÓVIL -->
            <div x-show="!loading && topProductos.length > 0" class="sm:hidden space-y-4 p-4">
                <template x-for="(producto, index) in topProductos" :key="producto.codigo">
                    <div class="bg-white rounded-lg shadow p-4 border">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex items-center gap-2">
                                <span x-text="index + 1" 
                                      :class="{
                                          'bg-yellow-400 text-white px-2 py-1 rounded-full text-sm font-bold': index === 0,
                                          'bg-gray-300 text-gray-700 px-2 py-1 rounded-full text-sm font-bold': index === 1,
                                          'bg-orange-400 text-white px-2 py-1 rounded-full text-sm font-bold': index === 2,
                                          'bg-gray-200 text-gray-600 px-2 py-1 rounded-full text-sm': index > 2
                                      }"></span>
                                <h3 class="font-bold text-lg" x-text="producto.producto"></h3>
                            </div>
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-semibold" 
                                  x-text="producto.codigo"></span>
                        </div>
                        <div class="grid grid-cols-2 gap-3 text-sm text-gray-700">
                            <div class="text-center">
                                <div class="text-gray-500 text-xs">Vendidos</div>
                                <div class="font-bold text-blue-600 text-lg" x-text="producto.cantidad_vendida"></div>
                            </div>
                            <div class="text-center">
                                <div class="text-gray-500 text-xs">Última venta</div>
                                <div class="font-medium" x-text="formatoFecha(producto.fecha_ultima_venta)"></div>
                            </div>
                            <div class="col-span-2 text-center pt-2 border-t">
                                <div class="text-gray-500 text-xs">Ingresos totales</div>
                                <div class="font-bold text-green-600 text-lg" x-text="formatoMoneda(producto.ingresos_generados)"></div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <!-- SIN RESULTADOS -->
            <div x-show="!loading && topProductos.length === 0" class="p-8 text-center">
                <div class="text-gray-400 text-4xl mb-4">📊</div>
                <h3 class="text-lg font-semibold text-gray-600 mb-2">No hay datos de ventas</h3>
                <p class="text-gray-500">No se encontraron productos vendidos en el sistema.</p>
            </div>
        </div>

        <!-- PESTAÑA CLIENTES -->
        <div x-show="currentTab === 'clientes'">
            <!-- LOADING -->
            <div x-show="loading" class="p-8 text-center">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                <p class="mt-2 text-gray-600">Cargando clientes...</p>
            </div>

            <!-- RESUMEN ESTADÍSTICO -->
            <div x-show="!loading && clientes.length > 0" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 p-4">
                <div class="bg-blue-50 p-4 rounded-lg border border-blue-200 text-center">
                    <div class="text-blue-600 font-semibold text-sm">Total Clientes</div>
                    <div class="text-2xl font-bold text-blue-700" x-text="clientes.length"></div>
                </div>
                <div class="bg-green-50 p-4 rounded-lg border border-green-200 text-center">
                    <div class="text-green-600 font-semibold text-sm">Total Compras</div>
                    <div class="text-2xl font-bold text-green-700" 
                         x-text="clientes.reduce((sum, c) => sum + parseInt(c.cantidad_compras || 0), 0)"></div>
                </div>
                <div class="bg-purple-50 p-4 rounded-lg border border-purple-200 text-center">
                    <div class="text-purple-600 font-semibold text-sm">Total Gastado</div>
                    <div class="text-2xl font-bold text-purple-700" 
                         x-text="formatoMoneda(clientes.reduce((sum, c) => sum + parseFloat(c.total_gastado || 0), 0))"></div>
                </div>
            </div>

            <!-- TABLA DESKTOP -->
            <div x-show="!loading && clientes.length > 0" class="hidden sm:block">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-200 text-gray-700 uppercase text-xs font-semibold">
                        <tr>
                            <th class="px-4 py-3">#</th>
                            <th class="px-4 py-3">Cliente</th>
                            <th class="px-4 py-3">DNI</th>
                            <th class="px-4 py-3">Cantidad de Compras</th>
                            <th class="px-4 py-3">Total Gastado</th>
                            <th class="px-4 py-3">Email</th>
                            <th class="px-4 py-3">Teléfono</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 divide-y divide-gray-200 text-sm">
                        <template x-for="(cliente, index) in clientes" :key="cliente.codigo">
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-center">
                                    <span x-text="index + 1" 
                                          :class="{
                                              'bg-yellow-400 text-white px-2 py-1 rounded-full text-xs': index === 0,
                                              'bg-gray-300 text-gray-700 px-2 py-1 rounded-full text-xs': index === 1,
                                              'bg-orange-400 text-white px-2 py-1 rounded-full text-xs': index === 2,
                                              'text-gray-500': index > 2
                                          }"></span>
                                </td>
                                <td class="px-4 py-3 font-medium" x-text="cliente.cliente"></td>
                                <td class="px-4 py-3 text-center font-mono" x-text="cliente.dni"></td>
                                <td class="px-4 py-3 text-center font-semibold text-blue-600" x-text="cliente.cantidad_compras"></td>
                                <td class="px-4 py-3 font-semibold text-green-600" x-text="formatoMoneda(cliente.total_gastado)"></td>
                                <td class="px-4 py-3 text-sm text-gray-500" x-text="cliente.email || 'N/A'"></td>
                                <td class="px-4 py-3" x-text="cliente.telefono || 'N/A'"></td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <!-- VISTA MÓVIL -->
            <div x-show="!loading && clientes.length > 0" class="sm:hidden space-y-4 p-4">
                <template x-for="(cliente, index) in clientes" :key="cliente.codigo">
                    <div class="bg-white rounded-lg shadow p-4 border">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex items-center gap-2">
                                <span x-text="index + 1" 
                                      :class="{
                                          'bg-yellow-400 text-white px-2 py-1 rounded-full text-sm font-bold': index === 0,
                                          'bg-gray-300 text-gray-700 px-2 py-1 rounded-full text-sm font-bold': index === 1,
                                          'bg-orange-400 text-white px-2 py-1 rounded-full text-sm font-bold': index === 2,
                                          'bg-gray-200 text-gray-600 px-2 py-1 rounded-full text-sm': index > 2
                                      }"></span>
                                <h3 class="font-bold text-lg" x-text="cliente.cliente"></h3>
                            </div>
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-semibold" 
                                  x-text="cliente.codigo"></span>
                        </div>
                        <div class="grid grid-cols-2 gap-3 text-sm text-gray-700">
                            <div class="text-center">
                                <div class="text-gray-500 text-xs">DNI</div>
                                <div class="font-mono" x-text="cliente.dni"></div>
                            </div>
                            <div class="text-center">
                                <div class="text-gray-500 text-xs">Compras</div>
                                <div class="font-bold text-blue-600 text-lg" x-text="cliente.cantidad_compras"></div>
                            </div>
                            <div class="col-span-2 text-center">
                                <div class="text-gray-500 text-xs">Total Gastado</div>
                                <div class="font-bold text-green-600 text-lg" x-text="formatoMoneda(cliente.total_gastado)"></div>
                            </div>
                            <div class="col-span-2 text-center pt-2 border-t">
                                <div class="text-gray-500 text-xs">Contacto</div>
                                <div class="text-sm" x-text="cliente.email || cliente.telefono || 'Sin contacto'"></div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <!-- SIN RESULTADOS -->
            <div x-show="!loading && clientes.length === 0" class="p-8 text-center">
                <div class="text-gray-400 text-4xl mb-4">👥</div>
                <h3 class="text-lg font-semibold text-gray-600 mb-2">No hay clientes registrados</h3>
                <p class="text-gray-500">No se encontraron clientes que cumplan con los criterios de búsqueda.</p>
            </div>
        </div>

        <!-- PESTAÑA INVENTARIO -->
        <div x-show="currentTab === 'inventario'">
            <!-- LOADING -->
            <div x-show="loading" class="p-8 text-center">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                <p class="mt-2 text-gray-600">Cargando inventario...</p>
            </div>

            <!-- RESUMEN ESTADÍSTICO -->
            <div x-show="!loading && inventario.length > 0" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6 p-4">
                <div class="bg-blue-50 p-4 rounded-lg border border-blue-200 text-center">
                    <div class="text-blue-600 font-semibold text-sm">Total Productos</div>
                    <div class="text-2xl font-bold text-blue-700" x-text="inventario.length"></div>
                </div>
                <div class="bg-green-50 p-4 rounded-lg border border-green-200 text-center">
                    <div class="text-green-600 font-semibold text-sm">Stock Total</div>
                    <div class="text-2xl font-bold text-green-700" 
                         x-text="inventario.reduce((sum, p) => sum + parseInt(p.stock || 0), 0)"></div>
                </div>
                <div class="bg-orange-50 p-4 rounded-lg border border-orange-200 text-center">
                    <div class="text-orange-600 font-semibold text-sm">Poco Stock (1-4)</div>
                    <div class="text-2xl font-bold text-orange-700" 
                         x-text="inventario.filter(p => parseInt(p.stock || 0) >= 1 && parseInt(p.stock || 0) <= 4).length"></div>
                </div>
                <div class="bg-red-50 p-4 rounded-lg border border-red-200 text-center">
                    <div class="text-red-600 font-semibold text-sm">Agotados</div>
                    <div class="text-2xl font-bold text-red-700" 
                         x-text="inventario.filter(p => parseInt(p.stock || 0) === 0).length"></div>
                </div>
            </div>

            <!-- TABLA DESKTOP -->
            <div x-show="!loading && inventario.length > 0" class="hidden sm:block">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-200 text-gray-700 uppercase text-xs font-semibold">
                        <tr>
                            <th class="px-4 py-3">Código</th>
                            <th class="px-4 py-3">Producto</th>
                            <th class="px-4 py-3">Descripción</th>
                            <th class="px-4 py-3">Precio</th>
                            <th class="px-4 py-3">Stock</th>
                            <th class="px-4 py-3">Estado</th>
                            <th class="px-4 py-3">Categoría</th>
                            <th class="px-4 py-3">Marca</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 divide-y divide-gray-200 text-sm">
                        <template x-for="(producto, index) in inventario" :key="producto.codigo">
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-center font-mono text-sm" x-text="producto.codigo"></td>
                                <td class="px-4 py-3 font-medium" x-text="producto.producto"></td>
                                <td class="px-4 py-3 text-sm text-gray-500 max-w-xs truncate" 
                                    :title="producto.descripcion" x-text="producto.descripcion || 'Sin descripción'"></td>
                                <td class="px-4 py-3 font-semibold text-green-600" x-text="formatoMoneda(producto.precio)"></td>
                                <td class="px-4 py-3 text-center">
                                    <span x-text="producto.stock" 
                                          :class="{
                                              'bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs font-semibold': producto.stock < 5,
                                              'bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-semibold': producto.stock >= 5 && producto.stock < 10,
                                              'bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-semibold': producto.stock >= 10
                                          }"></span>
                                </td>
                                <td class="px-4 py-3">
                                    <span x-text="calcularEstadoProducto(producto.stock, producto.estado)" 
                                          :class="getClaseEstadoProducto(producto.stock, producto.estado)"></span>
                                </td>
                                <td class="px-4 py-3 text-sm" x-text="producto.categoria"></td>
                                <td class="px-4 py-3 text-sm" x-text="producto.marca || 'N/A'"></td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <!-- VISTA MÓVIL -->
            <div x-show="!loading && inventario.length > 0" class="sm:hidden space-y-4 p-4">
                <template x-for="(producto, index) in inventario" :key="producto.codigo">
                    <div class="bg-white rounded-lg shadow p-4 border">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex items-center gap-2">
                                <h3 class="font-bold text-lg" x-text="producto.producto"></h3>
                                <span x-text="calcularEstadoProducto(producto.stock, producto.estado)" 
                                      :class="getClaseEstadoProducto(producto.stock, producto.estado)"></span>
                            </div>
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-semibold" 
                                  x-text="producto.codigo"></span>
                        </div>
                        
                        <div class="mb-3">
                            <div class="text-gray-500 text-xs">Descripción</div>
                            <div class="text-sm text-gray-700" x-text="producto.descripcion || 'Sin descripción'"></div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-3 text-sm text-gray-700">
                            <div class="text-center">
                                <div class="text-gray-500 text-xs">Precio</div>
                                <div class="font-bold text-green-600" x-text="formatoMoneda(producto.precio)"></div>
                            </div>
                            <div class="text-center">
                                <div class="text-gray-500 text-xs">Stock</div>
                                <div class="font-bold" 
                                     :class="{
                                         'text-red-600': producto.stock < 5,
                                         'text-yellow-600': producto.stock >= 5 && producto.stock < 10,
                                         'text-green-600': producto.stock >= 10
                                     }" 
                                     x-text="producto.stock"></div>
                            </div>
                            <div class="text-center">
                                <div class="text-gray-500 text-xs">Categoría</div>
                                <div class="font-medium" x-text="producto.categoria"></div>
                            </div>
                            <div class="text-center">
                                <div class="text-gray-500 text-xs">Marca</div>
                                <div class="font-medium" x-text="producto.marca || 'N/A'"></div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <!-- SIN RESULTADOS -->
            <div x-show="!loading && inventario.length === 0" class="p-8 text-center">
                <div class="text-gray-400 text-4xl mb-4">📦</div>
                <h3 class="text-lg font-semibold text-gray-600 mb-2">No hay productos en inventario</h3>
                <p class="text-gray-500">No se encontraron productos que cumplan con los criterios de búsqueda.</p>
            </div>
        </div>

        <!-- PESTAÑA VENTAS -->
        <div x-show="currentTab === 'ventas'">
            <!-- LOADING -->
            <div x-show="loading" class="p-8 text-center">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                <p class="mt-2 text-gray-600">Cargando ventas...</p>
            </div>

            <!-- RESUMEN ESTADÍSTICO -->
            <div x-show="!loading && ventas.length > 0" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 p-4">
                <div class="bg-blue-50 p-4 rounded-lg border border-blue-200 text-center">
                    <div class="text-blue-600 font-semibold text-sm">Total Ventas</div>
                    <div class="text-2xl font-bold text-blue-700" x-text="ventas.length"></div>
                </div>
                <div class="bg-green-50 p-4 rounded-lg border border-green-200 text-center">
                    <div class="text-green-600 font-semibold text-sm">Ingresos Totales</div>
                    <div class="text-2xl font-bold text-green-700" 
                         x-text="formatoMoneda(ventas.reduce((sum, v) => sum + parseFloat(v.total || 0), 0))"></div>
                </div>
                <div class="bg-purple-50 p-4 rounded-lg border border-purple-200 text-center">
                    <div class="text-purple-600 font-semibold text-sm">Productos Vendidos</div>
                    <div class="text-2xl font-bold text-purple-700" 
                         x-text="ventas.reduce((sum, v) => sum + parseInt(v.cantidad || 0), 0)"></div>
                </div>
            </div>

            <!-- TABLA DESKTOP -->
            <div x-show="!loading && ventas.length > 0" class="hidden sm:block">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-200 text-gray-700 uppercase text-xs font-semibold">
                        <tr>
                            <th class="px-4 py-3">Fecha</th>
                            <th class="px-4 py-3">Código Venta</th>
                            <th class="px-4 py-3">Cliente</th>
                            <th class="px-4 py-3">Productos</th>
                            <th class="px-4 py-3">Cantidad</th>
                            <th class="px-4 py-3">Total</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 divide-y divide-gray-200 text-sm">
                        <template x-for="(venta, index) in ventas" :key="venta.codigo">
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm" x-text="formatoFecha(venta.fecha)"></td>
                                <td class="px-4 py-3 text-center font-mono text-sm" x-text="venta.codigo"></td>
                                <td class="px-4 py-3 font-medium" x-text="venta.cliente"></td>
                                <td class="px-4 py-3 text-sm text-gray-500 max-w-xs" 
                                    :title="venta.producto" x-text="venta.producto"></td>
                                <td class="px-4 py-3 text-center font-semibold text-blue-600" x-text="venta.cantidad"></td>
                                <td class="px-4 py-3 font-semibold text-green-600" x-text="formatoMoneda(venta.total)"></td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <!-- VISTA MÓVIL -->
            <div x-show="!loading && ventas.length > 0" class="sm:hidden space-y-4 p-4">
                <template x-for="(venta, index) in ventas" :key="venta.codigo">
                    <div class="bg-white rounded-lg shadow p-4 border">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex items-center gap-2">
                                <h3 class="font-bold text-lg" x-text="venta.codigo"></h3>
                            </div>
                            <span class="text-sm text-gray-500" x-text="formatoFecha(venta.fecha)"></span>
                        </div>
                        
                        <div class="mb-3">
                            <div class="text-gray-500 text-xs">Cliente</div>
                            <div class="font-medium" x-text="venta.cliente"></div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="text-gray-500 text-xs">Productos</div>
                            <div class="text-sm text-gray-700" x-text="venta.producto"></div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-3 text-sm text-gray-700">
                            <div class="text-center">
                                <div class="text-gray-500 text-xs">Cantidad</div>
                                <div class="font-bold text-blue-600" x-text="venta.cantidad"></div>
                            </div>
                            <div class="text-center">
                                <div class="text-gray-500 text-xs">Total</div>
                                <div class="font-bold text-green-600" x-text="formatoMoneda(venta.total)"></div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <!-- SIN RESULTADOS -->
            <div x-show="!loading && ventas.length === 0" class="p-8 text-center">
                <div class="text-gray-400 text-4xl mb-4">💰</div>
                <h3 class="text-lg font-semibold text-gray-600 mb-2">No hay ventas registradas</h3>
                <p class="text-gray-500">No se encontraron ventas que cumplan con los criterios de búsqueda.</p>
            </div>
        </div>

        <!-- PESTAÑA PEDIDOS -->
        <div x-show="currentTab === 'pedidos'">
            <!-- LOADING -->
            <div x-show="loading" class="p-8 text-center">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                <p class="mt-2 text-gray-600">Cargando pedidos...</p>
            </div>

            <!-- RESUMEN ESTADÍSTICO (SIN TOTAL RECAUDADO) -->
            <div x-show="!loading && pedidos.length > 0" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 p-4">
                <div class="bg-blue-50 p-4 rounded-lg border border-blue-200 text-center">
                    <div class="text-blue-600 font-semibold text-sm">Total Pedidos</div>
                    <div class="text-2xl font-bold text-blue-700" x-text="pedidos.length"></div>
                </div>
                <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200 text-center">
                    <div class="text-yellow-600 font-semibold text-sm">Pendientes</div>
                    <div class="text-2xl font-bold text-yellow-700" 
                         x-text="pedidos.filter(p => p.estado === 'pendiente').length"></div>
                </div>
                <div class="bg-green-50 p-4 rounded-lg border border-green-200 text-center">
                    <div class="text-green-600 font-semibold text-sm">Entregados</div>
                    <div class="text-2xl font-bold text-green-700" 
                         x-text="pedidos.filter(p => p.estado === 'entregado').length"></div>
                </div>
            </div>

            <!-- TABLA DESKTOP -->
            <div x-show="!loading && pedidos.length > 0" class="hidden sm:block">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-200 text-gray-700 uppercase text-xs font-semibold">
                        <tr>
                            <th class="px-4 py-3">Código</th>
                            <th class="px-4 py-3">Cliente</th>
                            <th class="px-4 py-3">Productos</th>
                            <th class="px-4 py-3">Fecha Pedido</th>
                            <th class="px-4 py-3">Fecha Entrega</th>
                            <th class="px-4 py-3">Monto Total</th>
                            <th class="px-4 py-3">Distrito</th>
                            <th class="px-4 py-3">Recojo Tienda</th>
                            <th class="px-4 py-3">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 divide-y divide-gray-200 text-sm">
                        <template x-for="(pedido, index) in pedidos" :key="pedido.codigo">
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-center font-mono text-sm" x-text="pedido.codigo"></td>
                                <td class="px-4 py-3 font-medium" x-text="pedido.cliente"></td>
                                <td class="px-4 py-3 text-sm text-gray-500 max-w-xs" 
                                    :title="pedido.detalles" x-text="pedido.detalles"></td>
                                <td class="px-4 py-3 text-sm" x-text="formatoFecha(pedido.fecha_pedido)"></td>
                                <td class="px-4 py-3 text-sm" x-text="formatoFecha(calcularFechaEntrega(pedido.fecha_pedido))"></td>
                                <td class="px-4 py-3 font-semibold text-green-600" x-text="formatoMoneda(pedido.monto_total)"></td>
                                <td class="px-4 py-3 text-sm" x-text="pedido.distrito"></td>
                                <td class="px-4 py-3 text-center">
                                    <span x-text="pedido.recojo_tienda" 
                                          :class="{
                                              'bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs': pedido.recojo_tienda === 'Sí',
                                              'bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-xs': pedido.recojo_tienda === 'No'
                                          }"></span>
                                </td>
                                <td class="px-4 py-3">
                                    <span x-text="pedido.estado" 
                                          :class="{
                                              'bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs': pedido.estado === 'pendiente',
                                              'bg-orange-100 text-orange-800 px-2 py-1 rounded-full text-xs': pedido.estado === 'enviado',
                                              'bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs': pedido.estado === 'entregado'
                                          }"></span>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <!-- VISTA MÓVIL -->
            <div x-show="!loading && pedidos.length > 0" class="sm:hidden space-y-4 p-4">
                <template x-for="(pedido, index) in pedidos" :key="pedido.codigo">
                    <div class="bg-white rounded-lg shadow p-4 border">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex items-center gap-2">
                                <h3 class="font-bold text-lg" x-text="pedido.codigo"></h3>
                                <span x-text="pedido.estado" 
                                      :class="{
                                          'bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs': pedido.estado === 'pendiente',
                                          'bg-orange-100 text-orange-800 px-2 py-1 rounded-full text-xs': pedido.estado === 'enviado',
                                          'bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs': pedido.estado === 'entregado'
                                      }"></span>
                            </div>
                            <span class="text-sm text-gray-500" x-text="formatoFecha(pedido.fecha_pedido)"></span>
                        </div>
                        
                        <div class="mb-3">
                            <div class="text-gray-500 text-xs">Cliente</div>
                            <div class="font-medium" x-text="pedido.cliente"></div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="text-gray-500 text-xs">Productos</div>
                            <div class="text-sm text-gray-700" x-text="pedido.detalles"></div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-3 text-sm text-gray-700">
                            <div class="text-center">
                                <div class="text-gray-500 text-xs">Fecha Entrega</div>
                                <div class="font-medium" x-text="formatoFecha(calcularFechaEntrega(pedido.fecha_pedido))"></div>
                            </div>
                            <div class="text-center">
                                <div class="text-gray-500 text-xs">Total</div>
                                <div class="font-bold text-green-600" x-text="formatoMoneda(pedido.monto_total)"></div>
                            </div>
                            <div class="text-center">
                                <div class="text-gray-500 text-xs">Distrito</div>
                                <div class="font-medium" x-text="pedido.distrito"></div>
                            </div>
                            <div class="text-center">
                                <div class="text-gray-500 text-xs">Recojo</div>
                                <div class="font-medium" 
                                     :class="{'text-green-600': pedido.recojo_tienda === 'Sí', 'text-gray-600': pedido.recojo_tienda === 'No'}"
                                     x-text="pedido.recojo_tienda"></div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <!-- SIN RESULTADOS -->
            <div x-show="!loading && pedidos.length === 0" class="p-8 text-center">
                <div class="text-gray-400 text-4xl mb-4">🚚</div>
                <div class="text-lg font-semibold text-gray-600 mb-2">No hay pedidos registrados</div>
                <div class="text-gray-500">No se encontraron pedidos que cumplan con los criterios de búsqueda.</div>
            </div>
        </div>

        <!-- OTRAS PESTAÑAS (placeholder) -->
        <div x-show="currentTab !== 'top' && currentTab !== 'clientes' && currentTab !== 'inventario' && currentTab !== 'ventas' && currentTab !== 'pedidos'" class="p-8 text-center text-gray-500">
            <div class="text-4xl mb-4">📋</div>
            <h3 class="text-lg font-semibold mb-2">Pestaña en desarrollo</h3>
            <p>Esta funcionalidad estará disponible próximamente.</p>
        </div>

    </div>
</div>

<script>
function reportes() {
    return {
        currentTab: 'top',
        loading: false,
        exportando: false,
        usuarioActual: '{{ auth()->user()->name ?? "Usuario" }}',
        
        // 🔥 DATOS PARA TODAS LAS PESTAÑAS
        topProductos: [],
        clientes: [],
        inventario: [],
        ventas: [],
        pedidos: [],
        
        // 🔥 FILTROS
        filtrosClientes: {
            busqueda: '',
            min_compras: ''
        },
        filtrosInventario: {
            producto: '',
            estado: '',
            stock_minimo: ''
        },
        filtrosVentas: {
            fecha: '',
            cliente: '',
            producto: ''
        },
        filtrosPedidos: {
            fecha: '',
            estado: '',
            cliente: ''
        },

        init() {
            console.log('🔄 Inicializando reportes...');
            this.cargarTopProductos();
            
            this.$watch('currentTab', (value) => {
                console.log('Cambio de pestaña:', value);
                if (value === 'top') {
                    this.cargarTopProductos();
                } else if (value === 'clientes') {
                    this.cargarClientes();
                } else if (value === 'inventario') {
                    this.cargarInventario();
                } else if (value === 'ventas') {
                    this.cargarVentas();
                } else if (value === 'pedidos') {
                    this.cargarPedidos();
                }
            });
        },

        // 🔥 CARGAR TOP PRODUCTOS
        async cargarTopProductos() {
            this.loading = true;
            try {
                console.log('📦 Cargando TOP 20 productos...');
                const response = await fetch(`/api/reportes/top-productos`);
                
                if (!response.ok) {
                    throw new Error(`Error HTTP: ${response.status}`);
                }
                
                const data = await response.json();
                console.log('📦 Respuesta API TOP:', data);

                if (data.success) {
                    this.topProductos = data.top_productos || [];
                    console.log(`✅ TOP productos cargados: ${this.topProductos.length}`);
                } else {
                    console.error('❌ Error en respuesta API TOP');
                    this.topProductos = [];
                }
            } catch (error) {
                console.error('❌ Error al cargar top productos:', error);
                this.topProductos = [];
            } finally {
                this.loading = false;
            }
        },

        // 🔥 CARGAR CLIENTES
        async cargarClientes() {
            this.loading = true;
            try {
                console.log('👥 Cargando clientes...');
                const params = new URLSearchParams();
                if (this.filtrosClientes.busqueda) params.append('busqueda', this.filtrosClientes.busqueda);
                if (this.filtrosClientes.min_compras) params.append('min_compras', this.filtrosClientes.min_compras);

                const url = `/api/reportes/clientes?${params}`;
                console.log('👥 URL de clientes:', url);

                const response = await fetch(url);
                
                if (!response.ok) {
                    throw new Error(`Error HTTP: ${response.status}`);
                }
                
                const data = await response.json();
                console.log('👥 Respuesta API clientes:', data);

                if (data.success) {
                    this.clientes = data.clientes || [];
                    console.log(`✅ Clientes cargados: ${this.clientes.length}`);
                } else {
                    console.error('❌ Error en respuesta API clientes');
                    this.clientes = [];
                }
            } catch (error) {
                console.error('❌ Error al cargar clientes:', error);
                this.clientes = [];
            } finally {
                this.loading = false;
            }
        },

        // 🔥 CARGAR INVENTARIO
        async cargarInventario() {
            this.loading = true;
            try {
                console.log('📦 Cargando inventario...');
                const params = new URLSearchParams();
                if (this.filtrosInventario.producto) params.append('producto', this.filtrosInventario.producto);
                if (this.filtrosInventario.estado) params.append('estado', this.filtrosInventario.estado);
                if (this.filtrosInventario.stock_minimo) params.append('stock_minimo', this.filtrosInventario.stock_minimo);

                const url = `/api/reportes/inventario?${params}`;
                console.log('📦 URL de inventario:', url);

                const response = await fetch(url);
                
                if (!response.ok) {
                    throw new Error(`Error HTTP: ${response.status}`);
                }
                
                const data = await response.json();
                console.log('📦 Respuesta API inventario:', data);

                if (data.success) {
                    this.inventario = data.inventario || [];
                    console.log(`✅ Inventario cargado: ${this.inventario.length} productos`);
                } else {
                    console.error('❌ Error en respuesta API inventario');
                    this.inventario = [];
                }
            } catch (error) {
                console.error('❌ Error al cargar inventario:', error);
                this.inventario = [];
            } finally {
                this.loading = false;
            }
        },

        // 🔥 CARGAR VENTAS
        async cargarVentas() {
            this.loading = true;
            try {
                console.log('💰 Cargando ventas...');
                const params = new URLSearchParams();
                if (this.filtrosVentas.fecha) params.append('fecha', this.filtrosVentas.fecha);
                if (this.filtrosVentas.cliente) params.append('cliente', this.filtrosVentas.cliente);
                if (this.filtrosVentas.producto) params.append('producto', this.filtrosVentas.producto);

                const url = `/api/reportes/ventas?${params}`;
                console.log('💰 URL de ventas:', url);

                const response = await fetch(url);
                
                if (!response.ok) {
                    throw new Error(`Error HTTP: ${response.status}`);
                }
                
                const data = await response.json();
                console.log('💰 Respuesta API ventas:', data);

                if (data.success) {
                    this.ventas = data.ventas || [];
                    console.log(`✅ Ventas cargadas: ${this.ventas.length}`);
                } else {
                    console.error('❌ Error en respuesta API ventas');
                    this.ventas = [];
                }
            } catch (error) {
                console.error('❌ Error al cargar ventas:', error);
                this.ventas = [];
            } finally {
                this.loading = false;
            }
        },

        // 🔥 CARGAR PEDIDOS
        async cargarPedidos() {
            this.loading = true;
            try {
                console.log('🚚 Cargando pedidos...');
                const params = new URLSearchParams();
                if (this.filtrosPedidos.fecha) params.append('fecha', this.filtrosPedidos.fecha);
                if (this.filtrosPedidos.estado) params.append('estado', this.filtrosPedidos.estado);
                if (this.filtrosPedidos.cliente) params.append('cliente', this.filtrosPedidos.cliente);

                const url = `/api/reportes/pedidos?${params}`;
                console.log('🚚 URL de pedidos:', url);

                const response = await fetch(url);
                
                if (!response.ok) {
                    throw new Error(`Error HTTP: ${response.status}`);
                }
                
                const data = await response.json();
                console.log('🚚 Respuesta API pedidos:', data);

                if (data.success) {
                    this.pedidos = data.pedidos || [];
                    console.log(`✅ Pedidos cargados: ${this.pedidos.length}`);
                } else {
                    console.error('❌ Error en respuesta API pedidos');
                    this.pedidos = [];
                }
            } catch (error) {
                console.error('❌ Error al cargar pedidos:', error);
                this.pedidos = [];
            } finally {
                this.loading = false;
            }
        },

        // 🔥 FUNCIÓN PARA CALCULAR FECHA DE ENTREGA (SUMA 7 DÍAS)
        calcularFechaEntrega(fechaPedido) {
            if (!fechaPedido) return 'N/A';
            
            const fecha = new Date(fechaPedido);
            
            // 🔥 AQUÍ SE SUMAN LOS 7 DÍAS - PUEDES MODIFICAR ESTE NÚMERO
            fecha.setDate(fecha.getDate() + 7);
            
            return fecha.toISOString().split('T')[0];
        },

        // 🔥 CALCULAR ESTADO INTELIGENTE DEL PRODUCTO
        calcularEstadoProducto(stock, estado) {
            const stockNum = parseInt(stock || 0);
            
            // Usar el estado calculado del backend
            if (estado === 'descontinuado') return 'Descontinuado';
            if (estado === 'agotado') return 'Agotado';
            if (estado === 'poco_stock') return 'Poco stock';
            return 'Disponible';
        },

        // 🔥 OBTENER CLASE CSS SEGÚN ESTADO
        getClaseEstadoProducto(stock, estado) {
            // Usar el estado calculado del backend
            if (estado === 'descontinuado') {
                return 'bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-xs';
            }
            if (estado === 'agotado') {
                return 'bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs';
            }
            if (estado === 'poco_stock') {
                return 'bg-orange-100 text-orange-800 px-2 py-1 rounded-full text-xs';
            }
            return 'bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs';
        },

        // 🔥 FILTROS CLIENTES
        aplicarFiltrosClientes() {
            console.log('🔍 Aplicando filtros clientes...', this.filtrosClientes);
            this.cargarClientes();
        },

        limpiarFiltrosClientes() {
            console.log('🧹 Limpiando filtros clientes...');
            this.filtrosClientes = {
                busqueda: '',
                min_compras: ''
            };
            this.cargarClientes();
        },

        // 🔥 FILTROS INVENTARIO
        aplicarFiltrosInventario() {
            console.log('🔍 Aplicando filtros inventario...', this.filtrosInventario);
            this.cargarInventario();
        },

        limpiarFiltrosInventario() {
            console.log('🧹 Limpiando filtros inventario...');
            this.filtrosInventario = {
                producto: '',
                estado: '',
                stock_minimo: ''
            };
            this.cargarInventario();
        },

        // 🔥 FILTROS VENTAS
        aplicarFiltrosVentas() {
            console.log('🔍 Aplicando filtros ventas...', this.filtrosVentas);
            this.cargarVentas();
        },

        limpiarFiltrosVentas() {
            console.log('🧹 Limpiando filtros ventas...');
            this.filtrosVentas = {
                fecha: '',
                cliente: '',
                producto: ''
            };
            this.cargarVentas();
        },

        // 🔥 FILTROS PEDIDOS
        aplicarFiltrosPedidos() {
            console.log('🔍 Aplicando filtros pedidos...', this.filtrosPedidos);
            this.cargarPedidos();
        },

        limpiarFiltrosPedidos() {
            console.log('🧹 Limpiando filtros pedidos...');
            this.filtrosPedidos = {
                fecha: '',
                estado: '',
                cliente: ''
            };
            this.cargarPedidos();
        },

        // 🔥 EXPORTAR PDF PARA PEDIDOS
        async exportarPDFPedidos() {
            if (this.exportando) return;
            
            this.exportando = true;
            console.log('📄 Generando PDF de pedidos...');

            try {
                const pdfContainer = this.crearContenidoPDFPedidos();
                document.body.appendChild(pdfContainer);

                const canvas = await html2canvas(pdfContainer, {
                    scale: 2,
                    useCORS: true,
                    logging: false
                });

                const pdf = new jspdf.jsPDF('p', 'mm', 'a4');
                const imgData = canvas.toDataURL('image/png');
                
                const pdfWidth = pdf.internal.pageSize.getWidth();
                const pdfHeight = (canvas.height * pdfWidth) / canvas.width;

                pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
                pdf.save(`Reporte_Pedidos_${new Date().toISOString().split('T')[0]}.pdf`);

                document.body.removeChild(pdfContainer);
                console.log('✅ PDF de pedidos generado exitosamente');

            } catch (error) {
                console.error('❌ Error al generar PDF de pedidos:', error);
                alert('Error al generar el PDF. Intenta nuevamente.');
            } finally {
                this.exportando = false;
            }
        },

        // 🔥 CREAR CONTENIDO PDF PARA PEDIDOS
        crearContenidoPDFPedidos() {
            const fechaActual = new Date().toLocaleDateString('es-PE', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });

            const totalPedidos = this.pedidos.length;
            const pedidosPendientes = this.pedidos.filter(p => p.estado === 'pendiente').length;
            const pedidosEnviados = this.pedidos.filter(p => p.estado === 'enviado').length;
            const pedidosEntregados = this.pedidos.filter(p => p.estado === 'entregado').length;

            const container = document.createElement('div');
            container.style.cssText = `
                position: fixed;
                left: -10000px;
                top: -10000px;
                width: 210mm;
                padding: 20mm;
                background: white;
                font-family: Arial, sans-serif;
                color: #333;
            `;

            container.innerHTML = `
                <div style="text-align: center; margin-bottom: 25px; border-bottom: 3px solid #2c5aa0; padding-bottom: 15px;">
                    <div style="font-size: 24px; font-weight: bold; color: #2c5aa0; margin-bottom: 5px;">INVERSIONES ALIAGA</div>
                    <div style="font-size: 14px; color: #666; margin-bottom: 10px;">RUC: 10755123043</div>
                    <div style="font-size: 20px; font-weight: bold; color: #333; margin: 15px 0 5px 0;">REPORTE DE PEDIDOS</div>
                </div>
                
                <div style="display: flex; justify-content: space-between; margin-bottom: 25px; padding: 10px; background-color: #f8f9fa; border-radius: 5px; font-size: 12px;">
                    <div><strong>Fecha de generación:</strong> ${fechaActual}</div>
                </div>

                <!-- RESUMEN ESTADÍSTICO SIN TOTAL RECAUDADO -->
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-bottom: 25px; font-size: 10px;">
                    <div style="background: #e3f2fd; padding: 12px; border-radius: 6px; text-align: center;">
                        <div style="color: #1976d2;">Total Pedidos</div>
                        <div style="font-size: 18px; font-weight: bold; color: #1976d2;">${totalPedidos}</div>
                    </div>
                    <div style="background: #fff3e0; padding: 12px; border-radius: 6px; text-align: center;">
                        <div style="color: #ef6c00;">Pendientes</div>
                        <div style="font-size: 18px; font-weight: bold; color: #ef6c00;">${pedidosPendientes}</div>
                    </div>
                    <div style="background: #ffecb3; padding: 12px; border-radius: 6px; text-align: center;">
                        <div style="color: #ff8f00;">Enviados</div>
                        <div style="font-size: 18px; font-weight: bold; color: #ff8f00;">${pedidosEnviados}</div>
                    </div>
                    <div style="background: #e8f5e8; padding: 12px; border-radius: 6px; text-align: center;">
                        <div style="color: #2e7d32;">Entregados</div>
                        <div style="font-size: 18px; font-weight: bold; color: #2e7d32;">${pedidosEntregados}</div>
                    </div>
                </div>
                
                <table style="width: 100%; border-collapse: collapse; margin-top: 15px; font-size: 8px;">
                    <thead>
                        <tr>
                            <th style="background-color: #2c5aa0; color: white; border: 1px solid #1e3d6f; padding: 8px 4px; text-align: left; font-weight: bold; width: 6%;">Código</th>
                            <th style="background-color: #2c5aa0; color: white; border: 1px solid #1e3d6f; padding: 8px 4px; text-align: left; font-weight: bold; width: 12%;">Cliente</th>
                            <th style="background-color: #2c5aa0; color: white; border: 1px solid #1e3d6f; padding: 8px 4px; text-align: left; font-weight: bold; width: 20%;">Productos</th>
                            <th style="background-color: #2c5aa0; color: white; border: 1px solid #1e3d6f; padding: 8px 4px; text-align: left; font-weight: bold; width: 8%;">Fecha Pedido</th>
                            <th style="background-color: #2c5aa0; color: white; border: 1px solid #1e3d6f; padding: 8px 4px; text-align: left; font-weight: bold; width: 8%;">Fecha Entrega</th>
                            <th style="background-color: #2c5aa0; color: white; border: 1px solid #1e3d6f; padding: 8px 4px; text-align: right; font-weight: bold; width: 8%;">Total</th>
                            <th style="background-color: #2c5aa0; color: white; border: 1px solid #1e3d6f; padding: 8px 4px; text-align: left; font-weight: bold; width: 10%;">Distrito</th>
                            <th style="background-color: #2c5aa0; color: white; border: 1px solid #1e3d6f; padding: 8px 4px; text-align: center; font-weight: bold; width: 8%;">Recojo</th>
                            <th style="background-color: #2c5aa0; color: white; border: 1px solid #1e3d6f; padding: 8px 4px; text-align: center; font-weight: bold; width: 10%;">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${this.pedidos.map((pedido, index) => {
                            const bgColor = pedido.estado === 'pendiente' ? '#fff3e0' : 
                                          pedido.estado === 'enviado' ? '#ffecb3' : 
                                          '#e8f5e8';
                            return `
                                <tr style="background-color: ${bgColor};">
                                    <td style="border: 1px solid #ddd; padding: 6px 4px; font-weight: bold;">${pedido.codigo}</td>
                                    <td style="border: 1px solid #ddd; padding: 6px 4px;">${pedido.cliente}</td>
                                    <td style="border: 1px solid #ddd; padding: 6px 4px; font-size: 7px;">${pedido.detalles}</td>
                                    <td style="border: 1px solid #ddd; padding: 6px 4px;">${this.formatoFecha(pedido.fecha_pedido)}</td>
                                    <td style="border: 1px solid #ddd; padding: 6px 4px;">${this.formatoFecha(this.calcularFechaEntrega(pedido.fecha_pedido))}</td>
                                    <td style="border: 1px solid #ddd; padding: 6px 4px; text-align: right; font-weight: bold;">${this.formatoMoneda(pedido.monto_total)}</td>
                                    <td style="border: 1px solid #ddd; padding: 6px 4px;">${pedido.distrito}</td>
                                    <td style="border: 1px solid #ddd; padding: 6px 4px; text-align: center;">
                                        <span style="padding: 2px 6px; border-radius: 10px; font-size: 7px; font-weight: bold; 
                                            ${pedido.recojo_tienda === 'Sí' ? 'background: #e8f5e8; color: #2e7d32;' : 
                                              'background: #f5f5f5; color: #666;'}">
                                            ${pedido.recojo_tienda}
                                        </span>
                                    </td>
                                    <td style="border: 1px solid #ddd; padding: 6px 4px; text-align: center;">
                                        <span style="padding: 2px 6px; border-radius: 10px; font-size: 7px; font-weight: bold; 
                                            ${pedido.estado === 'pendiente' ? 'background: #fff3e0; color: #ef6c00;' : 
                                              pedido.estado === 'enviado' ? 'background: #ffecb3; color: #ff8f00;' : 
                                              'background: #e8f5e8; color: #2e7d32;'}">
                                            ${pedido.estado}
                                        </span>
                                    </td>
                                </tr>
                            `;
                        }).join('')}
                    </tbody>
                </table>
                
                <div style="margin-top: 30px; padding-top: 15px; border-top: 1px solid #ddd; font-size: 8px; color: #666; text-align: center;">
                    Documento generado automáticamente por el Sistema de Inversiones Aliaga | ${fechaActual}
                </div>
            `;

            return container;
        },

        // 🔥 EXPORTAR PDF PARA VENTAS
        async exportarPDFVentas() {
            if (this.exportando) return;
            
            this.exportando = true;
            console.log('📄 Generando PDF de ventas...');

            try {
                const pdfContainer = this.crearContenidoPDFVentas();
                document.body.appendChild(pdfContainer);

                const canvas = await html2canvas(pdfContainer, {
                    scale: 2,
                    useCORS: true,
                    logging: false
                });

                const pdf = new jspdf.jsPDF('p', 'mm', 'a4');
                const imgData = canvas.toDataURL('image/png');
                
                const pdfWidth = pdf.internal.pageSize.getWidth();
                const pdfHeight = (canvas.height * pdfWidth) / canvas.width;

                pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
                pdf.save(`Reporte_Ventas_${new Date().toISOString().split('T')[0]}.pdf`);

                document.body.removeChild(pdfContainer);
                console.log('✅ PDF de ventas generado exitosamente');

            } catch (error) {
                console.error('❌ Error al generar PDF de ventas:', error);
                alert('Error al generar el PDF. Intenta nuevamente.');
            } finally {
                this.exportando = false;
            }
        },

        // 🔥 CREAR CONTENIDO PDF PARA VENTAS
        crearContenidoPDFVentas() {
            const fechaActual = new Date().toLocaleDateString('es-PE', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });

            const totalVentas = this.ventas.length;
            const ingresosTotales = this.ventas.reduce((sum, v) => sum + parseFloat(v.total || 0), 0);
            const productosVendidos = this.ventas.reduce((sum, v) => sum + parseInt(v.cantidad || 0), 0);

            const container = document.createElement('div');
            container.style.cssText = `
                position: fixed;
                left: -10000px;
                top: -10000px;
                width: 210mm;
                padding: 20mm;
                background: white;
                font-family: Arial, sans-serif;
                color: #333;
            `;

            container.innerHTML = `
                <div style="text-align: center; margin-bottom: 25px; border-bottom: 3px solid #2c5aa0; padding-bottom: 15px;">
                    <div style="font-size: 24px; font-weight: bold; color: #2c5aa0; margin-bottom: 5px;">INVERSIONES ALIAGA</div>
                    <div style="font-size: 14px; color: #666; margin-bottom: 10px;">RUC: 10755123043</div>
                    <div style="font-size: 20px; font-weight: bold; color: #333; margin: 15px 0 5px 0;">REPORTE DE VENTAS</div>
                </div>
                
                <div style="display: flex; justify-content: space-between; margin-bottom: 25px; padding: 10px; background-color: #f8f9fa; border-radius: 5px; font-size: 12px;">
                    <div><strong>Fecha de generación:</strong> ${fechaActual}</div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-bottom: 25px; font-size: 10px;">
                    <div style="background: #e3f2fd; padding: 12px; border-radius: 6px; text-align: center;">
                        <div style="color: #1976d2;">Total Ventas</div>
                        <div style="font-size: 18px; font-weight: bold; color: #1976d2;">${totalVentas}</div>
                    </div>
                    <div style="background: #e8f5e8; padding: 12px; border-radius: 6px; text-align: center;">
                        <div style="color: #2e7d32;">Ingresos Totales</div>
                        <div style="font-size: 16px; font-weight: bold; color: #2e7d32;">${this.formatoMoneda(ingresosTotales)}</div>
                    </div>
                    <div style="background: #f3e5f5; padding: 12px; border-radius: 6px; text-align: center;">
                        <div style="color: #7b1fa2;">Productos Vendidos</div>
                        <div style="font-size: 18px; font-weight: bold; color: #7b1fa2;">${productosVendidos}</div>
                    </div>
                </div>
                
                <table style="width: 100%; border-collapse: collapse; margin-top: 15px; font-size: 8px;">
                    <thead>
                        <tr>
                            <th style="background-color: #2c5aa0; color: white; border: 1px solid #1e3d6f; padding: 8px 4px; text-align: left; font-weight: bold; width: 10%;">Fecha</th>
                            <th style="background-color: #2c5aa0; color: white; border: 1px solid #1e3d6f; padding: 8px 4px; text-align: left; font-weight: bold; width: 8%;">Código</th>
                            <th style="background-color: #2c5aa0; color: white; border: 1px solid #1e3d6f; padding: 8px 4px; text-align: left; font-weight: bold; width: 15%;">Cliente</th>
                            <th style="background-color: #2c5aa0; color: white; border: 1px solid #1e3d6f; padding: 8px 4px; text-align: left; font-weight: bold; width: 35%;">Productos</th>
                            <th style="background-color: #2c5aa0; color: white; border: 1px solid #1e3d6f; padding: 8px 4px; text-align: center; font-weight: bold; width: 8%;">Cantidad</th>
                            <th style="background-color: #2c5aa0; color: white; border: 1px solid #1e3d6f; padding: 8px 4px; text-align: right; font-weight: bold; width: 12%;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${this.ventas.map((venta, index) => {
                            return `
                                <tr>
                                    <td style="border: 1px solid #ddd; padding: 6px 4px;">${this.formatoFecha(venta.fecha)}</td>
                                    <td style="border: 1px solid #ddd; padding: 6px 4px; font-weight: bold;">${venta.codigo}</td>
                                    <td style="border: 1px solid #ddd; padding: 6px 4px;">${venta.cliente}</td>
                                    <td style="border: 1px solid #ddd; padding: 6px 4px; font-size: 7px;">${venta.producto}</td>
                                    <td style="border: 1px solid #ddd; padding: 6px 4px; text-align: center; font-weight: bold;">${venta.cantidad}</td>
                                    <td style="border: 1px solid #ddd; padding: 6px 4px; text-align: right; font-weight: bold;">${this.formatoMoneda(venta.total)}</td>
                                </tr>
                            `;
                        }).join('')}
                        <tr style="background-color: #2c5aa0; color: white; font-weight: bold;">
                            <td colspan="4" style="border: 1px solid #1e3d6f; padding: 8px 4px; text-align: right;">TOTALES GENERALES:</td>
                            <td style="border: 1px solid #1e3d6f; padding: 8px 4px; text-align: center;">${productosVendidos}</td>
                            <td style="border: 1px solid #1e3d6f; padding: 8px 4px; text-align: right;">${this.formatoMoneda(ingresosTotales)}</td>
                        </tr>
                    </tbody>
                </table>
                
                <div style="margin-top: 30px; padding-top: 15px; border-top: 1px solid #ddd; font-size: 8px; color: #666; text-align: center;">
                    Documento generado automáticamente por el Sistema de Inversiones Aliaga | ${fechaActual}
                </div>
            `;

            return container;
        },

        // 🔥 MANTENER FUNCIONES EXISTENTES PARA OTRAS PESTAÑAS
        async exportarPDFInventario() {
            if (this.exportando) return;
            
            this.exportando = true;
            console.log('📄 Generando PDF de inventario...');

            try {
                const pdfContainer = this.crearContenidoPDFInventario();
                document.body.appendChild(pdfContainer);

                const canvas = await html2canvas(pdfContainer, {
                    scale: 2,
                    useCORS: true,
                    logging: false
                });

                const pdf = new jspdf.jsPDF('p', 'mm', 'a4');
                const imgData = canvas.toDataURL('image/png');
                
                const pdfWidth = pdf.internal.pageSize.getWidth();
                const pdfHeight = (canvas.height * pdfWidth) / canvas.width;

                pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
                pdf.save(`Reporte_Inventario_${new Date().toISOString().split('T')[0]}.pdf`);

                document.body.removeChild(pdfContainer);
                console.log('✅ PDF de inventario generado exitosamente');

            } catch (error) {
                console.error('❌ Error al generar PDF de inventario:', error);
                alert('Error al generar el PDF. Intenta nuevamente.');
            } finally {
                this.exportando = false;
            }
        },

        async exportarPDFClientes() {
            if (this.exportando) return;
            
            this.exportando = true;
            console.log('📄 Generando PDF de clientes...');

            try {
                const pdfContainer = this.crearContenidoPDFClientes();
                document.body.appendChild(pdfContainer);

                const canvas = await html2canvas(pdfContainer, {
                    scale: 2,
                    useCORS: true,
                    logging: false
                });

                const pdf = new jspdf.jsPDF('p', 'mm', 'a4');
                const imgData = canvas.toDataURL('image/png');
                
                const pdfWidth = pdf.internal.pageSize.getWidth();
                const pdfHeight = (canvas.height * pdfWidth) / canvas.width;

                pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
                pdf.save(`Reporte_Clientes_${new Date().toISOString().split('T')[0]}.pdf`);

                document.body.removeChild(pdfContainer);
                console.log('✅ PDF de clientes generado exitosamente');

            } catch (error) {
                console.error('❌ Error al generar PDF de clientes:', error);
                alert('Error al generar el PDF. Intenta nuevamente.');
            } finally {
                this.exportando = false;
            }
        },

        async exportarPDF() {
            if (this.exportando) return;
            
            this.exportando = true;
            console.log('📄 Generando PDF de top productos...');

            try {
                const pdfContainer = this.crearContenidoPDF();
                document.body.appendChild(pdfContainer);

                const canvas = await html2canvas(pdfContainer, {
                    scale: 2,
                    useCORS: true,
                    logging: false
                });

                const pdf = new jspdf.jsPDF('p', 'mm', 'a4');
                const imgData = canvas.toDataURL('image/png');
                
                const pdfWidth = pdf.internal.pageSize.getWidth();
                const pdfHeight = (canvas.height * pdfWidth) / canvas.width;

                pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
                pdf.save(`Reporte_Top_Productos_${new Date().toISOString().split('T')[0]}.pdf`);

                document.body.removeChild(pdfContainer);
                console.log('✅ PDF de top productos generado exitosamente');

            } catch (error) {
                console.error('❌ Error al generar PDF de top productos:', error);
                alert('Error al generar el PDF. Intenta nuevamente.');
            } finally {
                this.exportando = false;
            }
        },

        crearContenidoPDFInventario() {
            const fechaActual = new Date().toLocaleDateString('es-PE', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });

            const totalProductos = this.inventario.length;
            const stockTotal = this.inventario.reduce((sum, p) => sum + parseInt(p.stock || 0), 0);
            const pocoStock = this.inventario.filter(p => parseInt(p.stock || 0) >= 1 && parseInt(p.stock || 0) <= 4).length;
            const agotados = this.inventario.filter(p => parseInt(p.stock || 0) === 0).length;

            const container = document.createElement('div');
            container.style.cssText = `
                position: fixed;
                left: -10000px;
                top: -10000px;
                width: 210mm;
                padding: 20mm;
                background: white;
                font-family: Arial, sans-serif;
                color: #333;
            `;

            container.innerHTML = `
                <div style="text-align: center; margin-bottom: 25px; border-bottom: 3px solid #2c5aa0; padding-bottom: 15px;">
                    <div style="font-size: 24px; font-weight: bold; color: #2c5aa0; margin-bottom: 5px;">INVERSIONES ALIAGA</div>
                    <div style="font-size: 14px; color: #666; margin-bottom: 10px;">RUC: 10755123043</div>
                    <div style="font-size: 20px; font-weight: bold; color: #333; margin: 15px 0 5px 0;">REPORTE DE INVENTARIO</div>
                </div>
                
                <div style="display: flex; justify-content: space-between; margin-bottom: 25px; padding: 10px; background-color: #f8f9fa; border-radius: 5px; font-size: 12px;">
                    <div><strong>Fecha de generación:</strong> ${fechaActual}</div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-bottom: 25px; font-size: 10px;">
                    <div style="background: #e3f2fd; padding: 12px; border-radius: 6px; text-align: center;">
                        <div style="color: #1976d2;">Total Productos</div>
                        <div style="font-size: 18px; font-weight: bold; color: #1976d2;">${totalProductos}</div>
                    </div>
                    <div style="background: #e8f5e8; padding: 12px; border-radius: 6px; text-align: center;">
                        <div style="color: #2e7d32;">Stock Total</div>
                        <div style="font-size: 18px; font-weight: bold; color: #2e7d32;">${stockTotal}</div>
                    </div>
                    <div style="background: #fff3e0; padding: 12px; border-radius: 6px; text-align: center;">
                        <div style="color: #ef6c00;">Poco Stock (1-4)</div>
                        <div style="font-size: 18px; font-weight: bold; color: #ef6c00;">${pocoStock}</div>
                    </div>
                    <div style="background: #ffebee; padding: 12px; border-radius: 6px; text-align: center;">
                        <div style="color: #c62828;">Agotados</div>
                        <div style="font-size: 18px; font-weight: bold; color: #c62828;">${agotados}</div>
                    </div>
                </div>
                
                <table style="width: 100%; border-collapse: collapse; margin-top: 15px; font-size: 8px;">
                    <thead>
                        <tr>
                            <th style="background-color: #2c5aa0; color: white; border: 1px solid #1e3d6f; padding: 8px 4px; text-align: left; font-weight: bold; width: 8%;">Código</th>
                            <th style="background-color: #2c5aa0; color: white; border: 1px solid #1e3d6f; padding: 8px 4px; text-align: left; font-weight: bold; width: 15%;">Producto</th>
                            <th style="background-color: #2c5aa0; color: white; border: 1px solid #1e3d6f; padding: 8px 4px; text-align: left; font-weight: bold; width: 25%;">Descripción</th>
                            <th style="background-color: #2c5aa0; color: white; border: 1px solid #1e3d6f; padding: 8px 4px; text-align: right; font-weight: bold; width: 8%;">Precio</th>
                            <th style="background-color: #2c5aa0; color: white; border: 1px solid #1e3d6f; padding: 8px 4px; text-align: center; font-weight: bold; width: 6%;">Stock</th>
                            <th style="background-color: #2c5aa0; color: white; border: 1px solid #1e3d6f; padding: 8px 4px; text-align: center; font-weight: bold; width: 10%;">Estado</th>
                            <th style="background-color: #2c5aa0; color: white; border: 1px solid #1e3d6f; padding: 8px 4px; text-align: left; font-weight: bold; width: 12%;">Categoría</th>
                            <th style="background-color: #2c5aa0; color: white; border: 1px solid #1e3d6f; padding: 8px 4px; text-align: left; font-weight: bold; width: 10%;">Marca</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${this.inventario.map((producto, index) => {
                            const stockColor = producto.stock < 5 ? '#ffebee' : 
                                             producto.stock >= 5 && producto.stock < 10 ? '#fff3e0' : 
                                             '#e8f5e8';
                            return `
                                <tr style="background-color: ${stockColor};">
                                    <td style="border: 1px solid #ddd; padding: 6px 4px; font-weight: bold;">${producto.codigo}</td>
                                    <td style="border: 1px solid #ddd; padding: 6px 4px;">${producto.producto}</td>
                                    <td style="border: 1px solid #ddd; padding: 6px 4px; font-size: 7px;">${producto.descripcion || 'Sin descripción'}</td>
                                    <td style="border: 1px solid #ddd; padding: 6px 4px; text-align: right; font-weight: bold;">${this.formatoMoneda(producto.precio)}</td>
                                    <td style="border: 1px solid #ddd; padding: 6px 4px; text-align: center; font-weight: bold;">${producto.stock}</td>
                                    <td style="border: 1px solid #ddd; padding: 6px 4px; text-align: center;">
                                        <span style="padding: 2px 6px; border-radius: 10px; font-size: 7px; font-weight: bold; 
                                            ${producto.estado === 'disponible' ? 'background: #e8f5e8; color: #2e7d32;' : 
                                              producto.estado === 'agotado' ? 'background: #ffebee; color: #c62828;' : 
                                              producto.estado === 'poco_stock' ? 'background: #fff3e0; color: #ef6c00;' : 
                                              'background: #f5f5f5; color: #666;'}">
                                            ${this.calcularEstadoProducto(producto.stock, producto.estado)}
                                        </span>
                                    </td>
                                    <td style="border: 1px solid #ddd; padding: 6px 4px;">${producto.categoria}</td>
                                    <td style="border: 1px solid #ddd; padding: 6px 4px;">${producto.marca || 'N/A'}</td>
                                </tr>
                            `;
                        }).join('')}
                    </tbody>
                </table>
                
                <div style="margin-top: 30px; padding-top: 15px; border-top: 1px solid #ddd; font-size: 8px; color: #666; text-align: center;">
                    Documento generado automáticamente por el Sistema de Inversiones Aliaga | ${fechaActual}
                </div>
            `;

            return container;
        },

        crearContenidoPDFClientes() {
            const fechaActual = new Date().toLocaleDateString('es-PE', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });

            const totalClientes = this.clientes.length;
            const totalCompras = this.clientes.reduce((sum, c) => sum + parseInt(c.cantidad_compras || 0), 0);
            const totalGastado = this.clientes.reduce((sum, c) => sum + parseFloat(c.total_gastado || 0), 0);

            const container = document.createElement('div');
            container.style.cssText = `
                position: fixed;
                left: -10000px;
                top: -10000px;
                width: 210mm;
                padding: 20mm;
                background: white;
                font-family: Arial, sans-serif;
                color: #333;
            `;

            container.innerHTML = `
                <div style="text-align: center; margin-bottom: 25px; border-bottom: 3px solid #2c5aa0; padding-bottom: 15px;">
                    <div style="font-size: 24px; font-weight: bold; color: #2c5aa0; margin-bottom: 5px;">INVERSIONES ALIAGA</div>
                    <div style="font-size: 14px; color: #666; margin-bottom: 10px;">RUC: 10755123043</div>
                    <div style="font-size: 20px; font-weight: bold; color: #333; margin: 15px 0 5px 0;">REPORTE DE CLIENTES</div>
                </div>
                
                <div style="display: flex; justify-content: space-between; margin-bottom: 25px; padding: 10px; background-color: #f8f9fa; border-radius: 5px; font-size: 12px;">
                    <div><strong>Fecha de generación:</strong> ${fechaActual}</div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-bottom: 25px; font-size: 10px;">
                    <div style="background: #e3f2fd; padding: 12px; border-radius: 6px; text-align: center;">
                        <div style="color: #1976d2;">Total Clientes</div>
                        <div style="font-size: 18px; font-weight: bold; color: #1976d2;">${totalClientes}</div>
                    </div>
                    <div style="background: #e8f5e8; padding: 12px; border-radius: 6px; text-align: center;">
                        <div style="color: #2e7d32;">Total Compras</div>
                        <div style="font-size: 18px; font-weight: bold; color: #2e7d32;">${totalCompras}</div>
                    </div>
                    <div style="background: #f3e5f5; padding: 12px; border-radius: 6px; text-align: center;">
                        <div style="color: #7b1fa2;">Total Gastado</div>
                        <div style="font-size: 16px; font-weight: bold; color: #7b1fa2;">${this.formatoMoneda(totalGastado)}</div>
                    </div>
                </div>
                
                <table style="width: 100%; border-collapse: collapse; margin-top: 15px; font-size: 8px;">
                    <thead>
                        <tr>
                            <th style="background-color: #2c5aa0; color: white; border: 1px solid #1e3d6f; padding: 8px 4px; text-align: center; font-weight: bold; width: 5%;">#</th>
                            <th style="background-color: #2c5aa0; color: white; border: 1px solid #1e3d6f; padding: 8px 4px; text-align: left; font-weight: bold; width: 20%;">Cliente</th>
                            <th style="background-color: #2c5aa0; color: white; border: 1px solid #1e3d6f; padding: 8px 4px; text-align: center; font-weight: bold; width: 10%;">DNI</th>
                            <th style="background-color: #2c5aa0; color: white; border: 1px solid #1e3d6f; padding: 8px 4px; text-align: center; font-weight: bold; width: 10%;">Compras</th>
                            <th style="background-color: #2c5aa0; color: white; border: 1px solid #1e3d6f; padding: 8px 4px; text-align: right; font-weight: bold; width: 15%;">Total Gastado</th>
                            <th style="background-color: #2c5aa0; color: white; border: 1px solid #1e3d6f; padding: 8px 4px; text-align: left; font-weight: bold; width: 20%;">Email</th>
                            <th style="background-color: #2c5aa0; color: white; border: 1px solid #1e3d6f; padding: 8px 4px; text-align: left; font-weight: bold; width: 15%;">Teléfono</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${this.clientes.map((cliente, index) => {
                            const bgColor = index === 0 ? '#fff3e0' : 
                                          index === 1 ? '#f5f5f5' : 
                                          index === 2 ? '#fff8e1' : 
                                          '#ffffff';
                            return `
                                <tr style="background-color: ${bgColor};">
                                    <td style="border: 1px solid #ddd; padding: 6px 4px; text-align: center; font-weight: bold;">${index + 1}</td>
                                    <td style="border: 1px solid #ddd; padding: 6px 4px;">${cliente.cliente}</td>
                                    <td style="border: 1px solid #ddd; padding: 6px 4px; text-align: center; font-family: monospace;">${cliente.dni}</td>
                                    <td style="border: 1px solid #ddd; padding: 6px 4px; text-align: center; font-weight: bold;">${cliente.cantidad_compras}</td>
                                    <td style="border: 1px solid #ddd; padding: 6px 4px; text-align: right; font-weight: bold;">${this.formatoMoneda(cliente.total_gastado)}</td>
                                    <td style="border: 1px solid #ddd; padding: 6px 4px;">${cliente.email || 'N/A'}</td>
                                    <td style="border: 1px solid #ddd; padding: 6px 4px;">${cliente.telefono || 'N/A'}</td>
                                </tr>
                            `;
                        }).join('')}
                        <tr style="background-color: #2c5aa0; color: white; font-weight: bold;">
                            <td colspan="3" style="border: 1px solid #1e3d6f; padding: 8px 4px; text-align: right;">TOTALES GENERALES:</td>
                            <td style="border: 1px solid #1e3d6f; padding: 8px 4px; text-align: center;">${totalCompras}</td>
                            <td style="border: 1px solid #1e3d6f; padding: 8px 4px; text-align: right;">${this.formatoMoneda(totalGastado)}</td>
                            <td colspan="2" style="border: 1px solid #1e3d6f; padding: 8px 4px;"></td>
                        </tr>
                    </tbody>
                </table>
                
                <div style="margin-top: 30px; padding-top: 15px; border-top: 1px solid #ddd; font-size: 8px; color: #666; text-align: center;">
                    Documento generado automáticamente por el Sistema de Inversiones Aliaga | ${fechaActual}
                </div>
            `;

            return container;
        },

        crearContenidoPDF() {
            const fechaActual = new Date().toLocaleDateString('es-PE', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });

            const totalIngresos = this.topProductos.reduce((sum, p) => sum + parseFloat(p.ingresos_generados || 0), 0);
            const totalVendidos = this.topProductos.reduce((sum, p) => sum + parseInt(p.cantidad_vendida || 0), 0);

            const container = document.createElement('div');
            container.style.cssText = `
                position: fixed;
                left: -10000px;
                top: -10000px;
                width: 210mm;
                padding: 20mm;
                background: white;
                font-family: Arial, sans-serif;
                color: #333;
            `;

            container.innerHTML = `
                <div style="text-align: center; margin-bottom: 25px; border-bottom: 3px solid #2c5aa0; padding-bottom: 15px;">
                    <div style="font-size: 24px; font-weight: bold; color: #2c5aa0; margin-bottom: 5px;">INVERSIONES ALIAGA</div>
                    <div style="font-size: 14px; color: #666; margin-bottom: 10px;">RUC: 10755123043</div>
                    <div style="font-size: 20px; font-weight: bold; color: #333; margin: 15px 0 5px 0;">TOP 20 PRODUCTOS MÁS VENDIDOS</div>
                </div>
                
                <div style="display: flex; justify-content: space-between; margin-bottom: 25px; padding: 10px; background-color: #f8f9fa; border-radius: 5px; font-size: 12px;">
                    <div><strong>Fecha de generación:</strong> ${fechaActual}</div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; margin-bottom: 25px; font-size: 10px;">
                    <div style="background: #e8f5e8; padding: 12px; border-radius: 6px; text-align: center;">
                        <div style="color: #2e7d32;">Total Ingresos Generados</div>
                        <div style="font-size: 16px; font-weight: bold; color: #2e7d32;">${this.formatoMoneda(totalIngresos)}</div>
                    </div>
                    <div style="background: #e3f2fd; padding: 12px; border-radius: 6px; text-align: center;">
                        <div style="color: #1976d2;">Total Productos Vendidos</div>
                        <div style="font-size: 18px; font-weight: bold; color: #1976d2;">${totalVendidos}</div>
                    </div>
                </div>
                
                <table style="width: 100%; border-collapse: collapse; margin-top: 15px; font-size: 8px;">
                    <thead>
                        <tr>
                            <th style="background-color: #2c5aa0; color: white; border: 1px solid #1e3d6f; padding: 8px 4px; text-align: center; font-weight: bold; width: 5%;">#</th>
                            <th style="background-color: #2c5aa0; color: white; border: 1px solid #1e3d6f; padding: 8px 4px; text-align: left; font-weight: bold; width: 10%;">Código</th>
                            <th style="background-color: #2c5aa0; color: white; border: 1px solid #1e3d6f; padding: 8px 4px; text-align: left; font-weight: bold; width: 30%;">Producto</th>
                            <th style="background-color: #2c5aa0; color: white; border: 1px solid #1e3d6f; padding: 8px 4px; text-align: center; font-weight: bold; width: 12%;">Cantidad Vendida</th>
                            <th style="background-color: #2c5aa0; color: white; border: 1px solid #1e3d6f; padding: 8px 4px; text-align: left; font-weight: bold; width: 15%;">Fecha Última Venta</th>
                            <th style="background-color: #2c5aa0; color: white; border: 1px solid #1e3d6f; padding: 8px 4px; text-align: right; font-weight: bold; width: 18%;">Ingresos Generados</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${this.topProductos.map((producto, index) => {
                            const bgColor = index === 0 ? '#fff3e0' : 
                                          index === 1 ? '#f5f5f5' : 
                                          index === 2 ? '#fff8e1' : 
                                          '#ffffff';
                            return `
                                <tr style="background-color: ${bgColor};">
                                    <td style="border: 1px solid #ddd; padding: 6px 4px; text-align: center; font-weight: bold;">${index + 1}</td>
                                    <td style="border: 1px solid #ddd; padding: 6px 4px; font-family: monospace; font-weight: bold;">${producto.codigo}</td>
                                    <td style="border: 1px solid #ddd; padding: 6px 4px;">${producto.producto}</td>
                                    <td style="border: 1px solid #ddd; padding: 6px 4px; text-align: center; font-weight: bold;">${producto.cantidad_vendida}</td>
                                    <td style="border: 1px solid #ddd; padding: 6px 4px;">${this.formatoFecha(producto.fecha_ultima_venta)}</td>
                                    <td style="border: 1px solid #ddd; padding: 6px 4px; text-align: right; font-weight: bold;">${this.formatoMoneda(producto.ingresos_generados)}</td>
                                </tr>
                            `;
                        }).join('')}
                        <tr style="background-color: #2c5aa0; color: white; font-weight: bold;">
                            <td colspan="3" style="border: 1px solid #1e3d6f; padding: 8px 4px; text-align: right;">TOTALES GENERALES:</td>
                            <td style="border: 1px solid #1e3d6f; padding: 8px 4px; text-align: center;">${totalVendidos}</td>
                            <td style="border: 1px solid #1e3d6f; padding: 8px 4px;"></td>
                            <td style="border: 1px solid #1e3d6f; padding: 8px 4px; text-align: right;">${this.formatoMoneda(totalIngresos)}</td>
                        </tr>
                    </tbody>
                </table>
                
                <div style="margin-top: 30px; padding-top: 15px; border-top: 1px solid #ddd; font-size: 8px; color: #666; text-align: center;">
                    Documento generado automáticamente por el Sistema de Inversiones Aliaga | ${fechaActual}
                </div>
            `;

            return container;
        },

        formatoMoneda(monto) {
            if (!monto) return 'S/ 0.00';
            return new Intl.NumberFormat('es-PE', {
                style: 'currency',
                currency: 'PEN'
            }).format(monto);
        },

        formatoFecha(fecha) {
            if (!fecha) return 'N/A';
            
            try {
                console.log('📅 Procesando fecha:', fecha); // Para debug
                
                // Si ya es un objeto Date válido
                if (fecha instanceof Date && !isNaN(fecha.getTime())) {
                    return fecha.toLocaleDateString('es-PE', {
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                }
                
                // Si es string, intentar diferentes formatos
                if (typeof fecha === 'string') {
                    let date;
                    
                    // Formato ISO (YYYY-MM-DDTHH:MM:SS)
                    if (fecha.includes('T')) {
                        date = new Date(fecha);
                    }
                    // Formato con espacio (YYYY-MM-DD HH:MM:SS)
                    else if (fecha.includes(' ')) {
                        date = new Date(fecha.replace(' ', 'T'));
                    }
                    // Solo fecha (YYYY-MM-DD)
                    else {
                        date = new Date(fecha + 'T00:00:00');
                    }
                    
                    if (!isNaN(date.getTime())) {
                        return date.toLocaleDateString('es-PE', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                    }
                }
                
                // Si llegamos aquí, la fecha es inválida
                console.warn('❌ No se pudo parsear la fecha:', fecha);
                return 'Fecha inválida';
                
            } catch (error) {
                console.error('❌ Error formateando fecha:', fecha, error);
                return 'Error fecha';
            }
        }

    }
}
</script>

<style>
.animate-spin {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.table-auto {
    border-collapse: collapse;
    width: 100%;
}

.table-auto th,
.table-auto td {
    padding: 12px 16px;
    text-align: left;
    border-bottom: 1px solid #e5e7eb;
}

.table-auto th {
    background-color: #f9fafb;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.05em;
}
</style>