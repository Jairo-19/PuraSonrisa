<header class="flex items-center justify-between px-8 py-4 bg-[#fffbf4] shadow-sm">

<!-- Logo de la web -->
    <a href="{{ route('home') }}">
        <img src="{{ asset('imagenes/LogoPuraSonrisa.webp') }}" alt="Logo de PuraSonrisa" class="h-12 w-auto">
    </a>

    <!-- Navegacion de la web -->
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
                <a href="#"
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
                    Nosotros
                </a>
            </li>
            <li>
                <a href="#"
                   class="relative text-sm font-semibold text-gray-700 pb-1
                          after:absolute after:left-0 after:bottom-0 after:h-[2px] after:w-0
                          after:bg-[#cc0247] after:transition-all after:duration-300
                          hover:after:w-full hover:text-[#cc0247]">
                    Contacto
                </a>
            </li>
        </ul>
    </nav>


    
</header>