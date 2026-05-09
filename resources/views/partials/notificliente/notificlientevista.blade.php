<div class="max-w-2xl mx-auto mt-10 px-4">
    @auth
       <div class="bg-white shadow-md rounded-xl p-6 space-y-4">
    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
        🔔 Noticias y avisos publicados
    </h3>
    @if(isset($avisos) && $avisos->count())
        <ul class="space-y-3">
            @foreach($avisos as $aviso)
                <li class="bg-gray-50 border border-gray-200 p-4 rounded-lg hover:bg-gray-100 transition duration-150">
                    <p class="font-semibold text-orange-600">{{ $aviso->titulo }}</p>
                    <p class="text-sm text-gray-700">{{ $aviso->mensaje }}</p>
                    <span class="text-xs text-gray-500">{{ $aviso->fecha_publicacion }}</span>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-gray-600 text-center">📭 No hay avisos publicados todavía.</p>
    @endif
</div>
    @else
        <div class="bg-white shadow-md rounded-xl p-6 text-center">
            <h2 class="text-xl font-semibold text-gray-800 mb-2">🔒 Acceso restringido</h2>
            <p class="text-gray-600 mb-4">Por favor inicia sesión para ver tus notificaciones</p>
            <a href="{{ route('login') }}" class="inline-block bg-orange-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                Iniciar sesión
            </a>
        </div>
    @endauth
</div>
