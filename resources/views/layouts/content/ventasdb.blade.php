<!-- Contenedor general -->
<div class="space-y-6">

  <!-- Mensajes -->
  @if(session('success'))
    <div class="bg-green-100 text-green-700 p-3 rounded">
      {{ session('success') }}
    </div>
  @elseif(session('error'))
    <div class="bg-red-100 text-red-700 p-3 rounded">
      {{ session('error') }}
    </div>
  @endif

  <!-- Formulario de Ventas Mejorado -->
  <div class="bg-white shadow rounded-lg p-6">
    <form action="{{ route('ventas.store') }}" method="POST" id="form-venta">
      @csrf
      <h3 class="text-gray-800 font-semibold text-lg mb-4">Registrar Nueva Venta</h3>
      
      <!-- Información del Cliente con Formulario Tradicional -->
      <div class="mb-6 p-4 bg-white shadow rounded-lg">
        <h4 class="font-semibold text-blue-800 mb-3">Información del Cliente</h4>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">DNI *</label>
            <input type="text" name="doc_ident" id="doc_ident" maxlength="8" 
                   class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" 
                   placeholder="12345678" required
                   oninput="validarDNI(this)"
                   pattern="[0-9]{8}">
            <small class="text-gray-500" id="dni-mensaje">8 dígitos numéricos</small>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Nombre *</label>
            <input type="text" name="nombre_cliente" id="nombre_cliente" 
                   class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" 
                   placeholder="Juan" required
                   oninput="validarNombre(this)">
            <small class="text-gray-500" id="nombre-mensaje">Solo letras y espacios</small>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Apellido *</label>
            <input type="text" name="apellido_cliente" id="apellido_cliente" 
                   class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" 
                   placeholder="Pérez" required
                   oninput="validarApellido(this)">
            <small class="text-gray-500" id="apellido-mensaje">Solo letras y espacios</small>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email_cliente" id="email_cliente" 
                   class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" 
                   placeholder="cliente@ejemplo.com (opcional)"
                   oninput="validarEmail(this)">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Teléfono</label>
            <input type="text" name="telefono_cliente" id="telefono_cliente" maxlength="9" 
                   class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" 
                   placeholder="987654321"
                   oninput="validarTelefono(this)">
            <small class="text-gray-500" id="telefono-mensaje">9 dígitos numéricos</small>
          </div>
        </div>
      </div>

      <!-- Productos -->
      <div class="mb-6 p-4 bg-white shadow rounded-lg">
        <h4 class="font-semibold text-yellow-800 mb-3">Productos</h4>
        
        <!-- Buscador de Productos Dinámico -->
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-2">Buscar Producto</label>
          <div class="relative">
            <input type="text" id="buscador-producto" 
                   class="w-full border border-gray-300 rounded-md px-3 py-2 pr-10" 
                   placeholder="Escribe para buscar productos..."
                   oninput="buscarProductosDinamico()">
            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
              <span class="text-gray-400">🔍</span>
            </div>
          </div>
          <div id="resultados-busqueda" class="mt-2 hidden max-h-48 overflow-y-auto border border-gray-200 rounded-md bg-white shadow-lg">
            <!-- Resultados de búsqueda aparecerán aquí -->
          </div>
        </div>
        
        <div id="productos-container">
          <!-- Productos seleccionados aparecerán aquí -->
        </div>

        <button type="button" onclick="agregarProducto()" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 mt-4">
          + Agregar Producto
        </button>

        <div class="mt-4 p-3 bg-gray-100 rounded">
          <strong class="text-lg">Total: S/ <span id="total-venta">0.00</span></strong>
        </div>
      </div>

      <div class="flex justify-end space-x-3">
        <button type="reset" onclick="limpiarFormulario()" class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600">
           Limpiar Todo
        </button>
        <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded-md hover:bg-green-600">
          Registrar Venta
        </button>
      </div>
    </form>
  </div>

  <!-- Tabla con Scroll Horizontal y Vertical Mejorada -->
  <div class="bg-white shadow rounded-lg border border-gray-200">
    <div class="overflow-auto max-h-96 relative">
        <div class="min-w-max">
            <table class="w-full table-auto text-sm">
                <thead class="bg-gray-50 text-gray-700 uppercase sticky top-0">
                    <tr>
                        <th class="px-4 py-3 sticky left-0 bg-gray-50 z-20 border-r border-gray-200 font-semibold text-xs">N°</th>
                        <th class="px-4 py-3 font-semibold text-xs min-w-[120px]">Fecha</th>
                        <th class="px-4 py-3 font-semibold text-xs min-w-[200px]">Producto</th>
                        <th class="px-4 py-3 font-semibold text-xs min-w-[100px]">ID Producto</th>
                        <th class="px-4 py-3 font-semibold text-xs min-w-[150px]">Cliente</th>
                        <th class="px-4 py-3 font-semibold text-xs min-w-[100px]">DNI</th>
                        <th class="px-4 py-3 font-semibold text-xs min-w-[150px]">Email</th>
                        <th class="px-4 py-3 font-semibold text-xs min-w-[100px]">Precio</th>
                        <th class="px-4 py-3 font-semibold text-xs min-w-[80px]">Cantidad</th>
                        <th class="px-4 py-3 font-semibold text-xs min-w-[100px]">Subtotal</th>
                        <th class="px-4 py-3 font-semibold text-xs min-w-[100px]">Stock</th>
                        <th class="px-4 py-3 sticky right-0 bg-gray-50 z-20 border-l border-gray-200 font-semibold text-xs min-w-[100px]">Boleta</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 divide-y divide-gray-100">
                    @forelse($ventas as $venta)
                        @foreach($venta->detalles as $detalle)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-center sticky left-0 bg-white z-10 border-r border-gray-100 text-xs font-medium">
                                    {{ $loop->parent->iteration }}.{{ $loop->iteration }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-xs">{{ \Carbon\Carbon::parse($venta->fecha_venta)->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-3 text-xs max-w-[200px] truncate" title="{{ $detalle->producto->nombre_producto ?? 'Sin nombre' }}">
                                    {{ $detalle->producto->nombre_producto ?? 'Sin nombre' }}
                                </td>
                                <td class="px-4 py-3 text-center text-xs font-mono">#{{ $detalle->id_producto }}</td>
                                <td class="px-4 py-3 text-xs">{{ ($venta->cliente->nombre_cliente ?? '') . ' ' . ($venta->cliente->apellido_cliente ?? '') }}</td>
                                <td class="px-4 py-3 text-center text-xs font-mono">{{ $venta->cliente->doc_ident ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-xs max-w-[150px] truncate" title="{{ $venta->cliente->email_cliente ?? 'No tiene' }}">
                                    {{ $venta->cliente->email_cliente ?? 'No tiene' }}
                                </td>
                                <td class="px-4 py-3 text-right text-xs font-semibold">S/{{ number_format($detalle->precio_unitario, 2) }}</td>
                                <td class="px-4 py-3 text-center text-xs font-semibold">{{ $detalle->cantidad }}</td>
                                <td class="px-4 py-3 text-right text-xs font-semibold text-green-600">S/{{ number_format($detalle->subtotal, 2) }}</td>
                                <td class="px-4 py-3 text-center text-xs">
                                    @php
                                        $stock = $detalle->producto->stock_producto ?? 0;
                                        $colorClass = ($stock > 10) ? 'bg-green-100 text-green-800' : 
                                                     (($stock > 5) ? 'bg-yellow-100 text-yellow-800' : 
                                                     'bg-red-100 text-red-800');
                                    @endphp
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $colorClass }}">
                                        {{ $stock ?: '-' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center sticky right-0 bg-white z-10 border-l border-gray-100">
                                    <button onclick="descargarBoleta({{ $venta->id_venta }}, event)" 
                                            class="bg-red-600 text-white px-3 py-1 rounded text-xs hover:bg-red-700 transition-colors flex items-center gap-1 whitespace-nowrap shadow-sm">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Boleta
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="12" class="text-center py-8 text-gray-500 text-sm">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    No hay ventas registradas
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
  </div>

  <!-- Tarjetas para móvil -->
  <div class="sm:hidden space-y-4">
    @forelse($ventas as $venta)
      @foreach($venta->detalles as $detalle)
        <div class="bg-white rounded-lg shadow p-4">
          <h3 class="font-bold text-lg mb-2">{{ $detalle->producto->nombre_producto ?? 'Sin nombre' }}</h3>
          <p class="text-sm text-gray-700"><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($venta->fecha_venta)->format('d/m/Y H:i') }}</p>
          <p class="text-sm text-gray-700"><strong>ID Producto:</strong> {{ $detalle->id_producto }}</p>
          <p class="text-sm text-gray-700"><strong>Cliente:</strong> 
            {{ ($venta->cliente->nombre_cliente ?? '') . ' ' . ($venta->cliente->apellido_cliente ?? '') }}
          </p>
          <p class="text-sm text-gray-700"><strong>DNI:</strong> {{ $venta->cliente->doc_ident ?? 'N/A' }}</p>
          <p class="text-sm text-gray-700"><strong>Email:</strong> {{ $venta->cliente->email_cliente ?? 'No tiene' }}</p>
          <p class="text-sm text-gray-700"><strong>Precio:</strong> S/{{ number_format($detalle->precio_unitario, 2) }}</p>
          <p class="text-sm text-gray-700"><strong>Cantidad:</strong> {{ $detalle->cantidad }}</p>
          <p class="text-sm text-gray-700"><strong>Subtotal:</strong> S/{{ number_format($detalle->subtotal, 2) }}</p>
          <p class="text-sm text-gray-700"><strong>Stock Actual:</strong> {{ $detalle->producto->stock_producto ?? '-' }}</p>
          <!-- 🔥 NUEVO BOTÓN BOLETA PARA MÓVIL -->
          <div class="mt-3">
              <button onclick="descargarBoleta({{ $venta->id_venta }}, event)" 
                      class="w-full bg-red-600 text-white px-3 py-2 rounded text-sm hover:bg-red-700 transition-colors flex items-center justify-center gap-1">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                  </svg>
                  Descargar Boleta
              </button>
          </div>
        </div>
      @endforeach
    @empty
      <p class="text-center text-gray-500">No hay ventas registradas</p>
    @endforelse
  </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
let productoCount = 0;
let productosSeleccionados = new Set();
let timeoutBusqueda = null;

// 🔥 FUNCIÓN PARA DESCARGAR BOLETA - CON GENERACIÓN EN FRONTEND
async function descargarBoleta(idVenta, event) {
    let boton = null;
    let textoOriginal = '';
    
    try {
        console.log('📄 Generando boleta para venta:', idVenta);
        
        // Obtener el botón de forma segura
        boton = event?.target || document.querySelector(`button[onclick*="${idVenta}"]`);
        
        if (boton) {
            textoOriginal = boton.innerHTML;
            boton.innerHTML = '<div class="inline-block animate-spin rounded-full h-4 w-4 border-b-2 border-white"></div> Generando...';
            boton.disabled = true;
        }

        // Obtener datos de la venta
        const response = await fetch(`/ventas/${idVenta}/datos-boleta`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        });
        
        if (!response.ok) {
            throw new Error(`Error al obtener datos de la venta: ${response.status}`);
        }

        const data = await response.json();
        
        if (!data.success) {
            throw new Error(data.error || 'Error en los datos de la venta');
        }

        console.log('📦 Datos de venta obtenidos:', data);

        // Crear y generar el PDF
        await generarPDFBoleta(data.venta);
        
        console.log('✅ Boleta generada exitosamente');

    } catch (error) {
        console.error('❌ Error al generar boleta:', error);
        alert('Error al generar la boleta: ' + error.message);
    } finally {
        // Restaurar botón de forma segura
        if (boton && textoOriginal) {
            boton.innerHTML = textoOriginal;
            boton.disabled = false;
        }
    }
}

