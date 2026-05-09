@php
    // Usar datos del checkout si están disponibles, sino datos de ejemplo
    $productos = $checkoutData['productos'] ?? [
        ['id' => 1, 'nombre' => 'Mouse Genius Blue Eye', 'descripcion' => '120 DPI', 'precio' => 45.0, 'cantidad' => 1, 'img' => 'mouse.jpg'],
        ['id' => 2, 'nombre' => 'Audífonos Movisun', 'descripcion' => '15H REPROD', 'precio' => 65.0, 'cantidad' => 1, 'img' => 'audifonos.jpg'],
    ];
    
    $subtotal = $checkoutData['subtotal'] ?? array_reduce($productos, fn($sum, $item) => $sum + $item['precio'] * $item['cantidad'], 0);
    $precioEnvio = $checkoutData['precio_envio'] ?? 0;
    $total = $checkoutData['total'] ?? ($subtotal + $precioEnvio);
    $recojoTienda = $checkoutData['recojo_tienda'] ?? false;
    $distritoId = $checkoutData['distrito_id'] ?? '';

    $metodos = [
        ['id' => 'yape',
        'nombre' => 'Mercado Pago',
        'imagen' => '/images/imagesinversiones/Mp.png'
        ],
    [
        'id' => 'fake_yape',
        'nombre' => 'Yape (Próximamente)',
        'imagen' => '/images/imagesinversiones/yape.png'
    ],
    [
        'id' => 'fake_tarjeta',
        'nombre' => 'Pago Efectivo',
        'imagen' => '/images/imagesinversiones/Pef.png'
    ]
];
@endphp

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Resumen del pedido -->
    <div class="md:col-span-1 bg-gray-200-50 border border-black-200 p-4 rounded-lg shadow-md h-fit">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Resumen del carrito</h2>
        
        <ul class="space-y-3 text-sm">
            @forelse($productos as $item)
                <li class="flex justify-between items-center bg-white p-3 rounded-lg shadow-sm border">
        @if(isset($item['imagen']) && $item['imagen'])
            <img src="{{ route('images.products', ['filename' => basename($item['imagen'])]) }}" alt="{{ $item['nombre'] }}" class="w-14 h-14 object-contain rounded">
        @else
            <div class="w-14 h-14 bg-gray-200 rounded flex items-center justify-center">
                <span class="text-gray-400 text-xs">Sin imagen</span>
            </div>
        @endif
                    <div class="ml-3 flex-1">
                        <p class="font-semibold text-gray-800">{{ $item['nombre'] }}</p>
                        <p class="text-gray-500 text-xs">Cantidad: {{ $item['cantidad'] }}</p>
                    </div>
                    <div class="text-right font-semibold text-orange-600">
                        S/ {{ number_format($item['precio'] * $item['cantidad'], 2) }}
                    </div>
                </li>
            @empty
                <p class="text-gray-500">No hay productos seleccionados.</p>
            @endforelse

        </ul>

        <div class="mt-6 border-t pt-4 space-y-2">
            <div class="flex justify-between text-sm">
                <span>Subtotal:</span>
                <strong class="text-orange-700">S/ {{ number_format($subtotal, 2) }}</strong>
            </div>
            <div class="flex justify-between text-sm">
                <span>Envío:</span>
                <strong class="text-orange-700">S/ {{ number_format($precioEnvio, 2) }}</strong>
            </div>
            <div class="flex justify-between text-lg font-bold border-t pt-2">
                <span>Total:</span>
                <span class="text-orange-700">S/ {{ number_format($total, 2) }}</span>
            </div>
            @if($recojoTienda)
                <div class="text-xs text-green-600 font-semibold mt-2">
                    Recoger en tienda
                </div>
            @endif
        </div>
    </div>

    <!-- Detalles de compra y métodos de pago -->
    <div class="md:col-span-2">
        <form id="formPago" class="bg-white p-6 rounded-lg shadow-lg space-y-6" method="POST" action="{{ route('checkout.procesar') }}">
            @csrf
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Datos para la compra</h2>
            
            <!-- Campos ocultos con datos del checkout -->
            <input type="hidden" name="recojo_tienda" id="inputRecojoTienda" value="{{ $recojoTienda ? '1' : '0' }}">
            <input type="hidden" name="distrito_id" value="{{ $distritoId }}">
            <input type="hidden" name="subtotal" value="{{ $subtotal }}">
            <input type="hidden" name="precio_envio" value="{{ $precioEnvio }}">
            <input type="hidden" name="total" value="{{ $total }}">
            <input type="hidden" name="productos" value="{{ json_encode($productos) }}">

            <!-- Validación de sesión -->
            @if(!auth()->check())
                <div class="bg-red-100 text-red-800 p-4 rounded text-sm">
                    Para continuar, debes <a href="{{ route('login') }}" class="underline font-semibold text-blue-700">iniciar sesión</a>.
                </div>
            @endif

            <!-- Formulario -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <input type="text" name="nombres" placeholder="Nombres *" class="w-full p-3 border rounded-lg" {{ !auth()->check() ? 'disabled' : '' }}>
                </div>
                <div>
                    <input type="text" name="apellidos" placeholder="Apellidos *" class="w-full p-3 border rounded-lg" {{ !auth()->check() ? 'disabled' : '' }}>
                </div>
                <div>
                    <input type="text" name="dni" placeholder="DNI *" class="w-full p-3 border rounded-lg" {{ !auth()->check() ? 'disabled' : '' }}>
                </div>
                <div>
                    <input type="text" name="cel" placeholder="CEL/TELF *" class="w-full p-3 border rounded-lg" {{ !auth()->check() ? 'disabled' : '' }}>
                </div>
                <div>
                    <input type="email" name="correo_alt" placeholder="Correo alternativo (opcional)" class="w-full p-3 border rounded-lg" {{ !auth()->check() ? 'disabled' : '' }}>
                </div>
            </div>

            <!-- Zona de envío -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <input type="text" id="codigoPostal" name="codigo_postal" placeholder="Código Postal {{ $recojoTienda ? '' : '*' }}" class="w-full p-3 border rounded-lg" {{ !auth()->check() ? 'disabled' : '' }} {{ $recojoTienda ? 'disabled' : '' }}>
                </div>
                <div>
                    <input type="text" id="ubicacion" name="ubicacion" placeholder="Ubicación {{ $recojoTienda ? '' : '*' }}" class="w-full p-3 border rounded-lg" {{ !auth()->check() ? 'disabled' : '' }} {{ $recojoTienda ? 'disabled' : '' }}>
                </div>
            </div>

            <div>
                <textarea id="referencias" name="referencias" placeholder="Referencia/s {{ $recojoTienda ? '' : '*' }}" class="w-full p-3 border rounded-lg" {{ !auth()->check() ? 'disabled' : '' }} {{ $recojoTienda ? 'disabled' : '' }}></textarea>
            </div>

            <!-- Métodos de pago -->
            <h2 class="text-2xl font-bold text-gray-800">Método de pago actual:</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($metodos as $metodo)
