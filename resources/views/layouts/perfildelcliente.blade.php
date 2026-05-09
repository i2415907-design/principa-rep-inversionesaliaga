<!DOCTYPE html>
<html lang="es">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inversiones Aliaga</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .pc-wrap  { max-width:720px; margin:0 auto; padding:32px 16px 64px; display:flex; flex-direction:column; gap:20px; }

        /* Hero */
        .pc-hero  { background:#1c1917; border-radius:18px; padding:28px 32px; display:flex; align-items:center; justify-content:space-between; gap:16px; position:relative; overflow:hidden; }
        .pc-hero::before { content:''; position:absolute; top:-50px; right:-50px; width:220px; height:220px; border-radius:50%; background:radial-gradient(circle, rgba(249,115,22,.2) 0%, transparent 70%); pointer-events:none; }
        .pc-hero-label  { font-size:.65rem; font-weight:700; letter-spacing:.12em; text-transform:uppercase; color:rgba(255,255,255,.4); margin-bottom:4px; }
        .pc-hero-name   { font-size:1.6rem; font-weight:800; color:#fff; line-height:1.1; }
        .pc-hero-name span { color:#f97316; }
        .pc-hero-sub    { font-size:.8rem; color:rgba(255,255,255,.45); margin-top:5px; }
        .pc-hero-avatar { width:52px; height:52px; border-radius:14px; background:rgba(249,115,22,.18); border:2px solid rgba(249,115,22,.4); display:flex; align-items:center; justify-content:center; font-size:1.4rem; font-weight:800; color:#f97316; flex-shrink:0; position:relative; z-index:1; }

        /* Cards */
        .pc-card  { background:#fff; border:1px solid #e5e0d8; border-radius:18px; padding:24px 28px; }
        .pc-clabel{ font-size:.65rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:#b45309; margin-bottom:18px; display:block; }

        /* Alerts */
        .pc-err   { background:#fef2f2; border:1px solid #fecaca; color:#b91c1c; font-size:.82rem; border-radius:10px; padding:10px 14px; margin-bottom:14px; }
        .pc-ok    { background:#f0fdf4; border:1px solid #bbf7d0; color:#15803d; font-size:.82rem; border-radius:10px; padding:10px 14px; margin-bottom:14px; }

        /* Form grid */
        .pc-grid  { display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:18px; }
        .pc-flabel{ display:block; font-size:.68rem; font-weight:600; text-transform:uppercase; letter-spacing:.05em; color:#78716c; margin-bottom:5px; }
        .pc-input { width:100%; border:1.5px solid #e7ddd4; border-radius:10px; padding:9px 13px; font-size:.875rem; font-family:inherit; color:#1c1917; background:#fdfcfb; outline:none; transition:border-color .15s,box-shadow .15s; }
        .pc-input:focus { border-color:#f97316; box-shadow:0 0 0 3px rgba(249,115,22,.12); }
        .pc-hint  { font-size:.68rem; color:#a8a29e; margin-top:3px; }

        /* Buttons */
        .pc-btn-save   { background:#ea580c; color:#fff; border:none; font-family:inherit; font-size:.82rem; font-weight:600; padding:10px 22px; border-radius:10px; cursor:pointer; transition:background .15s; }
        .pc-btn-save:hover { background:#c2410c; }
        .pc-btn-logout { width:100%; background:#fff; color:#dc2626; border:1.5px solid #fecaca; font-family:inherit; font-size:.82rem; font-weight:600; padding:10px; border-radius:12px; cursor:pointer; transition:background .15s; }
        .pc-btn-logout:hover { background:#fef2f2; }

        /* Compras header */
        .pc-compras-top { display:flex; align-items:flex-start; justify-content:space-between; flex-wrap:wrap; gap:10px; padding-bottom:16px; border-bottom:1px solid #f0ece6; margin-bottom:18px; }
        .pc-notice { font-size:.72rem; font-weight:600; background:#fff7ed; color:#c2410c; border:1px solid #fed7aa; padding:4px 12px; border-radius:20px; white-space:nowrap; }

        /* Pedido */
        .pc-pedido { border:1px solid #e5e0d8; border-radius:14px; overflow:hidden; margin-bottom:14px; }
        .pc-pedido-head { background:#faf8f5; padding:14px 18px; display:flex; align-items:flex-start; justify-content:space-between; flex-wrap:wrap; gap:10px; border-bottom:1px solid #ede8e0; }
        .pc-pedido-fecha { font-size:.72rem; color:#a8a29e; margin-bottom:3px; }
        .pc-pedido-nombre { font-size:.83rem; color:#57534e; }
        .pc-pedido-total { font-size:1.1rem; font-weight:800; color:#ea580c; }
        .pc-pedido-tags  { display:flex; gap:6px; flex-wrap:wrap; justify-content:flex-end; margin-top:4px; }
        .pc-tag { font-size:.67rem; font-weight:700; padding:3px 10px; border-radius:20px; border:1px solid; }
        .pc-tag-pend { background:#fefce8; color:#a16207; border-color:#fde68a; }
        .pc-tag-env  { background:#eff6ff; color:#1d4ed8; border-color:#bfdbfe; }
        .pc-tag-ent  { background:#f0fdf4; color:#15803d; border-color:#bbf7d0; }
        .pc-tag-del  { background:#eff6ff; color:#1d4ed8; border-color:#bfdbfe; }
        .pc-tag-rec  { background:#f5f3ff; color:#6d28d9; border-color:#ddd6fe; }

        /* Productos */
        .pc-prods { padding:14px 18px; display:flex; flex-direction:column; gap:10px; }
        .pc-prod  { display:flex; align-items:center; gap:12px; background:#faf8f5; border:1px solid #ede8e0; border-radius:10px; padding:10px 12px; }
        .pc-prod img, .pc-prod-ph { width:44px; height:44px; border-radius:8px; flex-shrink:0; object-fit:cover; border:1px solid #e5e0d8; }
        .pc-prod-ph { background:#e7e5e4; display:flex; align-items:center; justify-content:center; font-size:1rem; }
        .pc-prod-name { font-weight:600; font-size:.83rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .pc-prod-meta { font-size:.73rem; color:#78716c; margin-top:2px; }
        .pc-prod-sub  { color:#ea580c; font-weight:700; }

        /* Empty */
        .pc-empty { text-align:center; padding:48px 20px; }
        .pc-empty-cta { display:inline-block; margin-top:16px; background:#ea580c; color:#fff; font-size:.82rem; font-weight:600; padding:10px 22px; border-radius:10px; text-decoration:none; }
        .pc-empty-cta:hover { background:#c2410c; }

        @media(max-width:600px) {
            .pc-wrap { padding:16px 12px 48px; }
            .pc-hero { flex-direction:column; align-items:flex-start; padding:22px 20px; }
            .pc-hero-name { font-size:1.3rem; }
            .pc-grid { grid-template-columns:1fr; }
            .pc-pedido-head { flex-direction:column; }
        }
    </style>
</head>
<body style="background:#f5f3f0; min-height:100vh; font-family:ui-sans-serif,system-ui,-apple-system,sans-serif; color:#1c1917;">

    @include('partials.inicioprincipal.headerclienteinversiones')

    <div class="pc-wrap">

        {{-- Hero --}}
        <div class="pc-hero">
            <div style="position:relative; z-index:1;">
                <div class="pc-hero-label">Tu perfil</div>
                <div class="pc-hero-name">¡Hola, <span>{{ $usuario->nombre_usuario }}</span>!</div>
                <div class="pc-hero-sub">Gestiona tu cuenta y revisa tus compras</div>
            </div>
            <div class="pc-hero-avatar">{{ strtoupper(substr($usuario->nombre_usuario, 0, 1)) }}</div>
        </div>

        {{-- Mis datos --}}
        <div class="pc-card">
            <span class="pc-clabel">Mis datos</span>

            @if($errors->any())
                <div class="pc-err"><ul style="margin:0; padding-left:16px;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
            @endif
            @if(session('success'))
                <div class="pc-ok">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('perfil.update') }}">
                @csrf
                <div class="pc-grid">
                    <div>
                        <label class="pc-flabel">Nombre</label>
                        <input type="text" name="nombre_usuario" value="{{ old('nombre_usuario', $usuario->nombre_usuario) }}" class="pc-input" required>
                    </div>
                    <div>
                        <label class="pc-flabel">Correo</label>
                        <input type="email" name="email" value="{{ old('email', $usuario->email) }}" class="pc-input" required>
                    </div>
                    <div>
                        <label class="pc-flabel">Nueva contraseña</label>
                        <input type="password" name="password" minlength="8" placeholder="••••••••" class="pc-input">
                        <p class="pc-hint">Mín. 8 caracteres — vacío para no cambiar</p>
                    </div>
                    <div>
                        <label class="pc-flabel">Confirmar contraseña</label>
                        <input type="password" name="password_confirmation" minlength="8" placeholder="••••••••" class="pc-input">
                    </div>
                </div>
                <button type="submit" class="pc-btn-save">Guardar cambios</button>
            </form>
        </div>

        {{-- Cerrar sesión --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="pc-btn-logout">Cerrar sesión</button>
        </form>

        {{-- Mis compras --}}
        <div class="pc-card">
            <div class="pc-compras-top">
                <div>
                    <span class="pc-clabel" style="margin-bottom:2px;">Mis compras</span>
                    <p style="font-size:.8rem; color:#a8a29e; margin:0;">Historial de tus pedidos</p>
                </div>
                <span class="pc-notice">🧾 Comprobante entregado con el producto</span>
            </div>

            @if($compras && $compras->count() > 0)
                @foreach($compras as $compra)
                @php
                    $tagEstado = match($compra->estado_pedido) {
                        'enviado'   => 'pc-tag pc-tag-env',
                        'entregado' => 'pc-tag pc-tag-ent',
                        default     => 'pc-tag pc-tag-pend',
                    };
                    $icon = match($compra->estado_pedido) { 'enviado' => '🚚', 'entregado' => '✅', default => '⏳' };
                @endphp
                <div class="pc-pedido">
                    <div class="pc-pedido-head">
                        <div>
                            <p class="pc-pedido-fecha">{{ \Carbon\Carbon::parse($compra->fecha_pedido)->format('d/m/Y') }}</p>
                            <p class="pc-pedido-nombre">A nombre de: <strong>{{ $compra->nombre_cliente }} {{ $compra->apellido_cliente }}</strong></p>
                        </div>
                        <div style="text-align:right;">
                            <p class="pc-pedido-total">S/ {{ number_format($compra->total_pedido, 2) }}</p>
                            <div class="pc-pedido-tags">
                                <span class="{{ $tagEstado }}">{{ $icon }} {{ ucfirst($compra->estado_pedido) }}</span>
                                <span class="pc-tag {{ $compra->recojo_tienda ? 'pc-tag-rec' : 'pc-tag-del' }}">
                                    {{ $compra->recojo_tienda ? '🏪 Recojo' : '🚚 Delivery' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="pc-prods">
                        @foreach($compra->productos as $producto)
                        <div class="pc-prod">
                            @if($producto->imagen)
                                <img src="{{ route('images.products', ['filename' => basename($producto->imagen)]) }}" alt="{{ $producto->nombre_producto }}">
                            @else
                                <div class="pc-prod-ph">📷</div>
                            @endif
                            <div style="flex:1; min-width:0;">
                                <div class="pc-prod-name">{{ $producto->nombre_producto }}</div>
                                <div class="pc-prod-meta">
                                    Cant.: <strong>{{ $producto->cantidad }}</strong> &nbsp;·&nbsp;
                                    Precio: <strong>S/ {{ number_format($producto->precio_unitario, 2) }}</strong> &nbsp;·&nbsp;
                                    <span class="pc-prod-sub">S/ {{ number_format($producto->subtotal, 2) }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            @else
                <div class="pc-empty">
                    <div style="font-size:3rem; margin-bottom:10px;">🛒</div>
                    <p style="font-weight:600; color:#44403c;">No tienes compras aún</p>
                    <p style="font-size:.82rem; color:#a8a29e; margin-top:4px;">Cuando realices tu primera compra, aparecerá aquí.</p>
                    <a href="{{ route('home') }}" class="pc-empty-cta">Comprar ahora</a>
                </div>
            @endif
        </div>

    </div>

    @include('partials.inicioprincipal.footerclienteinversiones')
    <script src="https://unpkg.com/alpinejs" defer></script>
</body>
</html>