// 🔥 FUNCIÓN PARA GENERAR EL PDF DE LA BOLETA
async function generarPDFBoleta(venta) {
    return new Promise((resolve, reject) => {
        try {
            // Crear el contenido HTML de la boleta
            const boletaHTML = crearHTMLBoleta(venta);
            
            // Crear elemento temporal para renderizar
            const tempDiv = document.createElement('div');
            tempDiv.style.cssText = `
                position: fixed;
                left: -10000px;
                top: -10000px;
                width: 700px;
                padding: 20px;
                background: white;
                font-family: Arial, sans-serif;
            `;
            tempDiv.innerHTML = boletaHTML;
            document.body.appendChild(tempDiv);

            // Generar PDF con html2canvas y jsPDF
            html2canvas(tempDiv, {
                scale: 2,
                useCORS: true,
                logging: false
            }).then(canvas => {
                const pdf = new jspdf.jsPDF('p', 'mm', 'a4');
                const imgData = canvas.toDataURL('image/png');
                
                const pdfWidth = pdf.internal.pageSize.getWidth();
                const pdfHeight = (canvas.height * pdfWidth) / canvas.width;

                pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
                pdf.save(`boleta_venta_${venta.id_venta}.pdf`);

                // Limpiar
                document.body.removeChild(tempDiv);
                resolve();
            }).catch(error => {
                document.body.removeChild(tempDiv);
                reject(error);
            });

        } catch (error) {
            reject(error);
        }
    });
}

