@php
    $menuItems = [
        [
            'text' => 'Avisos',
            'url' => auth()->check() ? route('notificaciones.notificliente') : route('notificaciones.notificliente'),
            'icon' => '
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6 mr-2 md:mb-1 md:mr-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                </svg>',
            'badge' => auth()->check() ? auth()->user()->unreadNotifications->count() : null,
        ],
        [
            'text' => auth()->check() ? auth()->user()->nombre_usuario : 'Usuario',
            'url' => auth()->check() ? route('perfil') : route('login'),
            'icon' => '
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6 mr-2 md:mb-1 md:mr-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>'
        ],
        [
            'text' => 'Carrito',
            'url' => route('carrito.carritocliente'),
            'icon' => '
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6 mr-2 md:mb-1 md:mr-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25h11.218c1.121-2.3 2.1-4.684 2.924-7.138M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                </svg>',
            'badge' => session('carrito') ? count(session('carrito')) : 0
        ],
    ];
@endphp

<div class="flex justify-around items-center w-full md:w-auto gap-4 md:gap-6 px-2">
    @foreach ($menuItems as $item)
        <a href="{{ $item['url'] }}" class="flex items-center md:flex-col md:text-xs hover:text-orange-500 transition relative space-x-2 md:space-x-0">

            <!-- Ícono con badge flotante -->
            <div class="relative">
                {!! $item['icon'] !!}
                @if(isset($item['badge']) && $item['badge'] > 0)
                    <span class="absolute -top-1 -right-1 bg-orange-500 text-white text-[10px] w-5 h-5 flex items-center justify-center rounded-full shadow-sm">
                        {{ $item['badge'] }}
                    </span>
                @endif
            </div>

            <!-- Texto -->
            <span class="text-[13px] font-medium md:mt-1 truncate max-w-[80px] text-center">
                {{ Str::limit($item['text'], 12) }}
            </span>

        </a>
    @endforeach
</div>


