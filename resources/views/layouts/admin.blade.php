<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PuraSonrisa — @yield('titulo', 'Panel')</title>

    <link rel="icon" href="{{ asset('imagenes/LogoPuraSonrisaBlanco.webp') }}" type="image/webp">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <style>
        /* No reemplazables con Tailwind */
        body { font-family: 'DM Sans', sans-serif; color-scheme: dark; }

        .logo-img    { filter: drop-shadow(0 0 10px rgba(8,190,255,.35)); }
        .avatar-grad { background: linear-gradient(135deg, #cc0247, #08beff); }

        /* Selects nativos: fondo oscuro + texto legible dentro del popup */
        select {
            color-scheme: dark;
            background-color: #12121f;
            color: #fff;
        }
        select option {
            background-color: #12121f;
            color: #fff;
        }
        select option:checked,
        select option:hover {
            background-color: #1e1e30;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .anim-up { animation: fadeUp .5s ease-out both; }
    </style>

    @stack('styles')
</head>
<body class="min-h-screen flex overflow-hidden bg-[#0d0d14] text-[rgba(255,255,255,.78)]">

<!-- ── Sidebar ──────────────────────────────────────────────── -->
<aside class="w-[260px] min-w-[260px] h-screen bg-[#08080f] border-r border-[rgba(255,255,255,.07)] flex flex-col fixed top-0 left-0 z-[100]">

    <!-- Logo -->
    <div class="flex items-center gap-[.85rem] px-6 py-[1.6rem] border-b border-[rgba(255,255,255,.07)]">
        <img src="{{ asset('imagenes/LogoPuraSonrisaBlanco.webp') }}" alt="Logo" class="w-9 logo-img">
        <span class="font-['Cormorant_Garamond'] text-[1.35rem] font-bold text-white tracking-[.01em]">PuraSonrisa</span>
    </div>

    <!-- Nav -->
    <nav class="flex-1 px-3 py-5 overflow-y-auto">
        <p class="text-[.65rem] font-semibold tracking-[.14em] uppercase text-[rgba(255,255,255,.32)] px-3 pt-2 pb-1 mt-2">Gestión</p>

        <a href="{{ route('admin.usuarios') }}"
           class="flex items-center gap-3 px-[.85rem] py-[.65rem] rounded-[10px] text-[.84rem] font-medium no-underline transition-all cursor-pointer mb-[.15rem]
                  {{ request()->routeIs('admin.usuarios*') ? 'bg-[rgba(8,190,255,.1)] text-[#08beff]' : 'text-[rgba(255,255,255,.32)] hover:bg-[rgba(255,255,255,.05)] hover:text-[rgba(255,255,255,.75)]' }}">
            <i class="bi bi-people text-base shrink-0"></i>
            Usuarios
        </a>

        <a href="{{ route('admin.agenda') }}"
           class="flex items-center gap-3 px-[.85rem] py-[.65rem] rounded-[10px] text-[.84rem] font-medium no-underline transition-all cursor-pointer mb-[.15rem]
                  {{ request()->routeIs('admin.agenda*') ? 'bg-[rgba(8,190,255,.1)] text-[#08beff]' : 'text-[rgba(255,255,255,.32)] hover:bg-[rgba(255,255,255,.05)] hover:text-[rgba(255,255,255,.75)]' }}">
            <i class="bi bi-calendar-check text-base shrink-0"></i>
            Agenda
        </a>

        <a href="{{ route('admin.servicios.index') }}"
           class="flex items-center gap-3 px-[.85rem] py-[.65rem] rounded-[10px] text-[.84rem] font-medium no-underline transition-all cursor-pointer mb-[.15rem]
                  {{ request()->routeIs('admin.servicios*') ? 'bg-[rgba(8,190,255,.1)] text-[#08beff]' : 'text-[rgba(255,255,255,.32)] hover:bg-[rgba(255,255,255,.05)] hover:text-[rgba(255,255,255,.75)]' }}">
            <i class="bi bi-scissors text-base shrink-0"></i>
            Servicios
        </a>

        <a href="{{ route('admin.estadisticas.index') }}"
           class="flex items-center gap-3 px-[.85rem] py-[.65rem] rounded-[10px] text-[.84rem] font-medium no-underline transition-all cursor-pointer mb-[.15rem]
                  {{ request()->routeIs('admin.estadisticas*') ? 'bg-[rgba(8,190,255,.1)] text-[#08beff]' : 'text-[rgba(255,255,255,.32)] hover:bg-[rgba(255,255,255,.05)] hover:text-[rgba(255,255,255,.75)]' }}">
            <i class="bi bi-bar-chart-line text-base shrink-0"></i>
            Estadísticas
        </a>
    </nav>

    <!-- Footer del sidebar: usuario + logout -->
    <div class="px-5 py-4 border-t border-[rgba(255,255,255,.07)]">
        <div class="flex items-center gap-3">
            <div class="w-[34px] h-[34px] rounded-full avatar-grad flex items-center justify-center text-[.78rem] font-bold text-white shrink-0">
                {{ strtoupper(substr(auth()->user()->nombre, 0, 2)) }}
            </div>
            <div class="flex-1 min-w-0">
                <div class="text-[.82rem] font-semibold text-white truncate">{{ auth()->user()->nombre }}</div>
                <div class="text-[.7rem] text-[rgba(255,255,255,.32)] capitalize">{{ auth()->user()->rol }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" title="Cerrar sesión"
                        class="bg-transparent border-0 text-[rgba(255,255,255,.32)] text-base cursor-pointer p-1 transition-colors hover:text-[#cc0247]">
                    <i class="bi bi-box-arrow-right"></i>
                </button>
            </form>
        </div>
    </div>
</aside>

<!-- ── Main ─────────────────────────────────────────────────── -->
<main class="ml-[260px] flex-1 h-screen overflow-y-auto flex flex-col">

    <!-- Top bar -->
    <div class="flex items-center justify-between px-8 py-[1.4rem] border-b border-[rgba(255,255,255,.07)] bg-[#0d0d14] sticky top-0 z-50">
        <div>
            <div class="font-['Cormorant_Garamond'] text-[1.9rem] font-bold text-white leading-none">
                @yield('titulo', 'Panel')
            </div>
            <div class="text-[.8rem] text-[rgba(255,255,255,.32)] mt-[.2rem]">
                @yield('subtitulo')
            </div>
        </div>
        <div class="flex items-center gap-3">
            @yield('acciones')
        </div>
    </div>

    <!-- Contenido de cada vista -->
    <div class="p-8">
        @yield('content')
    </div>

</main>

@stack('scripts')

</body>
</html>
