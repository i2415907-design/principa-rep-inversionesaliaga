<div class="min-h-screen bg-gray-100 p-6" x-data="dashboard()" x-init="init()">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Panel Administrativo - Inversiones Aliaga</h1>

    <!-- Loading State -->
    <div x-show="cargando" class="text-center py-8">
        <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
        <p class="mt-2 text-gray-600">Cargando dashboard...</p>
    </div>

    <!-- Contenido Principal -->
    <div x-show="!cargando">

        <!-- Tarjetas KPI principales -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-5 rounded-xl shadow text-center border-l-4 border-blue-500">
                <p class="text-sm text-gray-500">Ventas Hoy</p>
                <h2 class="text-2xl font-bold text-blue-600" x-text="formatoMoneda(estadisticas.ventas_hoy)">S/ 0.00</h2>
                <p class="text-xs text-gray-400 mt-1" x-text="estadisticas.cantidad_ventas_hoy + ' transacciones'"></p>
            </div>
            <div class="bg-white p-5 rounded-xl shadow text-center border-l-4 border-green-500">
                <p class="text-sm text-gray-500">Ingresos Mensuales</p>
                <h2 class="text-2xl font-bold text-green-600" x-text="formatoMoneda(estadisticas.ingresos_mes)">S/ 0.00</h2>
                <p class="text-xs text-gray-400 mt-1" x-text="estadisticas.ventas_mes + ' ventas este mes'"></p>
            </div>
            <div class="bg-white p-5 rounded-xl shadow text-center border-l-4 border-yellow-500">
                <p class="text-sm text-gray-500">Pedidos Pendientes</p>
                <h2 class="text-2xl font-bold text-yellow-600" x-text="estadisticas.pedidos_pendientes">0</h2>
                <p class="text-xs text-gray-400 mt-1" x-text="estadisticas.pedidos_enviados + ' en camino'"></p>
            </div>
            <div class="bg-white p-5 rounded-xl shadow text-center border-l-4 border-purple-500">
                <p class="text-sm text-gray-500">Clientes Registrados</p>
                <h2 class="text-2xl font-bold text-purple-600" x-text="estadisticas.total_clientes">0</h2>
                <p class="text-xs text-gray-400 mt-1" x-text="estadisticas.clientes_nuevos_mes + ' nuevos este mes'"></p>
            </div>
        </div>

        <!-- Segunda fila de métricas -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-5 rounded-xl shadow text-center">
                <p class="text-sm text-gray-500">Productos en Stock</p>
                <h2 class="text-2xl font-bold text-indigo-600" x-text="estadisticas.total_productos">0</h2>
                <p class="text-xs text-gray-400 mt-1" x-text="estadisticas.productos_bajo_stock + ' con stock bajo'"></p>
            </div>
            <div class="bg-white p-5 rounded-xl shadow text-center">
                <p class="text-sm text-gray-500">Pedidos Entregados</p>
                <h2 class="text-2xl font-bold text-teal-600" x-text="estadisticas.pedidos_entregados">0</h2>
                <p class="text-xs text-gray-400 mt-1" x-text="estadisticas.tasa_entrega + '% tasa de entrega'"></p>
            </div>
            <div class="bg-white p-5 rounded-xl shadow text-center">
                <p class="text-sm text-gray-500">Recaudación Total</p>
                <h2 class="text-2xl font-bold text-red-600" x-text="formatoMoneda(estadisticas.recaudacion_total)">S/ 0.00</h2>
                <p class="text-xs text-gray-400 mt-1">Histórico acumulado</p>
            </div>
        </div>

        <!-- ═══════════════════════════════════════════════
             FILA GRÁFICOS 1: Donut Pedidos + Barras Ventas
        ═══════════════════════════════════════════════ -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">

            <!-- Gráfico Donut: Distribución de Pedidos -->
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold mb-5 text-gray-800">📦 Distribución de Pedidos</h3>
                <div class="flex items-center gap-8">
                    <!-- SVG Donut -->
                    <div class="relative flex-shrink-0" style="width:160px; height:160px;">
                        <svg viewBox="0 0 160 160" width="160" height="160">
                            <!-- Track fondo -->
                            <circle cx="80" cy="80" r="60" fill="none" stroke="#f3f4f6" stroke-width="22"/>
                            <!-- Pendientes -->
                            <circle cx="80" cy="80" r="60" fill="none"
                                stroke="#F59E0B" stroke-width="22" stroke-linecap="butt"
                                :stroke-dasharray="donutDash(estadisticas.pedidos_pendientes, totalPedidos, 60)"
                                stroke-dashoffset="0"
                                transform="rotate(-90 80 80)"
                                style="transition: stroke-dasharray 0.9s cubic-bezier(.4,0,.2,1)"/>
                            <!-- Enviados -->
                            <circle cx="80" cy="80" r="60" fill="none"
                                stroke="#3B82F6" stroke-width="22" stroke-linecap="butt"
                                :stroke-dasharray="donutDash(estadisticas.pedidos_enviados, totalPedidos, 60)"
                                :stroke-dashoffset="donutOffset(estadisticas.pedidos_pendientes, totalPedidos, 60)"
                                transform="rotate(-90 80 80)"
                                style="transition: stroke-dasharray 0.9s cubic-bezier(.4,0,.2,1)"/>
                            <!-- Entregados -->
                            <circle cx="80" cy="80" r="60" fill="none"
                                stroke="#10B981" stroke-width="22" stroke-linecap="butt"
                                :stroke-dasharray="donutDash(estadisticas.pedidos_entregados, totalPedidos, 60)"
                                :stroke-dashoffset="donutOffset(estadisticas.pedidos_pendientes + estadisticas.pedidos_enviados, totalPedidos, 60)"
                                transform="rotate(-90 80 80)"
                                style="transition: stroke-dasharray 0.9s cubic-bezier(.4,0,.2,1)"/>
                            <!-- Texto central -->
                            <text x="80" y="74" text-anchor="middle" font-size="26" font-weight="700" fill="#1f2937" x-text="totalPedidos"></text>
                            <text x="80" y="90" text-anchor="middle" font-size="11" fill="#9ca3af">pedidos</text>
                        </svg>
                    </div>
                    <!-- Leyenda -->
                    <div class="flex-1 space-y-3">
                        <div class="flex items-center justify-between p-3 bg-orange-50 rounded-lg border border-amber-100">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-orange-400 flex-shrink-0"></span>
                                <span class="text-sm text-gray-600">Pendientes</span>
                            </div>
                            <div class="text-right">
                                <span class="text-sm font-bold text-amber-600" x-text="estadisticas.pedidos_pendientes"></span>
                                <span class="text-xs text-gray-400 ml-1" x-text="'(' + pct(estadisticas.pedidos_pendientes, totalPedidos).toFixed(0) + '%)'"></span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg border border-blue-100">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-blue-500 flex-shrink-0"></span>
                                <span class="text-sm text-gray-600">En camino</span>
                            </div>
                            <div class="text-right">
                                <span class="text-sm font-bold text-blue-600" x-text="estadisticas.pedidos_enviados"></span>
                                <span class="text-xs text-gray-400 ml-1" x-text="'(' + pct(estadisticas.pedidos_enviados, totalPedidos).toFixed(0) + '%)'"></span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg border border-emerald-100">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-green-500 flex-shrink-0"></span>
                                <span class="text-sm text-gray-600">Entregados</span>
                            </div>
                            <div class="text-right">
                                <span class="text-sm font-bold text-emerald-600" x-text="estadisticas.pedidos_entregados"></span>
                                <span class="text-xs text-gray-400 ml-1" x-text="'(' + pct(estadisticas.pedidos_entregados, totalPedidos).toFixed(0) + '%)'"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gráfico Barras: Comparativa de Ventas -->
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold mb-5 text-gray-800">📊 Comparativa de Ventas</h3>
                <!-- Barras horizontales mejoradas con % visual -->
                <div class="space-y-5">
                    <div>
                        <div class="flex justify-between items-center mb-1.5">
                            <span class="text-sm text-gray-600 font-medium">Ventas Hoy</span>
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-gray-400" x-text="pct(estadisticas.ventas_hoy, estadisticas.recaudacion_total).toFixed(1) + '%'"></span>
                                <span class="text-sm font-bold text-blue-600" x-text="formatoMoneda(estadisticas.ventas_hoy)"></span>
                            </div>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
                            <div class="h-3 rounded-full bg-blue-500 transition-all duration-1000"
                                 :style="'width:' + pct(estadisticas.ventas_hoy, estadisticas.recaudacion_total) + '%'"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between items-center mb-1.5">
                            <span class="text-sm text-gray-600 font-medium">Ventas del Mes</span>
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-gray-400" x-text="pct(estadisticas.ingresos_mes, estadisticas.recaudacion_total).toFixed(1) + '%'"></span>
                                <span class="text-sm font-bold text-green-600" x-text="formatoMoneda(estadisticas.ingresos_mes)"></span>
                            </div>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
                            <div class="h-3 rounded-full bg-green-500 transition-all duration-1000"
                                 :style="'width:' + pct(estadisticas.ingresos_mes, estadisticas.recaudacion_total) + '%'"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between items-center mb-1.5">
                            <span class="text-sm text-gray-600 font-medium">Recaudación Total</span>
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-gray-400">100%</span>
                                <span class="text-sm font-bold text-purple-600" x-text="formatoMoneda(estadisticas.recaudacion_total)"></span>
                            </div>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
                            <div class="h-3 rounded-full bg-purple-500 transition-all duration-1000" style="width:100%"></div>
                        </div>
                    </div>
                </div>

                <!-- Mini stats debajo -->
                <div class="grid grid-cols-2 gap-3 mt-6">
                    <div class="bg-blue-50 rounded-lg p-3 text-center border border-blue-100">
                        <p class="text-xs text-blue-500 mb-0.5">Transacciones hoy</p>
                        <p class="text-xl font-bold text-blue-700" x-text="estadisticas.cantidad_ventas_hoy"></p>
                    </div>
                    <div class="bg-green-50 rounded-lg p-3 text-center border border-green-100">
                        <p class="text-xs text-green-500 mb-0.5">Ventas este mes</p>
                        <p class="text-xl font-bold text-green-700" x-text="estadisticas.ventas_mes"></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ═══════════════════════════════════════════════
             FILA GRÁFICOS 2: Stock + Clientes + Tasa entrega
        ═══════════════════════════════════════════════ -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">

            <!-- Donut: Salud del Stock -->
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-800">🗃️ Salud del Stock</h3>
                <div class="flex flex-col items-center">
                    <div class="relative" style="width:140px; height:140px;">
                        <svg viewBox="0 0 140 140" width="140" height="140">
                            <circle cx="70" cy="70" r="52" fill="none" stroke="#f3f4f6" stroke-width="20"/>
                            <!-- Saludable -->
                            <circle cx="70" cy="70" r="52" fill="none"
                                stroke="#10B981" stroke-width="20" stroke-linecap="butt"
                                :stroke-dasharray="donutDash(estadisticas.total_productos - estadisticas.productos_bajo_stock, estadisticas.total_productos, 52)"
                                stroke-dashoffset="0"
                                transform="rotate(-90 70 70)"
                                style="transition: stroke-dasharray 0.9s cubic-bezier(.4,0,.2,1)"/>
                            <!-- Bajo stock -->
                            <circle cx="70" cy="70" r="52" fill="none"
                                stroke="#EF4444" stroke-width="20" stroke-linecap="butt"
                                :stroke-dasharray="donutDash(estadisticas.productos_bajo_stock, estadisticas.total_productos, 52)"
                                :stroke-dashoffset="donutOffset(estadisticas.total_productos - estadisticas.productos_bajo_stock, estadisticas.total_productos, 52)"
                                transform="rotate(-90 70 70)"
                                style="transition: stroke-dasharray 0.9s cubic-bezier(.4,0,.2,1)"/>
                            <text x="70" y="65" text-anchor="middle" font-size="22" font-weight="700" fill="#1f2937" x-text="estadisticas.total_productos"></text>
                            <text x="70" y="80" text-anchor="middle" font-size="10" fill="#9ca3af">productos</text>
                        </svg>
                    </div>
                    <div class="w-full mt-4 space-y-2">
                        <div class="flex items-center justify-between text-sm px-1">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                                <span class="text-gray-600">Saludable</span>
                            </div>
                            <span class="font-semibold text-emerald-600" x-text="estadisticas.total_productos - estadisticas.productos_bajo_stock"></span>
                        </div>
                        <div class="flex items-center justify-between text-sm px-1">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>
                                <span class="text-gray-600">Stock bajo</span>
                            </div>
                            <span class="font-semibold text-red-500" x-text="estadisticas.productos_bajo_stock"></span>
                        </div>
                    </div>
                    <div class="mt-4 w-full p-2.5 bg-red-50 rounded-lg border border-red-100 text-center"
                         x-show="estadisticas.productos_bajo_stock > 0">
                        <p class="text-xs text-red-600 font-medium">
                            ⚠️ <span x-text="estadisticas.productos_bajo_stock"></span> productos requieren atención
                        </p>
                    </div>
                </div>
            </div>

            <!-- Gráfico Gauge SVG: Tasa de Entrega -->
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-800">🎯 Tasa de Entrega</h3>
                <div class="flex flex-col items-center">
                    <!-- Gauge semicírculo -->
                    <div class="relative" style="width:180px; height:100px; overflow:hidden;">
                        <svg viewBox="0 0 200 110" width="180" height="100">
                            <!-- Track fondo (semicírculo) -->
                            <path d="M 20 100 A 80 80 0 0 1 180 100"
                                fill="none" stroke="#f3f4f6" stroke-width="18" stroke-linecap="round"/>
                            <!-- Fill animado según tasa_entrega -->
                            <path d="M 20 100 A 80 80 0 0 1 180 100"
                                fill="none" stroke="#10B981" stroke-width="18" stroke-linecap="round"
                                :stroke-dasharray="gaugeEntrega(estadisticas.tasa_entrega)"
                                style="transition: stroke-dasharray 1.2s cubic-bezier(.4,0,.2,1)"/>
                            <!-- Valor central -->
                            <text x="100" y="90" text-anchor="middle" font-size="28" font-weight="800" fill="#1f2937"
                                x-text="estadisticas.tasa_entrega + '%'"></text>
                        </svg>
                    </div>
                    <p class="text-sm text-gray-500 -mt-1 mb-4">de los pedidos entregados</p>
                    <div class="w-full grid grid-cols-2 gap-3">
                        <div class="bg-teal-50 rounded-lg p-3 text-center border border-teal-100">
                            <p class="text-xs text-teal-500 mb-0.5">Entregados</p>
                            <p class="text-xl font-bold text-teal-700" x-text="estadisticas.pedidos_entregados"></p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-3 text-center border border-gray-200">
                            <p class="text-xs text-gray-500 mb-0.5">Total pedidos</p>
                            <p class="text-xl font-bold text-gray-700" x-text="totalPedidos"></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gráfico: Clientes nuevos vs total -->
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-800">👥 Clientes</h3>
                <div class="flex flex-col items-center">
                    <!-- Ring gauge clientes -->
                    <div class="relative" style="width:140px; height:140px;">
                        <svg viewBox="0 0 140 140" width="140" height="140">
                            <circle cx="70" cy="70" r="52" fill="none" stroke="#f3f4f6" stroke-width="20"/>
                            <circle cx="70" cy="70" r="52" fill="none"
                                stroke="#8B5CF6" stroke-width="20" stroke-linecap="butt"
                                :stroke-dasharray="donutDash(estadisticas.clientes_nuevos_mes, estadisticas.total_clientes, 52)"
                                stroke-dashoffset="0"
                                transform="rotate(-90 70 70)"
                                style="transition: stroke-dasharray 1s cubic-bezier(.4,0,.2,1)"/>
                            <!-- Resto (clientes existentes) -->
                            <circle cx="70" cy="70" r="52" fill="none"
                                stroke="#e9d5ff" stroke-width="20" stroke-linecap="butt"
                                :stroke-dasharray="donutDash(estadisticas.total_clientes - estadisticas.clientes_nuevos_mes, estadisticas.total_clientes, 52)"
                                :stroke-dashoffset="donutOffset(estadisticas.clientes_nuevos_mes, estadisticas.total_clientes, 52)"
                                transform="rotate(-90 70 70)"
                                style="transition: stroke-dasharray 1s cubic-bezier(.4,0,.2,1)"/>
                            <text x="70" y="64" text-anchor="middle" font-size="20" font-weight="700" fill="#7c3aed" x-text="estadisticas.clientes_nuevos_mes"></text>
                            <text x="70" y="78" text-anchor="middle" font-size="9.5" fill="#9ca3af">nuevos / mes</text>
                        </svg>
                    </div>
                    <div class="w-full mt-3 space-y-2">
                        <div class="flex items-center justify-between text-sm px-1">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span>
                                <span class="text-gray-600">Nuevos este mes</span>
                            </div>
                            <span class="font-semibold text-purple-600" x-text="estadisticas.clientes_nuevos_mes"></span>
                        </div>
                        <div class="flex items-center justify-between text-sm px-1">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-purple-200"></span>
                                <span class="text-gray-600">Existentes</span>
                            </div>
                            <span class="font-semibold text-gray-600" x-text="estadisticas.total_clientes - estadisticas.clientes_nuevos_mes"></span>
                        </div>
                    </div>
                    <div class="mt-3 w-full bg-purple-50 rounded-lg p-2.5 text-center border border-purple-100">
                        <p class="text-xs text-purple-600">
                            Crecimiento:
                            <strong x-text="((estadisticas.clientes_nuevos_mes / Math.max(estadisticas.total_clientes, 1)) * 100).toFixed(1) + '%'"></strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ═══════════════════════════════════════════════
             FILA 3: Resumen ventas + Stock bajo (carrusel)
        ═══════════════════════════════════════════════ -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">

            <!-- Resumen de Ventas -->
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-800 flex items-center justify-between">
                    <span>💰 Resumen de Ventas</span>
                    <span class="text-sm font-normal text-gray-500" x-text="'Total Mes: ' + formatoMoneda(estadisticas.ingresos_mes)"></span>
                </h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center p-3 bg-blue-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-blue-600 font-bold">📅</span>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">Ventas de Hoy</div>
                                <div class="text-sm text-gray-500" x-text="estadisticas.cantidad_ventas_hoy + ' transacciones'"></div>
                            </div>
                        </div>
                        <div class="font-bold text-blue-600" x-text="formatoMoneda(estadisticas.ventas_hoy)"></div>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-green-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <span class="text-green-600 font-bold">💰</span>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">Ventas del Mes</div>
                                <div class="text-sm text-gray-500" x-text="estadisticas.ventas_mes + ' ventas totales'"></div>
                            </div>
                        </div>
                        <div class="font-bold text-green-600" x-text="formatoMoneda(estadisticas.ingresos_mes)"></div>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-purple-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                <span class="text-purple-600 font-bold">🏆</span>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">Recaudación Total</div>
                                <div class="text-sm text-gray-500">Acumulado histórico</div>
                            </div>
                        </div>
                        <div class="font-bold text-purple-600" x-text="formatoMoneda(estadisticas.recaudacion_total)"></div>
                    </div>
                </div>
            </div>

            <!-- Productos con Stock Bajo (carrusel original) -->
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-800 flex items-center justify-between">
                    <span>⚠️ Productos con Stock Bajo</span>
                    <span class="text-sm font-normal text-red-500" x-text="productosStockBajo.length + ' productos'"></span>
                </h3>
                <div class="flex justify-center mb-4" x-show="productosStockBajo.length > 0">
                    <span class="text-sm text-gray-500"
                          x-text="'Producto ' + (indiceCarrusel + 1) + ' de ' + productosStockBajo.length"></span>
                </div>
                <div class="relative h-48 bg-red-50 rounded-lg border-2 border-red-200 p-6">
                    <template x-for="(producto, index) in productosStockBajo" :key="index">
                        <div class="absolute inset-0 p-6 transition-opacity duration-500 ease-in-out"
                             :class="{ 'opacity-100': index === indiceCarrusel, 'opacity-0': index !== indiceCarrusel }">
                            <div class="text-center h-full flex flex-col justify-center">
                                <div class="mb-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold"
                                          :class="{
                                              'bg-red-100 text-red-800': producto.stock <= 2,
                                              'bg-orange-100 text-orange-800': producto.stock > 2 && producto.stock <= 5
                                          }">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        <span x-text="producto.stock <= 2 ? 'STOCK CRÍTICO' : 'STOCK BAJO'"></span>
                                    </span>
                                </div>
                                <h4 class="text-xl font-bold text-gray-800 mb-2" x-text="producto.nombre"></h4>
                                <div class="space-y-2 text-sm text-gray-600">
                                    <div class="flex justify-center items-center space-x-4">
                                        <span class="font-semibold">Código:</span>
                                        <span class="font-mono bg-gray-100 px-2 py-1 rounded" x-text="producto.codigo"></span>
                                    </div>
                                    <div class="flex justify-center items-center space-x-4">
                                        <span class="font-semibold">Stock Actual:</span>
                                        <span class="text-lg font-bold"
                                              :class="{ 'text-red-600': producto.stock <= 2, 'text-orange-600': producto.stock > 2 && producto.stock <= 5 }"
                                              x-text="producto.stock + ' unidades'"></span>
                                    </div>
                                    <div class="flex justify-center items-center space-x-4">
                                        <span class="font-semibold">Precio:</span>
                                        <span class="text-green-600 font-bold" x-text="formatoMoneda(producto.precio)"></span>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="h-2 rounded-full transition-all duration-500"
                                             :class="{ 'bg-red-500': producto.stock <= 2, 'bg-orange-400': producto.stock > 2 && producto.stock <= 5 }"
                                             :style="`width: ${Math.min((producto.stock / 10) * 100, 100)}%`"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                    <div x-show="productosStockBajo.length === 0"
                         class="h-full flex items-center justify-center text-gray-500">
                        <div class="text-center">
                            <svg class="w-12 h-12 text-green-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="font-semibold">¡Excelente!</p>
                            <p class="text-sm">No hay productos con stock bajo</p>
                        </div>
                    </div>
                    <div x-show="productosStockBajo.length > 1" class="absolute bottom-4 left-0 right-0 flex justify-center space-x-2">
                        <button @click="productoAnterior()" class="p-2 bg-white rounded-full shadow hover:bg-gray-100 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>
                        <button @click="productoSiguiente()" class="p-2 bg-white rounded-full shadow hover:bg-gray-100 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <div x-show="productosStockBajo.length > 1" class="flex justify-center mt-4 space-x-2">
                    <template x-for="(_, index) in productosStockBajo" :key="index">
                        <button @click="indiceCarrusel = index"
                                class="w-2 h-2 rounded-full transition"
                                :class="{ 'bg-red-500': index === indiceCarrusel, 'bg-gray-300': index !== indiceCarrusel }"></button>
                    </template>
                </div>
            </div>
        </div>

        <!-- ═══════════════════════════════════════════════
             FILA FINAL: Pedidos Recientes + Top Productos
             con nuevo gráfico de barras verticales SVG
        ═══════════════════════════════════════════════ -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            <!-- Pedidos Recientes -->
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-800">🚚 Pedidos Recientes</h3>
                <div class="space-y-3">
                    <template x-for="(pedido, index) in pedidosRecientes" :key="index">
                        <div class="flex items-center justify-between p-3 border rounded-lg hover:bg-gray-50 transition">
                            <div>
                                <div class="font-medium text-gray-800" x-text="'Pedido #' + pedido.codigo"></div>
                                <div class="text-sm text-gray-500" x-text="pedido.cliente"></div>
                            </div>
                            <div class="text-right">
                                <span class="px-2 py-1 rounded-full text-xs font-medium"
                                      :class="{
                                          'bg-yellow-100 text-yellow-800': pedido.estado === 'pendiente',
                                          'bg-blue-100 text-blue-800': pedido.estado === 'enviado',
                                          'bg-green-100 text-green-800': pedido.estado === 'entregado'
                                      }"
                                      x-text="pedido.estado"></span>
                                <div class="text-sm font-bold text-gray-700 mt-1" x-text="formatoMoneda(pedido.total)"></div>
                            </div>
                        </div>
                    </template>
                    <div x-show="pedidosRecientes.length === 0" class="text-center text-gray-500 py-4">
                        No hay pedidos recientes
                    </div>
                </div>
            </div>

            <!-- Top Productos con barras verticales SVG -->
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold mb-1 text-gray-800">🔥 Productos Más Vendidos</h3>
                <p class="text-xs text-gray-400 mb-5">Unidades vendidas por producto</p>

                <!-- Barras verticales SVG -->
                <div x-show="topProductos.length > 0" class="mb-5">
                    <div class="flex items-end gap-2 h-28 px-1">
                        <template x-for="(p, i) in topProductos.slice(0,5)" :key="i">
                            <div class="flex flex-col items-center flex-1 h-full justify-end gap-1">
                                <!-- Valor encima -->
                                <span class="text-xs font-semibold text-gray-600" x-text="p.cantidad_vendida"></span>
                                <!-- Barra -->
                                <div class="w-full rounded-t-md transition-all duration-1000"
                                     :style="'height:' + pct(p.cantidad_vendida, topProductos[0].cantidad_vendida) + '%; background:' + ['#3B82F6','#8B5CF6','#10B981','#F59E0B','#EF4444'][i]"
                                     style="min-height:4px; max-height:80px"></div>
                            </div>
                        </template>
                    </div>
                    <!-- Labels debajo -->
                    <div class="flex gap-2 px-1 mt-2">
                        <template x-for="(p, i) in topProductos.slice(0,5)" :key="i">
                            <div class="flex-1 text-center">
                                <p class="text-xs text-gray-400 truncate" x-text="p.nombre.split(' ')[0]"></p>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Lista detallada debajo -->
                <div class="space-y-2">
                    <template x-for="(producto, index) in topProductos" :key="index">
                        <div class="flex items-center justify-between p-2.5 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <span class="flex items-center justify-center w-6 h-6 rounded-full text-xs font-bold text-white"
                                      :style="'background:' + ['#3B82F6','#8B5CF6','#10B981','#F59E0B','#EF4444'][index] || '#9ca3af'"
                                      x-text="index + 1"></span>
                                <div>
                                    <div class="font-medium text-gray-800 text-sm" x-text="producto.nombre"></div>
                                    <div class="text-xs text-gray-400" x-text="'Cód: ' + producto.codigo"></div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-bold text-sm text-green-600" x-text="producto.cantidad_vendida + ' und'"></div>
                                <div class="text-xs text-gray-500" x-text="formatoMoneda(producto.ingresos)"></div>
                            </div>
                        </div>
                    </template>
                    <div x-show="topProductos.length === 0" class="text-center text-gray-500 py-4">
                        No hay datos de ventas
                    </div>
                </div>
            </div>
        </div>

    </div><!-- /contenido -->
