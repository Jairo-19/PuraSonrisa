<!-- Cabecera principal. Se incluye en todas las páginas a través de layouts/master.blade.php -->
<header class="flex items-center justify-between px-8 py-4 bg-gray-50 shadow-sm">

    <!-- Logo: enlaza a la página de inicio -->
    <a href="{{ route('home') }}">
        <img src="{{ asset('imagenes/LogoPuraSonrisa.webp') }}" alt="Logo de PuraSonrisa" class="h-12 w-auto">
    </a>

    <!-- Navegación principal: efecto hover con línea rosa que se expande bajo el enlace -->
    <nav>
        <ul class="flex items-center gap-8">
            <li>
                <a href="{{ route('home') }}"
                   class="relative text-sm font-semibold text-gray-700 pb-1
                          after:absolute after:left-0 after:bottom-0 after:h-[2px] after:w-0
                          after:bg-[#cc0247] after:transition-all after:duration-300
                          hover:after:w-full hover:text-[#cc0247]">
                    Inicio
                </a>
            </li>
            <li>
                <a href="{{ route('servicios') }}"
                   class="relative text-sm font-semibold text-gray-700 pb-1
                          after:absolute after:left-0 after:bottom-0 after:h-[2px] after:w-0
                          after:bg-[#cc0247] after:transition-all after:duration-300
                          hover:after:w-full hover:text-[#cc0247]">
                    Servicios
                </a>
            </li>
            <li>
                <a href="#"
                   class="relative text-sm font-semibold text-gray-700 pb-1
                          after:absolute after:left-0 after:bottom-0 after:h-[2px] after:w-0
                          after:bg-[#cc0247] after:transition-all after:duration-300
                          hover:after:w-full hover:text-[#cc0247]">
                    Reserva
                </a>
            </li>
            <li>
                <a href="{{ route('contacto') }}"
                   class="relative text-sm font-semibold text-gray-700 pb-1
                          after:absolute after:left-0 after:bottom-0 after:h-[2px] after:w-0
                          after:bg-[#cc0247] after:transition-all after:duration-300
                          hover:after:w-full hover:text-[#cc0247]">
                    Contacto
                </a>
            </li>
            <!-- Icono de usuario: desplegable si está autenticado, redirige al login si no lo está -->
            <li class="relative" id="user-menu-wrap">

                @auth
                    {{-- Usuario autenticado: botón que abre/cierra el desplegable --}}
                    <button id="user-menu-btn"
                            class="flex items-center justify-center w-9 h-9 rounded-full border-2 border-[#cc0247] text-[#cc0247] transition-all duration-300"
                            aria-haspopup="true" aria-expanded="false">
                        <i class="bi bi-person-fill text-lg"></i>
                    </button>

                    {{-- Desplegable --}}
                    <div id="user-dropdown"
                         class="hidden absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50">

                        {{-- Nombre del usuario --}}
                        <div class="px-4 py-2 border-b border-gray-100">
                            <p class="text-xs text-gray-400 uppercase tracking-widest">Cuenta</p>
                            <p class="text-sm font-semibold text-gray-700 truncate">{{ auth()->user()->nombre ?? auth()->user()->email }}</p>
                        </div>

                        <!-- Cerrar sesión -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-[#cc0247] font-semibold
                                           hover:bg-red-50 transition-colors duration-200 flex items-center gap-2 mt-1">
                                <i class="bi bi-box-arrow-right"></i>
                                Cerrar sesión
                            </button>
                        </form>
                    </div>
                @else
                    {{-- Usuario no autenticado: lleva a la pantalla de carga antes del login --}}
                    <a href="{{ route('login.loading') }}"
                       class="flex items-center justify-center w-9 h-9 rounded-full border-2 border-gray-300 text-gray-600
                              hover:border-[#cc0247] hover:text-[#cc0247] transition-all duration-300">
                        <i class="bi bi-person text-lg"></i>
                    </a>
                @endauth
            </li>
        </ul>
    </nav>

</header>

@auth
<script>
    // Abrir/cerrar el desplegable de usuario
    const btn = document.getElementById('user-menu-btn');
    const dropdown = document.getElementById('user-dropdown');

    btn.addEventListener('click', function (e) {
        e.stopPropagation();
        const isOpen = !dropdown.classList.contains('hidden');
        dropdown.classList.toggle('hidden', isOpen);
        btn.setAttribute('aria-expanded', String(!isOpen));
    });

    // Cerrar al hacer clic fuera
    document.addEventListener('click', function () {
        dropdown.classList.add('hidden');
        btn.setAttribute('aria-expanded', 'false');
    });
</script>
@endauth