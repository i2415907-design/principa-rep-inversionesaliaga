{{-- 🧾 Simulación de pago por QR --}}
<div class="mt-12 bg-white p-6 rounded-lg shadow-lg grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
    {{-- QR de pago --}}
    <div class="text-center">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">🔍 Escanea y paga</h2>
        <img src="{{ asset('img/qr-mock.png') }}" alt="QR de pago" class="w-48 h-48 mx-auto border-2 border-gray-300 p-2 rounded-lg">
        <p class="mt-3 text-gray-600">Monto a pagar: <span class="text-orange-600 font-semibold">S/ 1</span></p>
        <p class="text-sm text-gray-400">Este QR es solo una simulación.</p>
    </div>

    {{-- Botones auxiliares --}}
    <div class="flex flex-col space-y-4">
        <a href="#" class="flex items-center justify-center bg-yellow-400 hover:bg-yellow-500 text-white font-semibold py-3 px-6 rounded-lg shadow transition">
            🔔 Ver notificaciones
        </a>
        <a href="/" class="flex items-center justify-center bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-lg shadow transition">
            🏠 Ir al inicio
        </a>
        <a href="mailto:soporte@tutienda.com" class="flex items-center justify-center bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-6 rounded-lg shadow transition">
            📧 Contactar por correo
        </a>
    </div>
</div>