</div>

<script>
function dashboard() {
    return {
        cargando: true,
        estadisticas: {
            ventas_hoy: 0, cantidad_ventas_hoy: 0,
            ingresos_mes: 0, ventas_mes: 0,
            pedidos_pendientes: 0, pedidos_enviados: 0, pedidos_entregados: 0,
            total_clientes: 0, clientes_nuevos_mes: 0,
            total_productos: 0, productos_bajo_stock: 0,
            tasa_entrega: 0, recaudacion_total: 0
        },
        topProductos: [],
        pedidosRecientes: [],
        productosStockBajo: [],
        indiceCarrusel: 0,
        intervalo: null,

        get totalPedidos() {
            return this.estadisticas.pedidos_pendientes +
                   this.estadisticas.pedidos_enviados +
                   this.estadisticas.pedidos_entregados;
        },

        async init() {
            try {
                await Promise.all([
                    this.cargarEstadisticas(),
                    this.cargarTopProductos(),
                    this.cargarPedidosRecientes(),
                    this.cargarProductosStockBajo()
                ]);
            } catch (error) {
                console.error('Error cargando dashboard:', error);
            } finally {
                this.cargando = false;
                this.iniciarCarrusel();
            }
        },

        async cargarEstadisticas() {
            try {
                const r = await fetch('/api/dashboard/estadisticas');
                if (!r.ok) throw new Error(`HTTP ${r.status}`);
                const d = await r.json();
                if (d.success) this.estadisticas = d.estadisticas;
            } catch (e) { console.error('estadísticas:', e); }
        },

        async cargarTopProductos() {
            try {
                const r = await fetch('/api/reportes/top-productos');
                if (!r.ok) throw new Error(`HTTP ${r.status}`);
                const d = await r.json();
                this.topProductos = d.success ? d.top_productos.slice(0, 5) : [];
            } catch (e) { this.topProductos = []; }
        },

        async cargarPedidosRecientes() {
            try {
                const r = await fetch('/api/dashboard/pedidos-recientes');
                if (!r.ok) throw new Error(`HTTP ${r.status}`);
                const d = await r.json();
                this.pedidosRecientes = d.success ? d.pedidos : [];
            } catch (e) { this.pedidosRecientes = []; }
        },

        async cargarProductosStockBajo() {
            try {
                const r = await fetch('/api/dashboard/stock-bajo');
                if (!r.ok) throw new Error(`HTTP ${r.status}`);
                const d = await r.json();
                this.productosStockBajo = d.success ? d.productos : [];
            } catch (e) { this.productosStockBajo = []; }
        },

        iniciarCarrusel() {
            if (this.productosStockBajo.length > 1)
                this.intervalo = setInterval(() => this.productoSiguiente(), 5000);
        },
        productoSiguiente() {
            if (this.productosStockBajo.length > 0)
                this.indiceCarrusel = (this.indiceCarrusel + 1) % this.productosStockBajo.length;
        },
        productoAnterior() {
            if (this.productosStockBajo.length > 0)
                this.indiceCarrusel = (this.indiceCarrusel - 1 + this.productosStockBajo.length) % this.productosStockBajo.length;
        },

        /* ── Helpers SVG ── */
        pct(val, total) {
            if (!total || total === 0) return 0;
            return Math.min((val / total) * 100, 100);
        },
        donutDash(valor, total, r) {
            const circ = 2 * Math.PI * r;
            if (!total || total === 0) return `0 ${circ}`;
            return `${(valor / total) * circ} ${circ}`;
        },
        donutOffset(valorPrevio, total, r) {
            const circ = 2 * Math.PI * r;
            if (!total || total === 0) return 0;
            return -((valorPrevio / total) * circ);
        },
        // Gauge semicírculo: path total ≈ 251 (semicírculo r=80, longitud π*80≈251)
        gaugeEntrega(tasa) {
            const total = Math.PI * 80; // longitud del arco semicircular
            const filled = (tasa / 100) * total;
            return `${filled} ${total + 20}`; // +20 para que el resto no se vea
        },

        formatoMoneda(monto) {
            if (!monto && monto !== 0) return 'S/ 0.00';
            return new Intl.NumberFormat('es-PE', { style: 'currency', currency: 'PEN' }).format(monto);
        }
    }
}
</script>