// 🔥 FUNCIÓN PARA CREAR EL HTML DE LA BOLETA
function crearHTMLBoleta(venta) {
    // Calcular fechas
    const fechaVenta = new Date(venta.fecha_venta);
    const fechaEmision = fechaVenta.toLocaleDateString('es-PE');
    const horaEmision = fechaVenta.toLocaleTimeString('es-PE');
    
    // Calcular IGV y montos
    const igvPorcentaje = 0.18;
    let totalValorVenta = 0;
    let totalIGV = 0;
    let importeTotal = 0;

    // Calcular montos para cada producto
    const productosHTML = venta.detalles.map(detalle => {
        const precioConIGV = parseFloat(detalle.precio_unitario);
        const valorUnitario = precioConIGV / (1 + igvPorcentaje);
        const igvProducto = precioConIGV - valorUnitario;
        const subtotalValorVenta = valorUnitario * detalle.cantidad;
        const subtotalIGV = igvProducto * detalle.cantidad;
        
        totalValorVenta += subtotalValorVenta;
        totalIGV += subtotalIGV;
        importeTotal += parseFloat(detalle.subtotal);

        return `
            <tr>
                <td style="border: 1px solid #000; padding: 8px; text-align: center;">${detalle.cantidad}</td>
                <td style="border: 1px solid #000; padding: 8px; text-align: center;">UND</td>
                <td style="border: 1px solid #000; padding: 8px; text-align: left;">${detalle.producto?.nombre_producto || 'Producto'}</td>
                <td style="border: 1px solid #000; padding: 8px; text-align: right;">S/ ${valorUnitario.toFixed(2)}</td>
                <td style="border: 1px solid #000; padding: 8px; text-align: right;">S/ ${precioConIGV.toFixed(2)}</td>
            </tr>
        `;
    }).join('');

    return `
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 20px;
                    background-color: #fff;
                    font-size: 12px;
                }
                .boleta-container {
                    width: 100%;
                    max-width: 700px;
                    margin: 0 auto;
                    padding: 15px;
                    border: 1px solid #ccc;
                    background-color: #fff;
                }
                .header {
                    display: flex;
                    justify-content: space-between;
                    align-items: flex-start;
                    margin-bottom: 15px;
                    border: 1px solid #000;
                    padding: 8px;
                }
                .logo-box {
                    width: 50%;
                    display: flex;
                    align-items: center;
                }
                .logo {
                    width: 120px;
                    height: 40px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }
                .ruc-box {
                    width: 45%;
                    text-align: center;
                    border: 2px solid #000;
                    padding: 4px;
                    line-height: 1.3;
                }
                .ruc-box p {
                    margin: 0;
                    font-size: 11px;
                    font-weight: bold;
                }
                .ruc-box h2 {
                    margin: 3px 0;
                    font-size: 14px;
                    font-weight: 900;
                }
                .info-empresa, .info-cliente {
                    font-size: 10px;
                    margin-bottom: 12px;
                }
                .info-empresa p, .info-cliente p {
                    margin: 2px 0;
                }
                .info-cliente table {
                    width: 100%;
                    border-collapse: collapse;
                    font-size: 10px;
                }
                .info-cliente td {
                    padding: 1px 0;
                }
                .info-cliente .label {
                    font-weight: bold;
                    width: 120px;
                }
                .items-table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 15px;
                    font-size: 9px;
                }
                .items-table th, .items-table td {
                    border: 1px solid #000;
                    padding: 4px;
                    text-align: center;
                }
                .items-table th {
                    background-color: #f2f2f2;
                    text-transform: uppercase;
                }
                .items-table .text-left { text-align: left; }
                .items-table .text-right { text-align: right; }
                .footer-details {
                    display: flex;
                    justify-content: flex-end;
                    margin-top: 15px;
                }
                .total-box { 
                    width: 50%; 
                    margin-left: auto;
                }
                .total-table {
                    width: 100%;
                    border-collapse: collapse;
                    font-size: 10px;
                }
                .total-table tr:last-child td { font-weight: bold; }
                .total-table td {
                    padding: 3px;
                    border: 1px solid #000;
                }
                .total-table .label { text-align: right; width: 70%; }
                .total-table .currency { text-align: center; width: 5%; }
                .total-table .amount { text-align: right; width: 25%; }
                .footer-text {
                    margin-top: 15px;
                    font-size: 8px;
                    text-align: center;
                }
            </style>
        </head>
        <body>
            <div class="boleta-container">
                <div class="header">
                    <div class="logo-box">
                        <div class="logo">
                            <img src="/images/logo-empresa.jpg" alt="INVERSIONES ALIAGA" style="width: 120px; height: 40px; object-fit: contain;">
                        </div>
                    </div>
                    <div class="ruc-box">
                        <p>RUC: 10755123043</p>
                        <h2>BOLETA DE VENTA ELECTRÓNICA</h2>
                        <p>B${venta.id_venta.toString().padStart(8, '0')}</p>
                    </div>
                </div>
                
                <div class="info-empresa">
                    <p><strong>EMPRESA:</strong> INVERSIONES ALIAGA</p>
                    <p><strong>Domicilio Fiscal:</strong> Call Real 833 - HUANCAYO - HUANCAYO - JUNÍN</p>
                    <p><strong>Teléfono(s):</strong> +51 998 404 055 | <strong>Página Web:</strong> https://inversionesaliaga.com/</p>
                </div>

                <div class="info-cliente">
                    <table>
                        <tr>
                            <td class="label">Cliente</td>
                            <td>:</td>
                            <td>${venta.cliente?.nombre_cliente || ''} ${venta.cliente?.apellido_cliente || ''}</td>
                            <td class="label">Moneda</td>
                            <td>:</td>
                            <td>SOL</td>
                        </tr>
                        <tr>
                            <td class="label">Dirección</td>
                            <td>:</td>
                            <td>${venta.cliente?.direccion_cliente || 'No especificada'}</td>
                            <td class="label">Código de Cliente</td>
                            <td>:</td>
                            <td>C${(venta.cliente?.id_cliente || '').toString().padStart(6, '0')}</td>
                        </tr>
                        <tr>
                            <td class="label">DNI</td>
                            <td>:</td>
                            <td>${venta.cliente?.doc_ident || 'N/A'}</td>
                            <td class="label">Nombre</td>
                            <td>:</td>
                            <td>${venta.cliente?.nombre_cliente || ''}</td>
                        </tr>
                        <tr>
                            <td class="label">Fecha de Emisión</td>
                            <td>:</td>
                            <td>${fechaEmision}</td>
                            <td class="label">Hora de Emisión</td>
                            <td>:</td>
                            <td>${horaEmision}</td>
                        </tr>
                    </table>
                </div>

                <table class="items-table">
                    <thead>
                        <tr>
                            <th style="width: 8%;">Cantidad</th>
                            <th style="width: 8%;">UM</th>
                            <th style="width: 50%;">Descripción</th>
                            <th style="width: 17%;">Valor Unitario</th>
                            <th style="width: 17%;">Precio Unitario</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${productosHTML}
                    </tbody>
                </table>

                <div class="footer-details">
                    <div class="total-box">
                        <table class="total-table">
                            <tr>
                                <td class="label">Total Valor de Venta</td>
                                <td class="currency">S/</td>
                                <td class="amount">${totalValorVenta.toFixed(2)}</td>
                            </tr>
                            <tr>
                                <td class="label">IGV (18%)</td>
                                <td class="currency">S/</td>
                                <td class="amount">${totalIGV.toFixed(2)}</td>
                            </tr>
                            <tr>
                                <td class="label">Importe Total</td>
                                <td class="currency">S/</td>
                                <td class="amount">${importeTotal.toFixed(2)}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <p class="footer-text">
                    Representación Impresa de la Boleta de Venta Electrónica<br>
                    Emitido el ${fechaEmision} a las ${horaEmision}
                </p>
            </div>
        </body>
        </html>
    `;
}