<label for="{{ $metodo['id'] }}" class="flex items-center space-x-4 bg-gray-400-50 p-4 border border-black-200-200 rounded-lg shadow-sm hover:bg-orange-100 cursor-pointer transition">

    <input
        type="radio"
        name="metodo_pago"
        id="{{ $metodo['id'] }}"
        value="{{ $metodo['id'] }}"
        class="accent-orange-500"

    >

    <img src="{{ $metodo['imagen'] }}" 
         alt="{{ $metodo['nombre'] }}" 
         class="w-12 h-12 object-contain">

    <span class="font-medium text-gray-800">
        {{ $metodo['nombre'] }}
    </span>

</label>

                @endforeach
            </div>

            <!-- Botones -->
            <div class="flex justify-between pt-6">
                <a href="{{ route('carrito.carritocliente') }}"
                   class="bg-gray-400 text-white px-6 py-2 rounded-lg hover:bg-gray-500 transition">
                    Volver
                </a>

                <button type="submit"
                        class="bg-orange-500 text-white px-6 py-2 rounded-lg hover:bg-orange-600 transition"
                        {{ !auth()->check() ? 'disabled class=cursor-not-allowed opacity-50' : '' }}>
                    Pagar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('formPago');
    const campos = ['codigoPostal', 'ubicacion', 'referencias'];
    const inputRecojo = document.getElementById('inputRecojoTienda');

    // Bloquear campos si es recojo en tienda
    function toggleCampos(disabled) {
        campos.forEach(id => {
            const campo = document.getElementById(id);
            if (campo) {
                campo.disabled = disabled;
                campo.classList.toggle('bg-gray-200', disabled);
                campo.classList.toggle('cursor-not-allowed', disabled);
            }
        });
    }

    const recojoEnTienda = {{ $recojoTienda ? 'true' : 'false' }};
    toggleCampos(recojoEnTienda);

    if (inputRecojo) {
        inputRecojo.value = recojoEnTienda ? '1' : '0';
    }

    // Función para mostrar error
    function mostrarError(input, mensaje) {
        const contenedor = input.parentNode;
        
        // Remover error anterior
        const errorAnterior = contenedor.querySelector('.error-mensaje');
        if (errorAnterior) {
            errorAnterior.remove();
        }
        
        // Quitar borde rojo anterior
        input.classList.remove('border-red-500', 'border-2');
        
        // Si hay mensaje, mostrar error
        if (mensaje) {
            input.classList.add('border-red-500', 'border-2');
            const errorElement = document.createElement('div');
            errorElement.className = 'error-mensaje text-red-500 text-xs mt-1 flex items-start';
            errorElement.innerHTML = `
                <svg class="w-3 h-3 mr-1 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <span>${mensaje}</span>
            `;
            contenedor.appendChild(errorElement);
        }
    }

    // Validación en tiempo real
    document.querySelectorAll('input[name="nombres"], input[name="apellidos"]').forEach(input => {
        input.addEventListener('input', function() {
            this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
            if (this.value && !/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(this.value)) {
                mostrarError(this, 'Solo se permiten letras y espacios');
            } else {
                mostrarError(this, '');
            }
        });
        
        input.addEventListener('blur', function() {
            if (this.value && !/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(this.value)) {
                mostrarError(this, 'Solo se permiten letras y espacios');
            }
        });
    });

    // Solo números para DNI, celular, código postal
    document.querySelectorAll('input[name="dni"], input[name="cel"], input[name="codigo_postal"]').forEach(input => {
        input.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '');
            
            // Limitar longitud
            if (this.name === 'dni' && this.value.length > 8) {
                this.value = this.value.slice(0, 8);
            }
            if (this.name === 'cel' && this.value.length > 9) {
                this.value = this.value.slice(0, 9);
            }
            if (this.name === 'codigo_postal' && this.value.length > 5) {
                this.value = this.value.slice(0, 5);
            }
            
            // Validar en tiempo real
            let mensaje = '';
            if (this.name === 'dni' && this.value && this.value.length !== 8) {
                mensaje = 'El DNI debe tener 8 digitos';
            } else if (this.name === 'cel' && this.value && this.value.length !== 9) {
                mensaje = 'El celular debe tener 9 digitos';
            } else if (this.name === 'codigo_postal' && this.value && this.value.length !== 5) {
                mensaje = 'El codigo postal debe tener 5 digitos';
            }
            mostrarError(this, mensaje);
        });
        
        input.addEventListener('blur', function() {
            let mensaje = '';
            if (this.name === 'dni' && this.value && this.value.length !== 8) {
                mensaje = 'El DNI debe tener 8 digitos';
            } else if (this.name === 'cel' && this.value && this.value.length !== 9) {
                mensaje = 'El celular debe tener 9 digitos';
            } else if (this.name === 'codigo_postal' && this.value && this.value.length !== 5) {
                mensaje = 'El codigo postal debe tener 5 digitos';
            }
            if (mensaje) {
                mostrarError(this, mensaje);
            }
        });
    });

    // Validar email en tiempo real
    const correoInput = document.querySelector('input[name="correo_alt"]');
    if (correoInput) {
        correoInput.addEventListener('input', function() {
            if (this.value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.value)) {
                mostrarError(this, 'Ingresa un correo valido');
            } else {
                mostrarError(this, '');
            }
        });
        
        correoInput.addEventListener('blur', function() {
            if (this.value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.value)) {
                mostrarError(this, 'Ingresa un correo valido');
            }
        });
    }

    // Evento submit
    form.addEventListener('submit', async function(e){
        e.preventDefault();
        
        console.log('INICIANDO PROCESO DE PAGO');
        
        const recojoTienda = document.getElementById('inputRecojoTienda').value === '1';
        let hayErrores = false;

        // Limpiar todos los errores anteriores
        document.querySelectorAll('.error-mensaje').forEach(error => error.remove());
        document.querySelectorAll('.border-red-500').forEach(input => input.classList.remove('border-red-500', 'border-2'));

        // Validar nombres
        const nombres = form.querySelector('[name="nombres"]');
        const nombresValor = nombres.value.trim();
        if (!nombresValor) {
            mostrarError(nombres, 'El campo nombres es obligatorio');
            hayErrores = true;
        } else if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(nombresValor)) {
            mostrarError(nombres, 'Solo se permiten letras y espacios');
            hayErrores = true;
        }

        // Validar apellidos
        const apellidos = form.querySelector('[name="apellidos"]');
        const apellidosValor = apellidos.value.trim();
        if (!apellidosValor) {
            mostrarError(apellidos, 'El campo apellidos es obligatorio');
            hayErrores = true;
        } else if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(apellidosValor)) {
            mostrarError(apellidos, 'Solo se permiten letras y espacios');
            hayErrores = true;
        }

        // Validar DNI
        const dni = form.querySelector('[name="dni"]');
        const dniValor = dni.value.trim();
        if (!dniValor) {
            mostrarError(dni, 'El DNI es obligatorio');
            hayErrores = true;
        } else if (!/^\d{8}$/.test(dniValor)) {
            mostrarError(dni, 'El DNI debe tener 8 digitos');
            hayErrores = true;
        }

        // Validar celular
        const cel = form.querySelector('[name="cel"]');
        const celValor = cel.value.trim();
        if (!celValor) {
            mostrarError(cel, 'El celular es obligatorio');
            hayErrores = true;
        } else if (!/^\d{9}$/.test(celValor)) {
            mostrarError(cel, 'El celular debe tener 9 digitos');
            hayErrores = true;
        }

        // Validar correo
        const correoAlt = form.querySelector('[name="correo_alt"]');
        const correoAltValor = correoAlt.value.trim();
        if (correoAltValor && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(correoAltValor)) {
            mostrarError(correoAlt, 'Ingresa un correo valido');
            hayErrores = true;
        }

        // Validar método de pago
        const metodoPago = form.querySelector('[name="metodo_pago"]:checked');
        if (!metodoPago) {
            const metodosContainer = form.querySelector('h2.text-2xl').nextElementSibling;
            const errorExistente = metodosContainer.querySelector('.error-mensaje');
            if (!errorExistente) {
                const errorElement = document.createElement('div');
                errorElement.className = 'error-mensaje text-red-500 text-sm mt-2 flex items-center bg-red-50 p-2 rounded border border-red-200';
                errorElement.innerHTML = `
                    <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    Debes seleccionar un metodo de pago
                `;
                metodosContainer.appendChild(errorElement);
            }
            hayErrores = true;
        }

        // Validar campos de envío (solo si NO es recojo en tienda)
        if (!recojoTienda) {
            const codigoPostal = form.querySelector('[name="codigo_postal"]');
            const codigoPostalValor = codigoPostal.value.trim();
            if (!codigoPostalValor) {
                mostrarError(codigoPostal, 'El codigo postal es obligatorio para envios');
                hayErrores = true;
            } else if (!/^\d{5}$/.test(codigoPostalValor)) {
                mostrarError(codigoPostal, 'El codigo postal debe tener 5 digitos');
                hayErrores = true;
            }

            const ubicacion = form.querySelector('[name="ubicacion"]');
            const ubicacionValor = ubicacion.value.trim();
            if (!ubicacionValor) {
                mostrarError(ubicacion, 'La ubicacion es obligatoria para envios');
                hayErrores = true;
            }

            const referencias = form.querySelector('[name="referencias"]');
            const referenciasValor = referencias.value.trim();
            if (!referenciasValor) {
                mostrarError(referencias, 'Las referencias son obligatorias para envios');
                hayErrores = true;
            }
        }

        // Si hay errores, detener aquí
        if (hayErrores) {
            const primerError = form.querySelector('.border-red-500');
            if (primerError) {
                primerError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                primerError.focus();
            }
            return;
        }

        // Si todo está bien - proceder con el pago
        console.log('Validacion exitosa - Procediendo con pago...');
        
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        try {
            // Mostrar loading
            submitBtn.innerHTML = 'Procesando pago...';
            submitBtn.disabled = true;

            // Recolectar todos los datos del formulario
            const formData = new FormData(this);
            
            console.log('Datos enviados:', Object.fromEntries(formData));

            // Paso 1: Procesar checkout (guardar cliente)
            console.log('Paso 1: Procesando datos del cliente...');
            const responseCheckout = await fetch('{{ route("checkout.procesar") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            if (!responseCheckout.ok) {
                const errorText = await responseCheckout.text();
                console.error('Error en checkout:', errorText);
                throw new Error('Error al procesar los datos del cliente');
            }

            const checkoutResult = await responseCheckout.json();
            console.log('Checkout procesado:', checkoutResult);

            // Paso 2: Generar pago con Mercado Pago
            console.log('Paso 2: Generando pago con Mercado Pago...');
            const responsePago = await fetch('{{ route("checkout.qr") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            if (!responsePago.ok) {
                const errorText = await responsePago.text();
                console.error('Error en pago:', errorText);
                throw new Error('Error al generar el pago');
            }

            const data = await responsePago.json();
            
            console.log('Respuesta del pago:', data);

            if (data.init_point) {
                console.log('Redirigiendo a Mercado Pago...');
                // Redirigir a Mercado Pago en la misma ventana
                window.location.href = data.init_point;
            } else if (data.error) {
                throw new Error(data.error + (data.detalle ? ': ' + data.detalle : ''));
            } else {
                throw new Error('Error desconocido al generar el pago');
            }
            
        } catch (error) {
            console.error('Error completo:', error);
            
            let errorMsg = 'Error al procesar el pago';
            if (error.message.includes('monto minimo')) {
                errorMsg = error.message;
            } else if (error.message.includes('cliente no encontrados')) {
                errorMsg = 'Error en los datos del cliente. Por favor, recarga la pagina e intenta nuevamente.';
            } else {
                errorMsg = error.message || 'Error interno del servidor';
            }
            
            alert('Error: ' + errorMsg);
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
    });
});
</script>