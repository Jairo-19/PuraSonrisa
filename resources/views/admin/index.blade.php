<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PuraSonrisa — Panel</title>

    <link rel="icon" href="{{ asset('imagenes/LogoPuraSonrisaBlanco.webp') }}" type="image/webp">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <style>
        /* No reemplazables con Tailwind */
        body { font-family: 'DM Sans', sans-serif; }

        .logo-img    { filter: drop-shadow(0 0 10px rgba(8,190,255,.35)); }
        .avatar-grad { background: linear-gradient(135deg, #cc0247, #08beff); }

        .stat-card:nth-child(2) { animation-delay: .08s; }
        .stat-card:nth-child(3) { animation-delay: .16s; }

        .btn-crear:hover { box-shadow: 0 6px 22px rgba(204,2,71,.38); }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .anim-up  { animation: fadeUp .5s ease-out both; }
        .anim-up2 { animation: fadeUp .5s .1s ease-out both; }
    </style>
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
        <p class="text-[.65rem] font-semibold tracking-[.14em] uppercase text-[rgba(255,255,255,.32)] px-3 pt-2 pb-1 mt-2">Gestion</p>

        <a href="{{ route('admin.usuarios') }}"
           class="flex items-center gap-3 px-[.85rem] py-[.65rem] rounded-[10px] text-[.84rem] font-medium no-underline transition-all cursor-pointer mb-[.15rem] {{ $seccion === 'usuarios' ? 'bg-[rgba(8,190,255,.1)] text-[#08beff]' : 'text-[rgba(255,255,255,.32)] hover:bg-[rgba(255,255,255,.05)] hover:text-[rgba(255,255,255,.75)]' }}">
            <i class="bi bi-people text-base shrink-0"></i>
            Usuarios
        </a>

        @foreach([['bi-calendar-check','Citas'],['bi-folder2-open','Historiales'],['bi-scissors','Servicios']] as [$ico,$lbl])
        <span class="flex items-center gap-3 px-[.85rem] py-[.65rem] rounded-[10px] text-[.84rem] font-medium text-[rgba(255,255,255,.32)] mb-[.15rem] opacity-35 pointer-events-none">
            <i class="bi {{ $ico }} text-base shrink-0"></i> {{ $lbl }}
        </span>
        @endforeach
    </nav>

    <!-- Footer -->
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
                <button type="submit" title="Cerrar sesion"
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
            <div class="font-['Cormorant_Garamond'] text-[1.9rem] font-bold text-white leading-none">Usuarios</div>
            <div class="text-[.8rem] text-[rgba(255,255,255,.32)] mt-[.2rem]">Gestion de clientes y empleados</div>
        </div>
        <div class="flex items-center gap-3">
            <div class="inline-flex items-center gap-2 px-4 py-[.45rem] bg-[rgba(8,190,255,.08)] border border-[rgba(8,190,255,.2)] rounded-full text-[.78rem] font-semibold text-[#08beff]">
                <i class="bi bi-people-fill"></i>
                {{ $usuarios->count() }} registros
            </div>
            <a href="{{ route('admin.usuarios.crear') }}" class="btn-crear inline-flex items-center gap-2 px-[1.1rem] py-[.45rem] bg-[#cc0247] rounded-full text-[.78rem] font-semibold text-white no-underline cursor-pointer transition-all hover:bg-[#a8013b] hover:-translate-y-px active:translate-y-0">
                <i class="bi bi-plus-lg"></i>
                Nuevo cliente
            </a>
        </div>
    </div>

    <div class="p-8">

        <!-- Stats -->
        <div class="grid grid-cols-[repeat(auto-fit,minmax(160px,1fr))] gap-4 mb-8">
            <div class="stat-card anim-up bg-[rgba(255,255,255,.03)] border border-[rgba(255,255,255,.07)] rounded-[14px] p-[1.2rem_1.4rem]">
                <div class="font-['Cormorant_Garamond'] text-[2.2rem] font-bold text-white leading-none">{{ $usuarios->count() }}</div>
                <div class="text-[.75rem] text-[rgba(255,255,255,.32)] mt-[.3rem]">
                    <span class="w-2 h-2 rounded-full inline-block mr-[.4rem] bg-white opacity-50"></span>Total usuarios
                </div>
            </div>
            <div class="stat-card anim-up bg-[rgba(255,255,255,.03)] border border-[rgba(255,255,255,.07)] rounded-[14px] p-[1.2rem_1.4rem]">
                <div class="font-['Cormorant_Garamond'] text-[2.2rem] font-bold text-white leading-none">{{ $usuarios->where('rol','cliente')->count() }}</div>
                <div class="text-[.75rem] text-[rgba(255,255,255,.32)] mt-[.3rem]">
                    <span class="w-2 h-2 rounded-full inline-block mr-[.4rem] bg-[#cc0247]"></span>Clientes
                </div>
            </div>
            <div class="stat-card anim-up bg-[rgba(255,255,255,.03)] border border-[rgba(255,255,255,.07)] rounded-[14px] p-[1.2rem_1.4rem]">
                <div class="font-['Cormorant_Garamond'] text-[2.2rem] font-bold text-white leading-none">{{ $usuarios->where('rol','empleado')->count() }}</div>
                <div class="text-[.75rem] text-[rgba(255,255,255,.32)] mt-[.3rem]">
                    <span class="w-2 h-2 rounded-full inline-block mr-[.4rem] bg-[#08beff]"></span>Empleados
                </div>
            </div>
        </div>

        <!-- Tabla -->
        <div class="anim-up2 bg-[rgba(255,255,255,.025)] border border-[rgba(255,255,255,.07)] rounded-2xl overflow-hidden">

            <div class="flex items-center justify-between px-6 py-[1.2rem] border-b border-[rgba(255,255,255,.07)]">
                <span class="text-[.92rem] font-semibold text-white">Todos los usuarios</span>
                <div class="flex items-center gap-2 bg-[rgba(255,255,255,.05)] border border-[rgba(255,255,255,.07)] rounded-lg px-[.9rem] py-[.45rem] transition-colors focus-within:border-[#08beff]">
                    <i class="bi bi-search text-[rgba(255,255,255,.32)] text-[.9rem]"></i>
                    <input type="text" id="search" placeholder="Buscar por nombre o email"
                           class="bg-transparent border-0 outline-none text-[.82rem] text-white w-[180px] placeholder:text-[rgba(255,255,255,.32)]">
                </div>
            </div>

            @if($usuarios->isEmpty())
                <div class="text-center py-16 px-8 text-[rgba(255,255,255,.32)] text-[.88rem]">
                    <i class="bi bi-people block text-[2.5rem] mb-4 opacity-40"></i>
                    No hay usuarios registrados todavia.
                </div>
            @else
                <table id="tabla-usuarios" class="w-full border-collapse">
                    <thead>
                        <tr>
                            @foreach(['Usuario','Telefono','Rol','Fecha nacimiento',''] as $col)
                            <th class="py-3 px-6 text-left text-[.7rem] font-semibold tracking-[.1em] uppercase text-[rgba(255,255,255,.32)] bg-[rgba(255,255,255,.02)] border-b border-[rgba(255,255,255,.07)]">{{ $col }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usuarios as $u)
                        <tr class="border-b border-[rgba(255,255,255,.04)] last:border-b-0 transition-colors hover:bg-[rgba(255,255,255,.03)]">
                            <td class="py-[.9rem] px-6 text-[.84rem] align-middle">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full avatar-grad flex items-center justify-center text-[.72rem] font-bold text-white shrink-0">
                                        {{ strtoupper(substr($u->nombre, 0, 2)) }}
                                    </div>
                                    <div>
                                        <a href="{{ route('admin.historial.show', $u) }}"
                                           class="font-medium text-white no-underline transition-colors hover:text-[#08beff]">{{ $u->nombre }}</a>
                                        <div class="text-[.76rem] text-[rgba(255,255,255,.32)]">{{ $u->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-[.9rem] px-6 text-[.84rem] text-[rgba(255,255,255,.78)] align-middle">{{ $u->telefono ?? '&mdash;' }}</td>
                            <td class="py-[.9rem] px-6 align-middle">
                                @if($u->rol === 'empleado')
                                    <span class="inline-flex items-center gap-[.35rem] px-3 py-1 rounded-full text-[.72rem] font-semibold bg-[rgba(8,190,255,.12)] text-[#08beff] border border-[rgba(8,190,255,.2)]">
                                        <i class="bi bi-person-badge"></i> Empleado
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-[.35rem] px-3 py-1 rounded-full text-[.72rem] font-semibold bg-[rgba(204,2,71,.1)] text-[#ff6b8a] border border-[rgba(204,2,71,.2)]">
                                        <i class="bi bi-person"></i> Cliente
                                    </span>
                                @endif
                            </td>
                            <td class="py-[.9rem] px-6 text-[.84rem] text-[rgba(255,255,255,.78)] align-middle">{{ $u->fecha_nacimiento?->format('d/m/Y') ?? '&mdash;' }}</td>
                            <td class="py-[.9rem] pr-5 text-right align-middle">
                                <a href="{{ route('admin.usuarios.editar', $u) }}" title="Editar usuario"
                                   class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-[rgba(255,255,255,.32)] transition-all no-underline hover:bg-[rgba(8,190,255,.12)] hover:text-[#08beff]">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

    </div>
</main>

<script>
    document.getElementById('search').addEventListener('input', function () {
        const q = this.value.toLowerCase();
        document.querySelectorAll('#tabla-usuarios tbody tr').forEach(function (row) {
            row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
        });
    });
</script>

</body>
</html>