// ========== VALIDACIONES DE FORMULARIO ==========
function validarDNI(input) {
    const mensaje = document.getElementById('dni-mensaje');
    const valor = input.value.replace(/[^0-9]/g, '');
    input.value = valor.slice(0, 8);
    
    if (valor.length === 8) {
        input.classList.remove('border-red-300');
        input.classList.add('border-green-300');
        mensaje.classList.remove('text-red-500');
        mensaje.classList.add('text-green-500');
        mensaje.textContent = '✓ DNI válido';
    } else {
        input.classList.remove('border-green-300');
        input.classList.add('border-red-300');
        mensaje.classList.remove('text-green-500');
        mensaje.classList.add('text-red-500');
        mensaje.textContent = `${valor.length}/8 dígitos`;
    }
}

function validarNombre(input) {
    const mensaje = document.getElementById('nombre-mensaje');
    const valor = input.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
    input.value = valor;
    
    if (valor.length >= 2) {
        input.classList.remove('border-red-300');
        input.classList.add('border-green-300');
        mensaje.classList.remove('text-red-500');
        mensaje.classList.add('text-green-500');
        mensaje.textContent = '✓ Nombre válido';
    } else {
        input.classList.remove('border-green-300');
        input.classList.add('border-red-300');
        mensaje.classList.remove('text-green-500');
        mensaje.classList.add('text-red-500');
        mensaje.textContent = 'Mínimo 2 letras';
    }
}

