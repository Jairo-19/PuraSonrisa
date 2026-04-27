<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PuraSonrisa — Crear cuenta</title>

    <!-- Icono de la pestaña -->
    <link rel="icon" href="{{ asset('imagenes/LogoPuraSonrisaBlanco.webp') }}" type="image/webp">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Animaciones de entrada */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(22px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-up       { animation: fadeUp .7s ease-out both; }
        .animate-fade-up-delay { animation: fadeUp .7s .15s ease-out both; }

        /* Forma organica del blob */
        .blob { border-radius: 60% 40% 55% 45% / 45% 55% 40% 60%; }

        /* Checkmark del checkbox personalizado */
        .custom-check:checked::after {
            content: '';
            position: absolute;
            left: 4px; top: 1px;
            width: 5px; height: 9px;
            border: 2px solid #fff;
            border-top: none; border-left: none;
            transform: rotate(40deg);
        }

        /* Scrollbar del panel derecho */
        .scroll-panel::-webkit-scrollbar { width: 4px; }
        .scroll-panel::-webkit-scrollbar-track { background: transparent; }
        .scroll-panel::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 4px; }
        .scroll-panel::-webkit-scrollbar-thumb:hover { background: rgba(8,190,255,0.3); }
    </style>
</head>
<!-- Fondo oscuro, layout split horizontal -->
<body class="flex h-screen overflow-hidden" style="background-color:#0d0d14; font-family:'DM Sans',sans-serif;">

    <!-- Panel izquierdo: fijo en pantalla -->
    <div class="hidden md:flex relative w-[38%] h-screen flex-col items-center justify-center px-14 py-12 overflow-hidden border-r border-white/[0.07] shrink-0">

        <!-- Blob azul central -->
        <div class="blob absolute w-[400px] h-[400px] blur-[90px] opacity-[0.16] pointer-events-none"
             style="background:#08beff; top:50%; left:50%; transform:translate(-50%,-50%);"></div>

        <!-- Blob rosa esquina inferior -->
        <div class="blob absolute w-[220px] h-[220px] blur-[80px] opacity-[0.14] pointer-events-none"
             style="background:#cc0247; bottom:2%; left:-4%;"></div>

        <!-- Contenido del panel izquierdo -->
        <div class="relative z-10 text-center animate-fade-up">

            <h2 class="text-[2.6rem] font-bold text-white leading-[1.1] mb-4"
                style="font-family:'Cormorant Garamond',serif;">
                Tu sonrisa,<br>nuestra misión
            </h2>

            <p class="text-[0.9rem] text-white/45 leading-relaxed max-w-[250px] mx-auto mb-10">
                Crea tu cuenta y gestiona tus citas, historial clínico y mucho más desde un solo lugar.
            </p>

            <!-- Lista de beneficios -->
            <ul class="text-left space-y-3 max-w-[230px] mx-auto mb-10">
                <li class="flex items-center gap-3 text-[0.84rem] text-white/50">
                    <span class="w-6 h-6 rounded-full flex items-center justify-center shrink-0 text-[0.7rem]"
                          style="background:rgba(8,190,255,0.15); color:#08beff;">
                        <i class="bi bi-calendar-check"></i>
                    </span>
                    Gestiona tus citas fácilmente
                </li>
                <li class="flex items-center gap-3 text-[0.84rem] text-white/50">
                    <span class="w-6 h-6 rounded-full flex items-center justify-center shrink-0 text-[0.7rem]"
                          style="background:rgba(8,190,255,0.15); color:#08beff;">
                        <i class="bi bi-file-medical"></i>
                    </span>
                    Accede a tu historial clínico
                </li>
                <li class="flex items-center gap-3 text-[0.84rem] text-white/50">
                    <span class="w-6 h-6 rounded-full flex items-center justify-center shrink-0 text-[0.7rem]"
                          style="background:rgba(8,190,255,0.15); color:#08beff;">
                        <i class="bi bi-shield-check"></i>
                    </span>
                    Tus datos siempre protegidos
                </li>
            </ul>

            <!-- Enlace volver al login -->
            <a href="{{ route('login.loading') }}"
               class="inline-flex items-center gap-2 text-[0.78rem] text-white/30 no-underline
                      hover:text-[#cc0247] transition-colors duration-300">
                <i class="bi bi-arrow-left"></i>
                Ya tengo cuenta
            </a>

        </div>
    </div>

    <!-- Panel derecho: scrollable con todos los campos -->
    <div class="flex-1 h-screen overflow-y-auto scroll-panel">
        <div class="flex justify-center px-8 py-12">
        <div class="relative z-10 w-full max-w-[540px] animate-fade-up-delay">

            <!-- Blob decorativo esquina -->
            <div class="blob absolute w-[300px] h-[300px] blur-[90px] opacity-[0.13] pointer-events-none -z-10"
                 style="background:#cc0247; top:-8%; right:-10%;"></div>

            <h1 class="text-[3.2rem] font-bold text-white leading-none mb-1"
                style="font-family:'Cormorant Garamond',serif;">
                Crear cuenta
            </h1>
            <p class="text-[0.88rem] text-white/40 mb-8">Completa tus datos para registrarte</p>

            <!-- Errores de validacion de Laravel -->
            @if ($errors->any())
                <div class="bg-[#cc0247]/10 border border-[#cc0247]/25 rounded-xl px-4 py-3 mb-6">
                    @foreach ($errors->all() as $error)
                        <p class="text-[0.82rem] text-[#ff6b8a]">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('registro.submit') }}">
                @csrf

                <!-- Seccion: datos personales -->
                <p class="text-[0.7rem] font-semibold tracking-[0.15em] uppercase text-white/30 mb-3">
                    Datos personales
                </p>

                <!-- Nombre completo -->
                <div class="relative mb-4 group">
                    <i class="bi bi-person absolute left-4 top-1/2 -translate-y-1/2 text-white/20 text-base pointer-events-none transition-colors duration-300 group-focus-within:text-[#08beff]"></i>
                    <input type="text" name="nombre" placeholder="Nombre completo"
                           value="{{ old('nombre') }}" autocomplete="name" required
                           class="w-full bg-white/5 border border-white/[0.07] rounded-xl
                                  py-[0.9rem] pl-12 pr-4 text-[0.9rem] text-white
                                  placeholder:text-white/25 outline-none
                                  focus:border-[#08beff] focus:bg-[#08beff]/[0.06] focus:ring-2 focus:ring-[#08beff]/20
                                  transition-all duration-300">
                </div>

                <!-- DNI y Teléfono en fila -->
                <div class="grid grid-cols-2 gap-3 mb-4">

                    <!-- DNI -->
                    <div class="relative group">
                        <i class="bi bi-card-text absolute left-4 top-1/2 -translate-y-1/2 text-white/20 text-base pointer-events-none transition-colors duration-300 group-focus-within:text-[#08beff]"></i>
                        <input type="text" name="dni" placeholder="DNI / NIE"
                               value="{{ old('dni') }}" autocomplete="off" maxlength="9"
                               style="text-transform:uppercase"
                               class="w-full bg-white/5 border border-white/[0.07] rounded-xl
                                      py-[0.9rem] pl-12 pr-4 text-[0.9rem] text-white
                                      placeholder:text-white/25 outline-none
                                      focus:border-[#08beff] focus:bg-[#08beff]/[0.06] focus:ring-2 focus:ring-[#08beff]/20
                                      transition-all duration-300">
                    </div>

                    <!-- Teléfono -->
                    <div class="relative group">
                        <i class="bi bi-telephone absolute left-4 top-1/2 -translate-y-1/2 text-white/20 text-base pointer-events-none transition-colors duration-300 group-focus-within:text-[#08beff]"></i>
                        <input type="tel" name="telefono" placeholder="Teléfono"
                               value="{{ old('telefono') }}" autocomplete="tel" maxlength="9"
                               class="w-full bg-white/5 border border-white/[0.07] rounded-xl
                                      py-[0.9rem] pl-12 pr-4 text-[0.9rem] text-white
                                      placeholder:text-white/25 outline-none
                                      focus:border-[#08beff] focus:bg-[#08beff]/[0.06] focus:ring-2 focus:ring-[#08beff]/20
                                      transition-all duration-300">
                    </div>
                </div>

                <!-- Fecha de nacimiento -->
                <div class="relative mb-6 group">
                    <i class="bi bi-calendar3 absolute left-4 top-1/2 -translate-y-1/2 text-white/20 text-base pointer-events-none transition-colors duration-300 group-focus-within:text-[#08beff]"></i>
                    <input type="date" name="fecha_nacimiento"
                           value="{{ old('fecha_nacimiento') }}"
                           min="{{ now()->subYears(120)->toDateString() }}"
                           max="{{ now()->toDateString() }}"
                           class="w-full bg-white/5 border border-white/[0.07] rounded-xl
                                  py-[0.9rem] pl-12 pr-4 text-[0.9rem] text-white/70
                                  outline-none
                                  focus:border-[#08beff] focus:bg-[#08beff]/[0.06] focus:ring-2 focus:ring-[#08beff]/20
                                  transition-all duration-300"
                           style="color-scheme: dark;">
                </div>

                <!-- Separador seccion cuenta -->
                <p class="text-[0.7rem] font-semibold tracking-[0.15em] uppercase text-white/30 mb-3">
                    Acceso a la cuenta
                </p>

                <!-- Correo electronico -->
                <div class="relative mb-4 group">
                    <i class="bi bi-envelope absolute left-4 top-1/2 -translate-y-1/2 text-white/20 text-base pointer-events-none transition-colors duration-300 group-focus-within:text-[#08beff]"></i>
                    <input type="email" name="email" placeholder="Correo electrónico"
                           value="{{ old('email') }}" autocomplete="email" required
                           class="w-full bg-white/5 border border-white/[0.07] rounded-xl
                                  py-[0.9rem] pl-12 pr-4 text-[0.9rem] text-white
                                  placeholder:text-white/25 outline-none
                                  focus:border-[#08beff] focus:bg-[#08beff]/[0.06] focus:ring-2 focus:ring-[#08beff]/20
                                  transition-all duration-300">
                </div>

                <!-- Contraseña y confirmar en fila -->
                <div class="grid grid-cols-2 gap-3 mb-6">

                    <!-- Contraseña -->
                    <div class="relative group">
                        <i class="bi bi-lock absolute left-4 top-1/2 -translate-y-1/2 text-white/20 text-base pointer-events-none transition-colors duration-300 group-focus-within:text-[#08beff]"></i>
                        <input type="password" id="pass-field" name="password"
                               placeholder="Contraseña" autocomplete="new-password" required
                               class="w-full bg-white/5 border border-white/[0.07] rounded-xl
                                      py-[0.9rem] pl-12 pr-10 text-[0.9rem] text-white
                                      placeholder:text-white/25 outline-none
                                      focus:border-[#08beff] focus:bg-[#08beff]/[0.06] focus:ring-2 focus:ring-[#08beff]/20
                                      transition-all duration-300">
                        <!-- Toggle contraseña -->
                        <button type="button" id="toggle-pass" aria-label="Mostrar/ocultar contraseña"
                                class="absolute right-3 top-1/2 -translate-y-1/2 bg-transparent border-none
                                       text-white/20 cursor-pointer text-base p-0
                                       hover:text-[#08beff] transition-colors duration-300">
                            <i class="bi bi-eye" id="eye-icon"></i>
                        </button>
                    </div>

                    <!-- Confirmar contraseña -->
                    <div class="relative group">
                        <i class="bi bi-lock-fill absolute left-4 top-1/2 -translate-y-1/2 text-white/20 text-base pointer-events-none transition-colors duration-300 group-focus-within:text-[#08beff]"></i>
                        <input type="password" id="pass-confirm" name="password_confirmation"
                               placeholder="Confirmar" autocomplete="new-password" required
                               class="w-full bg-white/5 border border-white/[0.07] rounded-xl
                                      py-[0.9rem] pl-12 pr-10 text-[0.9rem] text-white
                                      placeholder:text-white/25 outline-none
                                      focus:border-[#08beff] focus:bg-[#08beff]/[0.06] focus:ring-2 focus:ring-[#08beff]/20
                                      transition-all duration-300">
                        <!-- Toggle confirmar -->
                        <button type="button" id="toggle-confirm" aria-label="Mostrar/ocultar confirmacion"
                                class="absolute right-3 top-1/2 -translate-y-1/2 bg-transparent border-none
                                       text-white/20 cursor-pointer text-base p-0
                                       hover:text-[#08beff] transition-colors duration-300">
                            <i class="bi bi-eye" id="eye-icon-confirm"></i>
                        </button>
                    </div>
                </div>

                <!-- Separador seccion medica -->
                <p class="text-[0.7rem] font-semibold tracking-[0.15em] uppercase text-white/30 mb-3">
                    Información médica <span class="normal-case tracking-normal font-normal opacity-60">(opcional)</span>
                </p>

                <!-- Alergias -->
                <div class="relative mb-4 group">
                    <i class="bi bi-exclamation-triangle absolute left-4 top-4 text-white/20 text-base pointer-events-none transition-colors duration-300 group-focus-within:text-[#08beff]"></i>
                    <textarea name="alergias" rows="2" placeholder="Alergias conocidas (p. ej. penicilina, látex...)"
                              class="w-full bg-white/5 border border-white/[0.07] rounded-xl
                                     py-[0.9rem] pl-12 pr-4 text-[0.9rem] text-white
                                     placeholder:text-white/25 outline-none resize-none
                                     focus:border-[#08beff] focus:bg-[#08beff]/[0.06] focus:ring-2 focus:ring-[#08beff]/20
                                     transition-all duration-300">{{ old('alergias') }}</textarea>
                </div>

                <!-- Condiciones medicas -->
                <div class="relative mb-8 group">
                    <i class="bi bi-heart-pulse absolute left-4 top-4 text-white/20 text-base pointer-events-none transition-colors duration-300 group-focus-within:text-[#08beff]"></i>
                    <textarea name="condiciones_medicas" rows="2" placeholder="Condiciones médicas relevantes (p. ej. diabetes, hipertensión...)"
                              class="w-full bg-white/5 border border-white/[0.07] rounded-xl
                                     py-[0.9rem] pl-12 pr-4 text-[0.9rem] text-white
                                     placeholder:text-white/25 outline-none resize-none
                                     focus:border-[#08beff] focus:bg-[#08beff]/[0.06] focus:ring-2 focus:ring-[#08beff]/20
                                     transition-all duration-300">{{ old('condiciones_medicas') }}</textarea>
                </div>

                <!-- Campo oculto: rol siempre cliente en el registro publico -->
                <input type="hidden" name="rol" value="cliente">

                <!-- Boton registrarse -->
                <button type="submit"
                        class="w-full py-4 bg-[#cc0247] border-0 rounded-xl text-white font-bold
                               text-[0.82rem] tracking-[0.14em] uppercase cursor-pointer
                               transition-all duration-300
                               hover:bg-[#a8013b] hover:shadow-[0_8px_30px_rgba(204,2,71,0.42)] hover:-translate-y-px
                               active:translate-y-0">
                    Crear cuenta
                </button>

                <!-- Enlace al login (en movil donde no se ve el panel izquierdo) -->
                <p class="md:hidden text-center text-[0.82rem] text-white/30 mt-5">
                    ¿Ya tienes cuenta?
                    <a href="{{ route('login.loading') }}"
                       class="text-[#08beff] no-underline hover:underline">Inicia sesión</a>
                </p>

            </form>
        </div>
        </div><!-- /flex justify-center -->
    </div><!-- /scroll-panel -->

    <script>
        // Toggle mostrar/ocultar contraseña principal
        document.getElementById('toggle-pass').addEventListener('click', function () {
            const f = document.getElementById('pass-field');
            const i = document.getElementById('eye-icon');
            const v = f.type === 'password';
            f.type = v ? 'text' : 'password';
            i.className = v ? 'bi bi-eye-slash' : 'bi bi-eye';
        });

        // Toggle mostrar/ocultar confirmacion de contraseña
        document.getElementById('toggle-confirm').addEventListener('click', function () {
            const f = document.getElementById('pass-confirm');
            const i = document.getElementById('eye-icon-confirm');
            const v = f.type === 'password';
            f.type = v ? 'text' : 'password';
            i.className = v ? 'bi bi-eye-slash' : 'bi bi-eye';
        });
    </script>

</body>
</html>