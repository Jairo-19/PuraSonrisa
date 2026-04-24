<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PuraSonrisa — Panel</title>

    <link rel="icon" href="{{ asset('imagenes/LogoPuraSonrisa.webp') }}" type="image/webp">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --azul:   #08beff;
            --rosa:   #cc0247;
            --oscuro: #0d0d14;
            --sidebar:#08080f;
            --borde:  rgba(255,255,255,.07);
            --texto:  rgba(255,255,255,.78);
            --muted:  rgba(255,255,255,.32);
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--oscuro);
            color: var(--texto);
            min-height: 100vh;
            display: flex;
            overflow: hidden;
        }

        /* ── Sidebar ─────────────────────────────── */
        .sidebar {
            width: 260px;
            min-width: 260px;
            height: 100vh;
            background: var(--sidebar);
            border-right: 1px solid var(--borde);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0;
            z-index: 100;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: .85rem;
            padding: 1.6rem 1.5rem 1.4rem;
            border-bottom: 1px solid var(--borde);
        }
        .sidebar-logo img { width: 36px; filter: drop-shadow(0 0 10px rgba(8,190,255,.35)); }
        .sidebar-logo span {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.35rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: .01em;
        }

        .sidebar-nav {
            flex: 1;
            padding: 1.2rem .75rem;
            overflow-y: auto;
        }

        .nav-label {
            font-size: .65rem;
            font-weight: 600;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: var(--muted);
            padding: .6rem .75rem .4rem;
            margin-top: .5rem;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .65rem .85rem;
            border-radius: 10px;
            font-size: .84rem;
            font-weight: 500;
            color: var(--muted);
            text-decoration: none;
            transition: background .2s, color .2s;
            cursor: pointer;
            margin-bottom: .15rem;
        }
        .nav-item i { font-size: 1rem; flex-shrink: 0; }
        .nav-item:hover { background: rgba(255,255,255,.05); color: rgba(255,255,255,.75); }
        .nav-item.active {
            background: rgba(8,190,255,.1);
            color: var(--azul);
        }
        .nav-item.active i { color: var(--azul); }

        .nav-item.disabled { opacity: .35; pointer-events: none; }

        .sidebar-footer {
            padding: 1rem 1.2rem;
            border-top: 1px solid var(--borde);
        }
        .user-chip {
            display: flex;
            align-items: center;
            gap: .75rem;
        }
        .user-avatar {
            width: 34px; height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--rosa), var(--azul));
            display: flex; align-items: center; justify-content: center;
            font-size: .78rem; font-weight: 700; color: #fff;
            flex-shrink: 0;
        }
        .user-info { flex: 1; min-width: 0; }
        .user-info .u-name {
            font-size: .82rem; font-weight: 600; color: #fff;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .user-info .u-rol {
            font-size: .7rem; color: var(--muted); text-transform: capitalize;
        }
        .btn-logout {
            background: none; border: none;
            color: var(--muted); font-size: 1rem;
            cursor: pointer; padding: .25rem;
            transition: color .2s;
        }
        .btn-logout:hover { color: var(--rosa); }

        /* ── Main ─────────────────────────────────── */
        .main {
            margin-left: 260px;
            flex: 1;
            height: 100vh;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.4rem 2rem;
            border-bottom: 1px solid var(--borde);
            background: var(--oscuro);
            position: sticky; top: 0; z-index: 50;
        }
        .topbar-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.9rem;
            font-weight: 700;
            color: #fff;
            line-height: 1;
        }
        .topbar-subtitle { font-size: .8rem; color: var(--muted); margin-top: .2rem; }
        .topbar-badge {
            display: inline-flex; align-items: center; gap: .5rem;
            padding: .45rem 1rem;
            background: rgba(8,190,255,.08);
            border: 1px solid rgba(8,190,255,.2);
            border-radius: 100px;
            font-size: .78rem; font-weight: 600; color: var(--azul);
        }

        /* ── Content ──────────────────────────────── */
        .content { padding: 2rem; }

        /* ── Cards de resumen ────────────────────── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }
        .stat-card {
            background: rgba(255,255,255,.03);
            border: 1px solid var(--borde);
            border-radius: 14px;
            padding: 1.2rem 1.4rem;
            animation: fadeUp .5s ease-out both;
        }
        .stat-card:nth-child(2) { animation-delay: .08s; }
        .stat-card:nth-child(3) { animation-delay: .16s; }
        .stat-num {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.2rem; font-weight: 700; color: #fff; line-height: 1;
        }
        .stat-lbl { font-size: .75rem; color: var(--muted); margin-top: .3rem; }
        .stat-dot {
            width: 8px; height: 8px; border-radius: 50%;
            display: inline-block; margin-right: .4rem;
        }

        /* ── Tabla ───────────────────────────────── */
        .table-wrap {
            background: rgba(255,255,255,.025);
            border: 1px solid var(--borde);
            border-radius: 16px;
            overflow: hidden;
            animation: fadeUp .5s .1s ease-out both;
        }
        .table-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.2rem 1.5rem;
            border-bottom: 1px solid var(--borde);
        }
        .table-head-title { font-size: .92rem; font-weight: 600; color: #fff; }
        .search-box {
            display: flex; align-items: center; gap: .5rem;
            background: rgba(255,255,255,.05);
            border: 1px solid var(--borde);
            border-radius: 8px;
            padding: .45rem .9rem;
            transition: border-color .2s;
        }
        .search-box:focus-within { border-color: var(--azul); }
        .search-box i { color: var(--muted); font-size: .9rem; }
        .search-box input {
            background: none; border: none; outline: none;
            font-family: 'DM Sans', sans-serif;
            font-size: .82rem; color: #fff;
            width: 180px;
        }
        .search-box input::placeholder { color: var(--muted); }

        table { width: 100%; border-collapse: collapse; }
        thead th {
            padding: .75rem 1.5rem;
            text-align: left;
            font-size: .7rem;
            font-weight: 600;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--muted);
            background: rgba(255,255,255,.02);
            border-bottom: 1px solid var(--borde);
        }
        tbody tr {
            border-bottom: 1px solid rgba(255,255,255,.04);
            transition: background .15s;
        }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: rgba(255,255,255,.03); }
        tbody td {
            padding: .9rem 1.5rem;
            font-size: .84rem;
            color: var(--texto);
            vertical-align: middle;
        }

        .td-user { display: flex; align-items: center; gap: .75rem; }
        .td-avatar {
            width: 32px; height: 32px; border-radius: 50%;
            background: linear-gradient(135deg, var(--rosa), var(--azul));
            display: flex; align-items: center; justify-content: center;
            font-size: .72rem; font-weight: 700; color: #fff; flex-shrink: 0;
        }
        .td-name { font-weight: 500; color: #fff; }
        .td-email { font-size: .76rem; color: var(--muted); }

        .badge-rol {
            display: inline-flex; align-items: center; gap: .35rem;
            padding: .25rem .75rem;
            border-radius: 100px;
            font-size: .72rem; font-weight: 600; text-transform: capitalize;
        }
        .badge-empleado {
            background: rgba(8,190,255,.12);
            color: var(--azul);
            border: 1px solid rgba(8,190,255,.2);
        }
        .badge-cliente {
            background: rgba(204,2,71,.1);
            color: #ff6b8a;
            border: 1px solid rgba(204,2,71,.2);
        }

        .empty-state {
            text-align: center; padding: 4rem 2rem;
            color: var(--muted); font-size: .88rem;
        }
        .empty-state i { font-size: 2.5rem; display: block; margin-bottom: 1rem; opacity: .4; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

{{-- ── Sidebar ──────────────────────────────────────────────── --}}
<aside class="sidebar">
    <div class="sidebar-logo">
        <img src="{{ asset('imagenes/LogoPuraSonrisa.webp') }}" alt="Logo">
        <span>PuraSonrisa</span>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-label">Gestión</div>

        <a href="{{ route('admin.usuarios') }}"
           class="nav-item {{ $seccion === 'usuarios' ? 'active' : '' }}">
            <i class="bi bi-people"></i>
            Usuarios
        </a>

        {{-- Próximas secciones --}}
        <span class="nav-item disabled">
            <i class="bi bi-calendar-check"></i>
            Citas
        </span>
        <span class="nav-item disabled">
            <i class="bi bi-folder2-open"></i>
            Historiales
        </span>
        <span class="nav-item disabled">
            <i class="bi bi-scissors"></i>
            Servicios
        </span>
    </nav>

    <div class="sidebar-footer">
        <div class="user-chip">
            <div class="user-avatar">
                {{ strtoupper(substr(auth()->user()->nombre, 0, 2)) }}
            </div>
            <div class="user-info">
                <div class="u-name">{{ auth()->user()->nombre }}</div>
                <div class="u-rol">{{ auth()->user()->rol }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout" title="Cerrar sesión">
                    <i class="bi bi-box-arrow-right"></i>
                </button>
            </form>
        </div>
    </div>
</aside>

{{-- ── Main ─────────────────────────────────────────────────── --}}
<main class="main">

    {{-- Top bar --}}
    <div class="topbar">
        <div>
            <div class="topbar-title">Usuarios</div>
            <div class="topbar-subtitle">Gestión de clientes y empleados</div>
        </div>
        <div class="topbar-badge">
            <i class="bi bi-people-fill"></i>
            {{ $usuarios->count() }} registros
        </div>
    </div>

    <div class="content">

        {{-- Stats --}}
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-num">{{ $usuarios->count() }}</div>
                <div class="stat-lbl">
                    <span class="stat-dot" style="background:#fff;opacity:.5"></span>
                    Total usuarios
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-num">{{ $usuarios->where('rol','cliente')->count() }}</div>
                <div class="stat-lbl">
                    <span class="stat-dot" style="background:var(--rosa)"></span>
                    Clientes
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-num">{{ $usuarios->where('rol','empleado')->count() }}</div>
                <div class="stat-lbl">
                    <span class="stat-dot" style="background:var(--azul)"></span>
                    Empleados
                </div>
            </div>
        </div>

        {{-- Tabla --}}
        <div class="table-wrap">
            <div class="table-head">
                <span class="table-head-title">Todos los usuarios</span>
                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="text" id="search" placeholder="Buscar por nombre o email…">
                </div>
            </div>

            @if($usuarios->isEmpty())
                <div class="empty-state">
                    <i class="bi bi-people"></i>
                    No hay usuarios registrados todavía.
                </div>
            @else
                <table id="tabla-usuarios">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Teléfono</th>
                            <th>Rol</th>
                            <th>Fecha nacimiento</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usuarios as $u)
                        <tr>
                            <td>
                                <div class="td-user">
                                    <div class="td-avatar">
                                        {{ strtoupper(substr($u->nombre, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="td-name">{{ $u->nombre }}</div>
                                        <div class="td-email">{{ $u->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $u->telefono ?? '—' }}</td>
                            <td>
                                <span class="badge-rol {{ $u->rol === 'empleado' ? 'badge-empleado' : 'badge-cliente' }}">
                                    <i class="bi {{ $u->rol === 'empleado' ? 'bi-person-badge' : 'bi-person' }}"></i>
                                    {{ ucfirst($u->rol) }}
                                </span>
                            </td>
                            <td>{{ $u->fecha_nacimiento?->format('d/m/Y') ?? '—' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

    </div>
</main>

<script>
    // Búsqueda en tiempo real sobre la tabla
    document.getElementById('search').addEventListener('input', function () {
        const q = this.value.toLowerCase();
        document.querySelectorAll('#tabla-usuarios tbody tr').forEach(function (row) {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(q) ? '' : 'none';
        });
    });
</script>

</body>
</html>

