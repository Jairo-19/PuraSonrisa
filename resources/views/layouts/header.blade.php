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
            <li>
                <a href="#"
                   class="flex items-center justify-center w-9 h-9 rounded-full border-2 border-gray-300 text-gray-600
                          hover:border-[#cc0247] hover:text-[#cc0247] transition-all duration-300">
                    <i class="bi bi-person text-lg"></i>
                </a>
            </li>
        </ul>
    </nav>


    
</header>