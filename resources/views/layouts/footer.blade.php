<!-- Pie de página global, incluido en todas las páginas a través de layouts/master.blade.php -->
<footer class="bg-gray-900 text-gray-300">

    <!-- Contenido principal del footer dividido en 3 columnas -->
    <div class="max-w-6xl mx-auto px-8 py-16 grid grid-cols-1 md:grid-cols-3 gap-12">

        <!-- Columna 1: Logo y redes sociales -->
        <div class="flex flex-col items-start gap-6">
            <!-- Logo de la clínica -->
            <a href="{{ route('home') }}">
                <img src="{{ asset('imagenes/LogoPuraSonrisaBlanco.webp') }}" alt="Logo PuraSonrisa" class="h-12 w-auto brightness-0 invert">
            </a>
            <p class="text-sm text-gray-400 leading-relaxed">
                Cuidando tu sonrisa con dedicación y los mejores profesionales desde 1999.
            </p>
            <!-- Iconos de redes sociales con borde redondeado -->
            <div class="flex gap-3">
                <a href="#" aria-label="Facebook"
                   class="w-10 h-10 flex items-center justify-center rounded-full border border-gray-600
                          text-gray-400 hover:border-[#cc0247] hover:text-[#cc0247] transition-colors duration-300">
                    <i class="bi bi-facebook text-lg"></i>
                </a>
                <a href="#" aria-label="Instagram"
                   class="w-10 h-10 flex items-center justify-center rounded-full border border-gray-600
                          text-gray-400 hover:border-[#cc0247] hover:text-[#cc0247] transition-colors duration-300">
                    <i class="bi bi-instagram text-lg"></i>
                </a>
                <a href="#" aria-label="X (Twitter)"
                   class="w-10 h-10 flex items-center justify-center rounded-full border border-gray-600
                          text-gray-400 hover:border-[#cc0247] hover:text-[#cc0247] transition-colors duration-300">
                    <i class="bi bi-twitter-x text-lg"></i>
                </a>
                <a href="#" aria-label="YouTube"
                   class="w-10 h-10 flex items-center justify-center rounded-full border border-gray-600
                          text-gray-400 hover:border-[#cc0247] hover:text-[#cc0247] transition-colors duration-300">
                    <i class="bi bi-youtube text-lg"></i>
                </a>
            </div>
        </div>

        <!-- Columna 2: Navegación en columna -->
        <div>
            <h4 class="text-white font-semibold text-sm uppercase tracking-widest mb-6">Navegación</h4>
            <ul class="flex flex-col gap-3">
                <li>
                    <a href="{{ route('home') }}"
                       class="text-gray-400 hover:text-[#cc0247] transition-colors duration-300 text-sm">
                        Inicio
                    </a>
                </li>
                <li>
                    <a href="{{ route('servicios') }}"
                       class="text-gray-400 hover:text-[#cc0247] transition-colors duration-300 text-sm">
                        Servicios
                    </a>
                </li>
                <li>
                    <a href="#"
                       class="text-gray-400 hover:text-[#cc0247] transition-colors duration-300 text-sm">
                        Reserva
                    </a>
                </li>
                <li>
                    <a href="{{ route('contacto') }}"
                       class="text-gray-400 hover:text-[#cc0247] transition-colors duration-300 text-sm">
                        Contacto
                    </a>
                </li>
            </ul>
        </div>

        <!-- Columna 3: Horario de atención -->
        <div>
            <h4 class="text-white font-semibold text-sm uppercase tracking-widest mb-6">Horario</h4>
            <ul class="flex flex-col gap-3 text-sm text-gray-400">
                <li class="flex items-center gap-2">
                    <i class="bi bi-clock text-[#cc0247]"></i>
                    <span>Lunes a Viernes</span>
                </li>
                <li class="flex items-center gap-2 pl-6">
                    <span>9:00 &ndash; 14:00</span>
                </li>
                <li class="flex items-center gap-2 pl-6">
                    <span>16:00 &ndash; 20:00</span>
                </li>
                <li class="mt-2 flex items-center gap-2">
                    <i class="bi bi-calendar-x text-gray-600"></i>
                    <span class="text-gray-500">Sábados y domingos cerrado</span>
                </li>
            </ul>
        </div>

    </div>

    <!-- Franja inferior de copyright -->
    <!-- El date es para mostrar el año actual automáticamente -->
    <div class="border-t border-gray-800 py-5 text-center text-xs text-gray-500">
        &copy; {{ date('Y') }} PuraSonrisa. Todos los derechos reservados.
    </div>

</footer>