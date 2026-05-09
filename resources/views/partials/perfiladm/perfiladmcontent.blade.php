<style>
  .perfil-root * { box-sizing: border-box; }
  .perfil-root {
    font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    background: #faf8f5;
    min-height: 100vh;
    padding: 36px 24px 60px;
    color: #1c1917;
  }

  /* Fade-up entries */
  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
  }
  .fade-up { animation: fadeUp 0.4s ease both; }
  .fade-up-1 { animation-delay: 0.05s; }
  .fade-up-2 { animation-delay: 0.10s; }
  .fade-up-3 { animation-delay: 0.15s; }
  .fade-up-4 { animation-delay: 0.20s; }
  .fade-up-5 { animation-delay: 0.25s; }

  /* Card base */
  .pcard {
    background: #ffffff;
    border: 1px solid #e8e0d5;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 16px rgba(0,0,0,0.03);
    transition: box-shadow 0.2s;
  }

  /* Header hero */
  .hero-band {
    background: linear-gradient(135deg, #1F2937 0%, #1F2937 45%, #1F2937 100%);
    padding: 28px 32px 24px;
    position: relative;
    overflow: hidden;
  }
  .hero-band::before {
    content: '';
    position: absolute;
    top: -40px; right: -40px;
    width: 180px; height: 180px;
    background: rgba(255,255,255,0.07);
    border-radius: 50%;
  }
  .hero-band::after {
    content: '';
    position: absolute;
    bottom: -60px; right: 60px;
    width: 240px; height: 240px;
    background: rgba(255,255,255,0.05);
    border-radius: 50%;
  }
  .avatar-ring {
    width: 56px; height: 56px;
    background: rgba(255,255,255,0.2);
    border: 2px solid rgba(255,255,255,0.4);
    border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem; font-weight: 700; color: white;
    flex-shrink: 0;
    font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
  }
  .hero-name {
    font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    font-size: 1.35rem; color: white; font-weight: 400; line-height: 1.2;
  }
  .hero-email { font-size: 0.78rem; color: rgba(255,255,255,0.75); margin-top: 2px; }
  .role-pill {
    display: inline-flex; align-items: center;
    background: rgba(255,255,255,0.18);
    border: 1px solid rgba(255,255,255,0.3);
    color: white;
    font-size: 0.68rem; font-weight: 600; letter-spacing: 0.07em;
    text-transform: uppercase;
    padding: 3px 10px; border-radius: 20px; margin-top: 6px;
  }

  /* Section title */
  .section-label {
    font-size: 0.68rem; font-weight: 700; letter-spacing: 0.1em;
    text-transform: uppercase; color: #a16207;
    display: flex; align-items: center; gap: 8px;
    padding: 18px 24px 0;
  }
  .section-label::after {
    content: ''; flex: 1; height: 1px; background: #f3ece2;
  }
  .section-body { padding: 16px 24px 24px; }

  /* Inputs */
  .field-label {
    display: block; font-size: 0.7rem; font-weight: 600;
    color: #78716c; letter-spacing: 0.04em; margin-bottom: 5px;
  }
  .field-input {
    width: 100%;
    border: 1.5px solid #e7ddd4;
    border-radius: 12px;
    padding: 10px 14px;
    font-size: 0.875rem;
    font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    color: #1c1917;
    background: #fdfcfb;
    transition: border-color 0.15s, box-shadow 0.15s;
    outline: none;
  }
  .field-input:focus {
    border-color: #f97316;
    box-shadow: 0 0 0 3px rgba(249,115,22,0.12);
    background: #fff;
  }
  textarea.field-input { resize: vertical; min-height: 80px; }

  /* Buttons */
  .btn {
    display: inline-flex; align-items: center; gap-6px;
    gap: 6px;
    font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    font-size: 0.82rem; font-weight: 600;
    border: none; cursor: pointer;
    border-radius: 12px; padding: 9px 18px;
    transition: all 0.15s; outline: none;
  }
  .btn-orange {
    background: #ea580c; color: white;
    box-shadow: 0 1px 4px rgba(234,88,12,0.3);
  }
  .btn-orange:hover { background: #c2410c; box-shadow: 0 3px 10px rgba(234,88,12,0.35); transform: translateY(-1px); }
  .btn-orange:active { transform: translateY(0); }

  .btn-green {
    background: #16a34a; color: white;
    box-shadow: 0 1px 4px rgba(22,163,74,0.3);
  }
  .btn-green:hover { background: #15803d; box-shadow: 0 3px 10px rgba(22,163,74,0.35); transform: translateY(-1px); }

  .btn-red {
    background: #dc2626; color: white;
    box-shadow: 0 1px 4px rgba(220,38,38,0.25);
  }
  .btn-red:hover { background: #b91c1c; transform: translateY(-1px); }

  .btn-ghost {
    background: transparent; color: #78716c;
    border: 1.5px solid #e7ddd4;
  }
  .btn-ghost:hover { background: #faf8f5; color: #1c1917; }

  .btn-sm { padding: 6px 13px; font-size: 0.76rem; border-radius: 9px; }

  .btn-icon-blue {
    background: #eff6ff; color: #2563eb; border: 1.5px solid #dbeafe;
  }
  .btn-icon-blue:hover { background: #dbeafe; }

  .btn-icon-red {
    background: #fef2f2; color: #dc2626; border: 1.5px solid #fecaca;
  }
  .btn-icon-red:hover { background: #fee2e2; }

  .btn-icon-green {
    background: #f0fdf4; color: #16a34a; border: 1.5px solid #bbf7d0;
  }
  .btn-icon-green:hover { background: #dcfce7; }

  /* Alerts */
  .alert {
    display: flex; align-items: flex-start; gap: 10px;
    padding: 13px 16px; border-radius: 14px;
    font-size: 0.82rem; font-weight: 500;
  }
  .alert-green { background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; }
  .alert-red   { background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; }
  .alert svg   { flex-shrink: 0; margin-top: 1px; }

  /* Rol badges */
  .rbadge {
    display: inline-block; padding: 2px 9px; border-radius: 20px;
    font-size: 0.68rem; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase;
  }
  .rbadge-admin    { background: #fff7ed; color: #c2410c; border: 1px solid #fed7aa; }
  .rbadge-gerente  { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
  .rbadge-vendedor { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
  .rbadge-cajero   { background: #f5f3ff; color: #6d28d9; border: 1px solid #ddd6fe; }

  /* Type badges (avisos) */
  .tbadge-general      { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }
  .tbadge-oferta       { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
  .tbadge-mantenimiento{ background: #fefce8; color: #a16207; border: 1px solid #fde68a; }

  /* Table */
  .ptable { width: 100%; border-collapse: collapse; }
  .ptable thead tr { border-bottom: 2px solid #f3ece2; }
  .ptable th {
    padding: 10px 16px; text-align: left;
    font-size: 0.68rem; font-weight: 700; letter-spacing: 0.08em;
    text-transform: uppercase; color: #a8a29e;
  }
  .ptable tbody tr {
    border-bottom: 1px solid #f5f0eb;
    transition: background 0.12s;
  }
  .ptable tbody tr:hover { background: #fdf9f5; }
  .ptable td { padding: 13px 16px; font-size: 0.84rem; vertical-align: middle; }
  .ptable tbody tr:last-child { border-bottom: none; }

  /* Avatar mini */
  .uavatar {
    width: 32px; height: 32px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.8rem; font-weight: 700; flex-shrink: 0;
    background: #fff7ed; color: #ea580c; border: 1px solid #fed7aa;
    font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
  }

  /* Status dot */
  .sdot {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 0.75rem; font-weight: 500;
  }
  .sdot-on  { color: #16a34a; }
  .sdot-off { color: #a8a29e; }
  .sdot::before {
    content: ''; width: 6px; height: 6px; border-radius: 50%;
  }
  .sdot-on::before  { background: #22c55e; box-shadow: 0 0 0 2px rgba(34,197,94,0.2); }
  .sdot-off::before { background: #d6d3d1; }

  /* Search bar */
  .search-wrap {
    position: relative;
  }
  .search-wrap svg {
    position: absolute; left: 13px; top: 50%; transform: translateY(-50%);
    color: #a8a29e; pointer-events: none;
  }
  .search-input {
    width: 100%; padding: 9px 14px 9px 38px;
    border: 1.5px solid #e7ddd4; border-radius: 12px;
    font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    font-size: 0.84rem; color: #1c1917;
    background: #fdfcfb; outline: none;
    transition: border-color 0.15s, box-shadow 0.15s;
  }
  .search-input:focus {
    border-color: #f97316;
    box-shadow: 0 0 0 3px rgba(249,115,22,0.12);
  }
  .search-input::placeholder { color: #c4b9ad; }

  /* Pagination */
  .pagination { display: flex; align-items: center; gap: 4px; }
  .page-btn {
    min-width: 34px; height: 34px; padding: 0 8px;
    border-radius: 10px; border: 1.5px solid #e7ddd4;
    background: white; cursor: pointer; font-size: 0.82rem;
    font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; font-weight: 500;
    color: #57534e; display: flex; align-items: center; justify-content: center;
    transition: all 0.12s; outline: none;
  }
  .page-btn:hover:not(:disabled) { background: #fff7ed; border-color: #fed7aa; color: #ea580c; }
  .page-btn.active { background: #ea580c; border-color: #ea580c; color: white; font-weight: 600; }
  .page-btn:disabled { opacity: 0.35; cursor: not-allowed; }

  /* Modal */
  .modal-overlay {
    position: fixed; inset: 0;
    background: rgba(28,25,23,0.55);
    backdrop-filter: blur(3px);
    display: flex; align-items: center; justify-content: center;
    z-index: 50; padding: 20px;
  }
  .modal-box {
    background: white; border-radius: 22px;
    width: 100%; max-width: 440px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.2);
    overflow: hidden;
    animation: fadeUp 0.25s ease both;
  }
  .modal-accent-orange { height: 4px; background: linear-gradient(90deg, #ea580c, #fb923c); }
  .modal-accent-green  { height: 4px; background: linear-gradient(90deg, #16a34a, #4ade80); }
  .modal-accent-blue   { height: 4px; background: linear-gradient(90deg, #2563eb, #60a5fa); }
  .modal-head {
    padding: 22px 24px 4px;
    display: flex; align-items: center; justify-content: space-between;
  }
  .modal-title {
    font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    font-size: 1.2rem; color: #1c1917;
  }
  .modal-close {
    width: 30px; height: 30px; border-radius: 8px; border: none;
    background: #f5f0eb; color: #78716c; cursor: pointer; font-size: 1rem;
    display: flex; align-items: center; justify-content: center;
    transition: background 0.12s;
  }
  .modal-close:hover { background: #e7ddd4; }
  .modal-body { padding: 16px 24px 24px; }

  /* No results */
  .empty-state {
    text-align: center; padding: 40px 20px; color: #a8a29e;
  }
  .empty-state svg { margin: 0 auto 12px; opacity: 0.4; }
  .empty-state p { font-size: 0.85rem; }

  /* ── Responsive grids ── */
  .grid-3col  { display: grid; grid-template-columns: repeat(3,1fr); gap: 12px; }
  .grid-2col  { display: grid; grid-template-columns: 1fr 1fr;       gap: 14px; }
  .grid-2col-sm { display: grid; grid-template-columns: 1fr 1fr;     gap: 12px; }

  @media (max-width: 640px) {
    /* Root padding */
    .perfil-root { padding: 16px 12px 48px; }

    /* Cards inner padding */
    .section-body  { padding: 14px 14px 18px; }
    .section-label { padding: 14px 14px 0; }
    .hero-band     { padding: 20px 18px 18px; }

    /* Collapse all grids to 1 column */
    .grid-3col,
    .grid-2col,
    .grid-2col-sm { grid-template-columns: 1fr !important; }

    /* Avisos form: full-width span reset */
    .avisos-form > [style*="grid-column"] { grid-column: 1 !important; }

    /* Table: horizontal scroll already handled by overflow-x:auto wrapper */

    /* Hero name smaller */
    .hero-name  { font-size: 1.1rem; }
    .hero-email { font-size: 0.72rem; }

    /* Modal full-width on small screens */
    .modal-box  { border-radius: 16px; }
    .modal-body { padding: 12px 16px 18px; }
    .modal-head { padding: 16px 16px 4px; }

    /* Password grid inside modals → stack */
    .modal-body .grid-2col-sm { grid-template-columns: 1fr !important; }

    /* Pagination wraps cleanly */
    .pagination { flex-wrap: wrap; }

    /* Toolbar search full-width */
    .search-wrap { min-width: 0 !important; width: 100%; }

    /* Buttons font/padding smaller */
    .btn { font-size: 0.78rem; padding: 8px 14px; }
    .btn-sm { font-size: 0.72rem; padding: 5px 10px; }

    /* Table cells tighter */
    .ptable th, .ptable td { padding: 10px 10px; }
  }

  @media (max-width: 400px) {
    .hero-band { padding: 16px 14px 14px; }
    .avatar-ring { width: 44px; height: 44px; font-size: 1.1rem; border-radius: 12px; }
    .ptable th { font-size: 0.6rem; }
    .ptable td { font-size: 0.78rem; }
  }
</style>

<div class="perfil-root">
<div class="max-w-5xl mx-auto" style="display:flex; flex-direction:column; gap:20px;">

  {{-- ALERTAS --}}
  @if(session('status'))
    <div class="alert alert-green fade-up">
      <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
      {{ session('status') }}
    </div>
  @endif
  @if(session('error'))
    <div class="alert alert-red fade-up">
      <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
      {{ session('error') }}
    </div>
  @endif

  {{-- ══════ HERO CARD ══════ --}}
  <div class="pcard fade-up">
    <div class="hero-band">
      <div style="display:flex; align-items:center; gap:16px; position:relative; z-index:1;">
        <div class="avatar-ring">{{ strtoupper(substr($usuario->nombre_usuario, 0, 1)) }}</div>
        <div>
          <div class="hero-name">{{ $usuario->nombre_usuario }}</div>
          <div class="hero-email">{{ $usuario->email }}</div>
          <div class="role-pill">{{ $usuario->rol }}</div>
        </div>
      </div>
    </div>
    <div style="padding:16px 24px; display:flex; justify-content:flex-end; background:#fffcf9; border-top:1px solid #f3ece2;">
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-red btn-sm" style="gap:6px;">
          <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
          Cerrar sesión
        </button>
      </form>
    </div>
  </div>

  {{-- ══════ VISTA ROL NORMAL ══════ --}}
  @if($usuario->rol !== 'admin')
    <div class="pcard fade-up fade-up-1">
      <div class="section-label">Mis datos</div>
      <div class="section-body">
        <div class="grid-3col">
          <div style="background:#faf8f5; border:1px solid #ece6de; border-radius:12px; padding:12px 16px;">
            <div style="font-size:0.68rem; color:#a8a29e; font-weight:600; text-transform:uppercase; letter-spacing:.06em; margin-bottom:4px;">Nombre</div>
            <div style="font-weight:600; font-size:0.88rem;">{{ $usuario->nombre_usuario }}</div>
          </div>
          <div style="background:#faf8f5; border:1px solid #ece6de; border-radius:12px; padding:12px 16px;">
            <div style="font-size:0.68rem; color:#a8a29e; font-weight:600; text-transform:uppercase; letter-spacing:.06em; margin-bottom:4px;">Correo</div>
            <div style="font-weight:600; font-size:0.88rem;">{{ $usuario->email }}</div>
          </div>
          <div style="background:#faf8f5; border:1px solid #ece6de; border-radius:12px; padding:12px 16px;">
            <div style="font-size:0.68rem; color:#a8a29e; font-weight:600; text-transform:uppercase; letter-spacing:.06em; margin-bottom:4px;">Rol</div>
            <div style="font-weight:600; font-size:0.88rem;">{{ ucfirst($usuario->rol) }}</div>
          </div>
        </div>
      </div>
    </div>
  @endif

  {{-- ══════ ADMIN ══════ --}}
  @if($usuario->rol === 'admin')

    {{-- Editar mis datos --}}
    <div class="pcard fade-up fade-up-1">
      <div class="section-label">Editar mis datos</div>
      <div class="section-body">
        <form method="POST" action="{{ route('perfiladm.perfildeadmn') }}"
              class="grid-2col">
          @csrf
          <div>
            <label class="field-label">Nombre de usuario</label>
            <input type="text" name="nombre_usuario" value="{{ $usuario->nombre_usuario }}" class="field-input">
          </div>
          <div>
            <label class="field-label">Correo electrónico</label>
            <input type="email" name="email" value="{{ $usuario->email }}" class="field-input">
          </div>
          <div style="grid-column:1/-1;">
            <label class="field-label">Nueva contraseña <span style="color:#c4b9ad; font-weight:400;">(dejar vacío para no cambiar)</span></label>
            <input type="password" name="password" placeholder="••••••••" class="field-input">
          </div>
          <div style="grid-column:1/-1; display:flex; justify-content:flex-end;">
            <button type="submit" class="btn btn-orange">
              <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
              Guardar cambios
            </button>
          </div>
        </form>
      </div>
    </div>

    {{-- ══════ AVISOS ══════ --}}
    <div class="pcard fade-up fade-up-2">
      <div class="section-label">Gestión de avisos</div>
      <div class="section-body">

        {{-- Formulario --}}
        <form method="POST" action="{{ route('avisos.store') }}"
              class="avisos-form grid-2col"
              style="background:#fffcf7; border:1px solid #f3e8d4; border-radius:16px; padding:20px; margin-bottom:22px;">
          @csrf
          <div>
            <label class="field-label">Título</label>
            <input type="text" name="titulo" required class="field-input">
          </div>
          <div>
            <label class="field-label">Tipo</label>
            <select name="tipo" class="field-input" style="cursor:pointer;">
              <option value="general">General</option>
              <option value="oferta">Oferta</option>
              <option value="mantenimiento">Mantenimiento</option>
            </select>
          </div>
          <div style="grid-column:1/-1;">
            <label class="field-label">Mensaje</label>
            <textarea name="mensaje" rows="3" required class="field-input"></textarea>
          </div>
          <div style="grid-column:1/-1; display:flex; justify-content:flex-end;">
            <button type="submit" class="btn btn-orange">
              <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
              Publicar aviso
            </button>
          </div>
        </form>

        {{-- Tabla avisos --}}
        @if(isset($avisos) && $avisos->count() > 0)
          <div style="overflow-x:auto; border-radius:14px; border:1px solid #f0e8de;">
            <table class="ptable">
              <thead>
                <tr>
                  <th>Título</th>
                  <th>Mensaje</th>
                  <th>Tipo</th>
                  <th>Fecha</th>
                  <th>Acción</th>
                </tr>
              </thead>
              <tbody>
                @foreach($avisos as $aviso)
                  <tr>
                    <td style="font-weight:600;">{{ $aviso->titulo }}</td>
                    <td style="color:#78716c; max-width:220px;">
                      <span style="display:block; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $aviso->mensaje }}</span>
                    </td>
                    <td>
                      <span class="rbadge tbadge-{{ $aviso->tipo }}">{{ ucfirst($aviso->tipo) }}</span>
                    </td>
                    <td style="color:#a8a29e; font-size:0.78rem; white-space:nowrap;">{{ $aviso->fecha_publicacion }}</td>
                    <td>
                      <form method="POST" action="{{ route('avisos.destroy', $aviso->id_aviso) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-icon-red">
                          <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                          Eliminar
                        </button>
                      </form>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @else
          <div class="empty-state">
            <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
            <p>No hay avisos publicados aún.</p>
          </div>
        @endif
      </div>
    </div>

    {{-- ══════ GESTIÓN DE USUARIOS ══════ --}}
    <div class="pcard fade-up fade-up-3" id="usuarios-section">
      <div class="section-label">Gestión de usuarios</div>
      <div class="section-body">

        {{-- Toolbar: Buscador global + Botón crear --}}
        <div style="display:flex; align-items:center; gap:12px; margin-bottom:18px; flex-wrap:wrap;">
          <div class="search-wrap" style="flex:1; min-width:220px;">
            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" id="userSearch" class="search-input"
                   placeholder="Buscar por nombre, correo o rol…"
                   oninput="filtrarUsuarios()">
          </div>
          <button onclick="openModal('crearUsuarioModal')" class="btn btn-green" style="white-space:nowrap;">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
            Crear usuario
          </button>
        </div>

        {{-- ── TABLA 1: Usuarios con rol (no clientes) ── --}}
        <div style="margin-bottom:28px;">
          <div style="display:flex; align-items:center; gap:8px; margin-bottom:10px;">
            <span style="font-size:0.7rem; font-weight:700; letter-spacing:0.08em; text-transform:uppercase; color:#57534e;">Personal del sistema</span>
            <span id="staffCount" style="background:#fff7ed; color:#ea580c; border:1px solid #fed7aa; font-size:0.65rem; font-weight:700; padding:1px 8px; border-radius:20px;"></span>
          </div>

          <div style="overflow-x:auto; border-radius:14px; border:1px solid #f0e8de;">
            <table class="ptable">
              <thead>
                <tr>
                  <th>Usuario</th>
                  <th>Correo</th>
                  <th>Rol</th>
                  <th>Estado</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody id="staffTableBody">
                @foreach($usuarios as $u)
                  @if($u->rol !== 'cliente')
                    <tr class="staff-row user-row"
                        data-nombre="{{ strtolower($u->nombre_usuario) }}"
                        data-email="{{ strtolower($u->email) }}"
                        data-rol="{{ strtolower($u->rol) }}">
                      <td>
                        <div style="display:flex; align-items:center; gap:10px;">
                          <div class="uavatar">{{ strtoupper(substr($u->nombre_usuario, 0, 1)) }}</div>
                          <div>
                            <div style="font-weight:600; font-size:0.85rem;">{{ $u->nombre_usuario }}</div>
                            <div style="font-size:0.7rem; color:#a8a29e;">#{{ $u->id_usuario }}</div>
                          </div>
                        </div>
                      </td>
                      <td style="color:#78716c; font-size:0.82rem;">{{ $u->email }}</td>
                      <td>
                        <span class="rbadge rbadge-{{ $u->rol }}">{{ ucfirst($u->rol) }}</span>
                      </td>
                      <td>
                        <span class="sdot {{ $u->activo ? 'sdot-on' : 'sdot-off' }}">
                          {{ $u->activo ? 'Activo' : 'Inactivo' }}
                        </span>
                      </td>
                      <td>
                        <div style="display:flex; gap:6px; flex-wrap:wrap;">
                          <button onclick="openModal('editarUsuarioModal-{{ $u->id_usuario }}')"
                                  class="btn btn-sm btn-icon-blue">
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Editar
                          </button>
                          <form method="POST" action="{{ route('usuarios.toggle', $u->id_usuario) }}" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-sm {{ $u->activo ? 'btn-icon-red' : 'btn-icon-green' }}">
                              @if($u->activo)
                                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                Desactivar
                              @else
                                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Activar
                              @endif
                            </button>
                          </form>
                        </div>
                      </td>
                    </tr>

                    {{-- Modal Editar (solo para no-clientes) --}}
                    <div id="editarUsuarioModal-{{ $u->id_usuario }}" class="modal-overlay" style="display:none;">
                      <div class="modal-box">
                        <div class="modal-accent-blue"></div>
                        <div class="modal-head">
                          <div class="modal-title">Editar usuario</div>
                          <button class="modal-close" onclick="closeModal('editarUsuarioModal-{{ $u->id_usuario }}')">✕</button>
                        </div>
                        <div class="modal-body">
                          <form method="POST" action="{{ route('usuarios.update', $u->id_usuario) }}"
                                style="display:flex; flex-direction:column; gap:12px;">
                            @csrf
                            <div>
                              <label class="field-label">Nombre de usuario</label>
                              <input type="text" name="nombre_usuario" value="{{ $u->nombre_usuario }}" required class="field-input">
                            </div>
                            <div>
                              <label class="field-label">Correo electrónico</label>
                              <input type="email" name="email" value="{{ $u->email }}" required class="field-input">
                            </div>
                            <div class="grid-2col-sm">
                              <div>
                                <label class="field-label">Nueva contraseña</label>
                                <input type="password" name="password" placeholder="••••••••" class="field-input">
                              </div>
                              <div>
                                <label class="field-label">Confirmar contraseña</label>
                                <input type="password" name="password_confirmation" placeholder="••••••••" class="field-input">
                              </div>
                            </div>
                            <div>
                              <label class="field-label">Rol</label>
                              <select name="rol" required class="field-input" style="cursor:pointer;">
                                <option value="cajero"   {{ $u->rol=='cajero'   ?'selected':'' }}>Cajero</option>
                                <option value="vendedor" {{ $u->rol=='vendedor' ?'selected':'' }}>Vendedor</option>
                                <option value="gerente"  {{ $u->rol=='gerente'  ?'selected':'' }}>Gerente</option>
                                <option value="admin"    {{ $u->rol=='admin'    ?'selected':'' }}>Admin</option>
                              </select>
                            </div>
                            <label style="display:flex; align-items:center; gap:8px; cursor:pointer; font-size:0.84rem; color:#57534e;">
                              <input type="checkbox" name="activo" style="accent-color:#ea580c; width:15px; height:15px;" {{ $u->activo ? 'checked' : '' }}>
                              Usuario activo
                            </label>
                            <div style="display:flex; justify-content:flex-end; gap:8px; padding-top:4px;">
                              <button type="button" onclick="closeModal('editarUsuarioModal-{{ $u->id_usuario }}')" class="btn btn-ghost btn-sm">Cancelar</button>
                              <button type="submit" class="btn btn-sm" style="background:#2563eb; color:white; box-shadow:0 1px 4px rgba(37,99,235,.3);">Guardar cambios</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  @endif
                @endforeach
              </tbody>
            </table>
          </div>

          {{-- Sin resultados (personal) --}}
          <div id="noResultsStaff" class="empty-state" style="display:none;">
            <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            <p>No se encontró personal con ese criterio.</p>
          </div>

          {{-- Paginación personal --}}
          <div style="display:flex; align-items:center; justify-content:space-between; margin-top:14px; flex-wrap:wrap; gap:10px;">
            <div style="font-size:0.75rem; color:#a8a29e;" id="pageInfoStaff"></div>
            <div class="pagination" id="paginationStaff"></div>
          </div>
        </div>

        {{-- ── TABLA 2: Clientes ── --}}
        <div style="padding-top:20px; border-top:2px dashed #f0e8de;">
          <div style="display:flex; align-items:center; gap:8px; margin-bottom:10px;">
            <span style="font-size:0.7rem; font-weight:700; letter-spacing:0.08em; text-transform:uppercase; color:#57534e;">Clientes</span>
            <span id="clientCount" style="background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0; font-size:0.65rem; font-weight:700; padding:1px 8px; border-radius:20px;"></span>
          </div>

          <div style="overflow-x:auto; border-radius:14px; border:1px solid #f0e8de;">
            <table class="ptable">
              <thead>
                <tr>
                  <th>Cliente</th>
                  <th>Correo</th>
                  <th>Estado</th>
                  <th>Acción</th>
                </tr>
              </thead>
              <tbody id="clientTableBody">
                @foreach($usuarios as $u)
                  @if($u->rol === 'cliente')
                    <tr class="client-row user-row"
                        data-nombre="{{ strtolower($u->nombre_usuario) }}"
                        data-email="{{ strtolower($u->email) }}"
                        data-rol="cliente">
                      <td>
                        <div style="display:flex; align-items:center; gap:10px;">
                          <div class="uavatar" style="background:#f0fdf4; color:#16a34a; border-color:#bbf7d0;">{{ strtoupper(substr($u->nombre_usuario, 0, 1)) }}</div>
                          <div>
                            <div style="font-weight:600; font-size:0.85rem;">{{ $u->nombre_usuario }}</div>
                            <div style="font-size:0.7rem; color:#a8a29e;">#{{ $u->id_usuario }}</div>
                          </div>
                        </div>
                      </td>
                      <td style="color:#78716c; font-size:0.82rem;">{{ $u->email }}</td>
                      <td>
                        <span class="sdot {{ $u->activo ? 'sdot-on' : 'sdot-off' }}">
                          {{ $u->activo ? 'Activo' : 'Inactivo' }}
                        </span>
                      </td>
                      <td>
                        <form method="POST" action="{{ route('usuarios.toggle', $u->id_usuario) }}" style="display:inline;">
                          @csrf
                          <button type="submit" class="btn btn-sm {{ $u->activo ? 'btn-icon-red' : 'btn-icon-green' }}">
                            @if($u->activo)
                              <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                              Desactivar
                            @else
                              <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                              Activar
                            @endif
                          </button>
                        </form>
                      </td>
                    </tr>
                  @endif
                @endforeach
              </tbody>
            </table>
          </div>

          {{-- Sin resultados (clientes) --}}
          <div id="noResultsClient" class="empty-state" style="display:none;">
            <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            <p>No se encontraron clientes con ese criterio.</p>
          </div>

          {{-- Paginación clientes --}}
          <div style="display:flex; align-items:center; justify-content:space-between; margin-top:14px; flex-wrap:wrap; gap:10px;">
            <div style="font-size:0.75rem; color:#a8a29e;" id="pageInfoClient"></div>
            <div class="pagination" id="paginationClient"></div>
          </div>
        </div>

      </div>
    </div>

    {{-- Modal Crear Usuario --}}
    <div id="crearUsuarioModal" class="modal-overlay" style="display:none;">
      <div class="modal-box">
        <div class="modal-accent-green"></div>
        <div class="modal-head">
          <div class="modal-title">Crear nuevo usuario</div>
          <button class="modal-close" onclick="closeModal('crearUsuarioModal')">✕</button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ route('usuarios.store') }}"
                style="display:flex; flex-direction:column; gap:12px;">
            @csrf
            <div>
              <label class="field-label">Nombre de usuario</label>
              <input type="text" name="nombre_usuario" placeholder="Nombre" required class="field-input">
            </div>
            <div>
              <label class="field-label">Correo electrónico</label>
              <input type="email" name="email" placeholder="correo@empresa.com" required class="field-input">
            </div>
            <div class="grid-2col-sm">
              <div>
                <label class="field-label">Contraseña</label>
                <input type="password" name="password" placeholder="••••••••" required class="field-input">
              </div>
              <div>
                <label class="field-label">Confirmar contraseña</label>
                <input type="password" name="password_confirmation" placeholder="••••••••" required class="field-input">
              </div>
            </div>
            <div>
              <label class="field-label">Rol</label>
              <select name="rol" required class="field-input" style="cursor:pointer;">
                <option value="cajero">Cajero</option>
                <option value="vendedor">Vendedor</option>
                <option value="gerente">Gerente</option>
                <option value="admin">Admin</option>
              </select>
            </div>
            <div style="display:flex; justify-content:flex-end; gap:8px; padding-top:4px;">
              <button type="button" onclick="closeModal('crearUsuarioModal')" class="btn btn-ghost btn-sm">Cancelar</button>
              <button type="submit" class="btn btn-green btn-sm">Crear usuario</button>
            </div>
          </form>
        </div>
      </div>
    </div>

  @endif

</div><!-- /max-w -->
</div><!-- /root -->

<script>
/* ─── Modal helpers ─── */
function openModal(id) {
  const el = document.getElementById(id);
  if (el) { el.style.display = 'flex'; document.body.style.overflow = 'hidden'; }
}
function closeModal(id) {
  const el = document.getElementById(id);
  if (el) { el.style.display = 'none'; document.body.style.overflow = ''; }
}
document.addEventListener('click', function(e) {
  if (e.target.classList.contains('modal-overlay')) {
    e.target.style.display = 'none';
    document.body.style.overflow = '';
  }
});

/* ─── Buscador + Paginación dual ─── */
const PER_PAGE = 7;

let staffPage   = 1;
let clientPage  = 1;
let filteredStaff  = [];
let filteredClient = [];

function getStaffRows()  { return Array.from(document.querySelectorAll('.staff-row'));  }
function getClientRows() { return Array.from(document.querySelectorAll('.client-row')); }

function filtrarUsuarios() {
  const q = document.getElementById('userSearch').value.toLowerCase().trim();

  filteredStaff = getStaffRows().filter(row => {
    if (!q) return true;
    return (row.dataset.nombre || '').includes(q)
        || (row.dataset.email  || '').includes(q)
        || (row.dataset.rol    || '').includes(q);
  });

  filteredClient = getClientRows().filter(row => {
    if (!q) return true;
    return (row.dataset.nombre || '').includes(q)
        || (row.dataset.email  || '').includes(q);
  });

  staffPage  = 1;
  clientPage = 1;
  renderTablaStaff();
  renderTablaClient();
}

/* ── Tabla Personal ── */
function renderTablaStaff() {
  const allRows     = getStaffRows();
  const total       = filteredStaff.length;
  const totalPages  = Math.max(1, Math.ceil(total / PER_PAGE));
  if (staffPage > totalPages) staffPage = totalPages;

  const start = (staffPage - 1) * PER_PAGE;
  const end   = start + PER_PAGE;

  allRows.forEach(r => r.style.display = 'none');
  filteredStaff.slice(start, end).forEach(r => r.style.display = '');

  document.getElementById('noResultsStaff').style.display = total === 0 ? 'block' : 'none';

  const badge = document.getElementById('staffCount');
  if (badge) badge.textContent = total === allRows.length
    ? `${allRows.length} usuarios`
    : `${total} resultado${total !== 1 ? 's' : ''}`;

  const pageInfo = document.getElementById('pageInfoStaff');
  if (pageInfo) pageInfo.textContent = total > 0
    ? `Mostrando ${start + 1}–${Math.min(end, total)} de ${total}`
    : '';

  renderPaginacion('paginationStaff', totalPages, staffPage, (p) => { staffPage = p; renderTablaStaff(); });
}

/* ── Tabla Clientes ── */
function renderTablaClient() {
  const allRows    = getClientRows();
  const total      = filteredClient.length;
  const totalPages = Math.max(1, Math.ceil(total / PER_PAGE));
  if (clientPage > totalPages) clientPage = totalPages;

  const start = (clientPage - 1) * PER_PAGE;
  const end   = start + PER_PAGE;

  allRows.forEach(r => r.style.display = 'none');
  filteredClient.slice(start, end).forEach(r => r.style.display = '');

  document.getElementById('noResultsClient').style.display = total === 0 ? 'block' : 'none';

  const badge = document.getElementById('clientCount');
  if (badge) badge.textContent = total === allRows.length
    ? `${allRows.length} clientes`
    : `${total} resultado${total !== 1 ? 's' : ''}`;

  const pageInfo = document.getElementById('pageInfoClient');
  if (pageInfo) pageInfo.textContent = total > 0
    ? `Mostrando ${start + 1}–${Math.min(end, total)} de ${total}`
    : '';

  renderPaginacion('paginationClient', totalPages, clientPage, (p) => { clientPage = p; renderTablaClient(); });
}

/* ── Generador de paginación reutilizable ── */
function renderPaginacion(containerId, totalPages, current, onPageChange) {
  const container = document.getElementById(containerId);
  if (!container) return;
  container.innerHTML = '';
  if (totalPages <= 1) return;

  const prev = document.createElement('button');
  prev.className = 'page-btn';
  prev.innerHTML = '<svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>';
  prev.disabled = current === 1;
  prev.onclick = () => onPageChange(current - 1);
  container.appendChild(prev);

  for (let i = 1; i <= totalPages; i++) {
    if (i === 1 || i === totalPages || (i >= current - 1 && i <= current + 1)) {
      const btn = document.createElement('button');
      btn.className = 'page-btn' + (i === current ? ' active' : '');
      btn.textContent = i;
      btn.onclick = () => onPageChange(i);
      container.appendChild(btn);
    } else if (i === current - 2 || i === current + 2) {
      const dots = document.createElement('span');
      dots.textContent = '…';
      dots.style.cssText = 'padding:0 4px; color:#a8a29e; font-size:0.85rem; line-height:34px;';
      container.appendChild(dots);
    }
  }

  const next = document.createElement('button');
  next.className = 'page-btn';
  next.innerHTML = '<svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>';
  next.disabled = current === totalPages;
  next.onclick = () => onPageChange(current + 1);
  container.appendChild(next);
}

/* ── Init ── */
document.addEventListener('DOMContentLoaded', function() {
  filteredStaff  = getStaffRows();
  filteredClient = getClientRows();
  renderTablaStaff();
  renderTablaClient();
});
</script>