function validarApellido(input) {
    const mensaje = document.getElementById('apellido-mensaje');
    const valor = input.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
    input.value = valor;
    
    if (valor.length >= 2) {
        input.classList.remove('border-red-300');
        input.classList.add('border-green-300');
        mensaje.classList.remove('text-red-500');
        mensaje.classList.add('text-green-500');
        mensaje.textContent = '✓ Apellido válido';
    } else {
        input.classList.remove('border-green-300');
        input.classList.add('border-red-300');
        mensaje.classList.remove('text-green-500');
        mensaje.classList.add('text-red-500');
        mensaje.textContent = 'Mínimo 2 letras';
    }
}

function validarEmail(input) {
    const mensaje = document.getElementById('email-mensaje');
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
    if (input.value === '') {
        // Campo vacío - es válido porque es opcional
        input.classList.remove('border-red-300', 'border-green-300');
        mensaje.classList.remove('text-red-500', 'text-green-500');
        mensaje.textContent = 'Opcional - Para envío de comprobante';
    } else if (emailRegex.test(input.value)) {
        // Email válido
        input.classList.remove('border-red-300');
        input.classList.add('border-green-300');
        mensaje.classList.remove('text-red-500');
        mensaje.classList.add('text-green-500');
        mensaje.textContent = '✓ Email válido';
    } else {
        // Email inválido
        input.classList.remove('border-green-300');
        input.classList.add('border-red-300');
        mensaje.classList.remove('text-green-500');
        mensaje.classList.add('text-red-500');
        mensaje.textContent = 'Formato de email inválido';
    }
}

function validarTelefono(input) {
    const mensaje = document.getElementById('telefono-mensaje');
    const valor = input.value.replace(/[^0-9]/g, '');
    input.value = valor.slice(0, 9);
    
    if (valor.length === 9 || valor.length === 0) {
        input.classList.remove('border-red-300');
        input.classList.add('border-green-300');
        mensaje.classList.remove('text-red-500');
        mensaje.classList.add('text-green-500');
        mensaje.textContent = valor.length === 9 ? '✓ Teléfono válido' : '9 dígitos numéricos';
    } else {
        input.classList.remove('border-green-300');
        input.classList.add('border-red-300');
        mensaje.classList.remove('text-green-500');
        mensaje.classList.add('text-red-500');
        mensaje.textContent = `${valor.length}/9 dígitos`;
    }
}

// ========== BÚSQUEDA DINÁMICA DE PRODUCTOS ==========
function buscarProductosDinamico() {
    clearTimeout(timeoutBusqueda);
    timeoutBusqueda = setTimeout(() => {
        const query = document.getElementById('buscador-producto').value.trim();
        const resultadosDiv = document.getElementById('resultados-busqueda');
        
        if (query.length < 2) {
            resultadosDiv.classList.add('hidden');
            return;
        }

        fetch(`/admin/buscar-productos?q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                resultadosDiv.innerHTML = '';
                
                if (data.success && data.productos.length > 0) {
                    resultadosDiv.classList.remove('hidden');
                    
                    data.productos.forEach(producto => {
                        const div = document.createElement('div');
                        div.className = 'p-3 border-b cursor-pointer hover:bg-blue-50 transition-colors';
                        div.innerHTML = `
                            <div class="flex justify-between items-center">
                                <div>
                                    <strong class="text-gray-800">${producto.nombre_producto}</strong>
                                    <div class="text-sm text-gray-600">
                                        S/ ${producto.precio_producto} • Stock: ${producto.stock_producto}
                                    </div>
                                </div>
                                <button type="button" onclick="seleccionarProducto(${producto.id_producto})" 
                                        class="bg-green-500 text-white px-3 py-1 rounded text-sm hover:bg-green-600 transition-colors">
                                    Agregar
                                </button>
                            </div>
                        `;
                        resultadosDiv.appendChild(div);
                    });
                } else {
                    resultadosDiv.innerHTML = '<div class="p-3 text-gray-500 text-center">No se encontraron productos</div>';
                    resultadosDiv.classList.remove('hidden');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                resultadosDiv.innerHTML = '<div class="p-3 text-red-500 text-center">Error al buscar productos</div>';
                resultadosDiv.classList.remove('hidden');
            });
    }, 300); // 300ms de delay
}

// Ocultar resultados al hacer clic fuera
document.addEventListener('click', function(e) {
    if (!e.target.closest('#buscador-producto') && !e.target.closest('#resultados-busqueda')) {
        document.getElementById('resultados-busqueda').classList.add('hidden');
    }
});

// ========== GESTIÓN DE PRODUCTOS ==========
function seleccionarProducto(idProducto) {
    if (productosSeleccionados.has(idProducto)) {
        mostrarError('Este producto ya fue agregado');
        return;
    }

    fetch(`/admin/productos/${idProducto}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                agregarProductoAlFormulario(data.producto);
                productosSeleccionados.add(idProducto);
                document.getElementById('resultados-busqueda').classList.add('hidden');
                document.getElementById('buscador-producto').value = '';
            } else {
                mostrarError('Error al cargar el producto');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarError('Error al cargar el producto');
        });
}

function agregarProductoAlFormulario(producto) {
    const container = document.getElementById('productos-container');
    const productoDiv = document.createElement('div');
    productoDiv.className = 'producto-item grid grid-cols-1 md:grid-cols-4 gap-4 mb-4 p-3 bg-white rounded-lg border border-gray-200 shadow-sm';
    productoDiv.innerHTML = `
        <input type="hidden" name="productos[${productoCount}][id_producto]" value="${producto.id}">
        <div>
            <label class="block text-sm font-medium text-gray-700">Producto</label>
            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-50" 
                   value="${producto.nombre}" readonly>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Cantidad *</label>
            <input type="number" name="productos[${productoCount}][cantidad]" min="1" max="${producto.stock}" 
                   value="1" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 cantidad-input" 
                   onchange="validarStock(this, ${producto.stock})" required>
            <small class="text-gray-500">Stock: ${producto.stock}</small>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Precio Unitario</label>
            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-50 precio-unitario" 
                   value="S/ ${parseFloat(producto.precio).toFixed(2)}" readonly>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Subtotal</label>
            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-50 subtotal" 
                   value="S/ ${parseFloat(producto.precio).toFixed(2)}" readonly>
        </div>
        <div class="md:col-span-4 flex justify-end">
            <button type="button" onclick="eliminarProducto(this, ${producto.id})" 
                    class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600 transition-colors">
                ❌ Eliminar
            </button>
        </div>
    `;
    container.appendChild(productoDiv);
    productoCount++;
    calcularTotal();
}

function agregarProducto() {
    document.getElementById('buscador-producto').focus();
}

function eliminarProducto(button, idProducto) {
    productosSeleccionados.delete(idProducto);
    button.closest('.producto-item').remove();
    calcularTotal();
}

function validarStock(input, stockMaximo) {
    const cantidad = parseInt(input.value);
    if (cantidad > stockMaximo) {
        input.value = stockMaximo;
        mostrarError(`La cantidad no puede superar el stock disponible (${stockMaximo})`);
    }
    if (cantidad < 1) {
        input.value = 1;
    }
    calcularSubtotal(input);
}

function calcularSubtotal(input) {
    const productoItem = input.closest('.producto-item');
    const precioUnitario = productoItem.querySelector('.precio-unitario');
    const subtotal = productoItem.querySelector('.subtotal');
    
    const precio = parseFloat(precioUnitario.value.replace('S/ ', ''));
    const cantidad = parseInt(input.value) || 0;
    const subtotalCalculado = precio * cantidad;
    
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

function limpiarFormulario() {
    // Limpiar productos
    productosSeleccionados.clear();
    document.getElementById('productos-container').innerHTML = '';
    document.getElementById('buscador-producto').value = '';
    document.getElementById('resultados-busqueda').classList.add('hidden');
    
    // Resetear contador y total
    productoCount = 0;
    document.getElementById('total-venta').textContent = '0.00';
    
    // Limpiar y resetear validaciones de campos
    const campos = ['doc_ident', 'nombre_cliente', 'apellido_cliente', 'email_cliente', 'telefono_cliente'];
    campos.forEach(campo => {
        const input = document.getElementById(campo);
        input.value = '';
        input.classList.remove('border-red-300', 'border-green-300');
        const mensaje = document.getElementById(`${campo}-mensaje`);
        mensaje.classList.remove('text-red-500', 'text-green-500');
    });
    
    // Restaurar mensajes originales
    document.getElementById('dni-mensaje').textContent = '8 dígitos numéricos';
    document.getElementById('nombre-mensaje').textContent = 'Solo letras y espacios';
    document.getElementById('apellido-mensaje').textContent = 'Solo letras y espacios';
    document.getElementById('email-mensaje').textContent = 'Opcional - Para envío de comprobante';
    document.getElementById('telefono-mensaje').textContent = '9 dígitos numéricos';
}

function mostrarError(mensaje) {
    const notificacion = document.createElement('div');
    notificacion.className = 'fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
    notificacion.textContent = mensaje;
    document.body.appendChild(notificacion);
    
    setTimeout(() => {
        notificacion.remove();
    }, 3000);
}

// Validación del formulario antes de enviar
document.getElementById('form-venta').addEventListener('submit', function(e) {
    // Validar DNI
    const dni = document.getElementById('doc_ident').value;
    if (dni.length !== 8) {
        e.preventDefault();
        mostrarError('El DNI debe tener exactamente 8 dígitos');
        document.getElementById('doc_ident').focus();
        return;
    }
    
    // Validar email (solo si está lleno)
    const email = document.getElementById('email_cliente').value;
    if (email && email.length > 0) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            e.preventDefault();
            mostrarError('El email debe tener un formato válido');
            document.getElementById('email_cliente').focus();
            return;
        }
    }
    
    if (productosSeleccionados.size === 0) {
        e.preventDefault();
        mostrarError('Debe agregar al menos un producto');
        document.getElementById('buscador-producto').focus();
        return;
    }
    
    // Tomar el primer producto como principal (para compatibilidad con controlador original)
    const primerProducto = document.querySelector('.producto-item');
    if (primerProducto) {
        const hiddenInput = primerProducto.querySelector('input[type="hidden"]');
        const cantidadInput = primerProducto.querySelector('.cantidad-input');
        const precioInput = primerProducto.querySelector('.precio-unitario');
        
        if (hiddenInput) {
            const hiddenIdProducto = document.createElement('input');
            hiddenIdProducto.type = 'hidden';
            hiddenIdProducto.name = 'id_producto';
            hiddenIdProducto.value = hiddenInput.value;
            this.appendChild(hiddenIdProducto);
        }
        
        if (cantidadInput) {
            const hiddenCantidad = document.createElement('input');
            hiddenCantidad.type = 'hidden';
            hiddenCantidad.name = 'cantidad';
            hiddenCantidad.value = cantidadInput.value;
            this.appendChild(hiddenCantidad);
        }
        
        if (precioInput) {
            const precio = parseFloat(precioInput.value.replace('S/ ', ''));
            const hiddenPrecio = document.createElement('input');
            hiddenPrecio.type = 'hidden';
            hiddenPrecio.name = 'precio_unitario';
            hiddenPrecio.value = precio;
            this.appendChild(hiddenPrecio);
        }
    }
});

// 🔥 AGREGAR ESTILO PARA EL SPINNER
const style = document.createElement('style');
style.textContent = `
    .animate-spin {
        animation: spin 1s linear infinite;
    }
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
`;
document.head.appendChild(style);
</script>