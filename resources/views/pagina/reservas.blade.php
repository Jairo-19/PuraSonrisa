@extends('layouts.master')

@section('title', 'Reserva tu Cita | PuraSonrisa')

@section('content')

<style>
    .reservas-hero {
        height: 60vh;
        background-image: url("{{ asset('imagenes/ClinicaDental.jpg') }}");
        background-size: cover;
        background-position: center;
        animation: heroZoom 8s ease-out forwards;
    }
    @keyframes heroZoom {
        from { background-size: 115%; }
        to   { background-size: 100%; }
    }
    .reservas-titulo {
        animation: fadeSlideUp 0.8s ease both;
    }
    @keyframes fadeSlideUp {
        from { opacity: 0; transform: translateY(28px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>

<!-- ═══════════════════════════════════════════════════════════
     HERO
════════════════════════════════════════════════════════════ -->
<section class="relative w-full overflow-hidden reservas-hero">
    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
    <div class="absolute inset-0 flex items-center justify-center">
        <h1 class="text-5xl font-bold text-white drop-shadow-xl tracking-wide text-center leading-tight reservas-titulo">
            Reserva tu <span class="text-[#cc0247]">Cita</span>
        </h1>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     MAPA DE PASOS (step tracker)
════════════════════════════════════════════════════════════ -->
@if(session('flash_success'))
<div class="max-w-2xl mx-auto mt-10 px-4">
    <div class="flex items-center gap-3 px-5 py-4 bg-green-50 border border-green-200 rounded-2xl text-sm text-green-700 font-medium">
        <i class="bi bi-check-circle-fill text-green-500 text-base shrink-0"></i>
        {{ session('flash_success') }}
    </div>
</div>
@endif
<section class="py-14 px-4 mt-20" id="pasos" style="background: #fffbf4;">
    <div class="max-w-2xl mx-auto">

        <!-- Track visual -->
        <div class="relative flex items-center justify-between" id="step-track">

            <!-- Línea de fondo (gris) -->
            <div class="absolute top-5 left-0 right-0 h-[2px] bg-gray-200 z-0"></div>

            <!-- Línea de progreso (rosa, se expande con JS) -->
            <div id="step-line"
                 class="absolute top-5 left-0 h-[2px] bg-[#cc0247] z-0 transition-all duration-500 ease-in-out"
                 style="width: 0%"></div>

            <!-- Paso 1 -->
            <div class="step-item relative z-10 flex flex-col items-center gap-2 w-1/3" data-step="1">
                <div class="step-circle w-10 h-10 rounded-full border-2 flex items-center justify-center font-bold text-sm transition-all duration-300
                            bg-[#cc0247] border-[#cc0247] text-white shadow-[0_0_14px_rgba(204,2,71,.45)]">
                    1
                </div>
                <span class="step-label text-xs font-semibold text-[#cc0247] text-center leading-tight">
                    Elige<br>tu servicio
                </span>
            </div>

            <!-- Paso 2 -->
            <div class="step-item relative z-10 flex flex-col items-center gap-2 w-1/3" data-step="2">
                <div class="step-circle w-10 h-10 rounded-full border-2 flex items-center justify-center font-bold text-sm transition-all duration-300
                            bg-white border-gray-300 text-gray-400">
                    2
                </div>
                <span class="step-label text-xs font-semibold text-gray-400 text-center leading-tight">
                    Fecha<br>y hora
                </span>
            </div>

            <!-- Paso 3 -->
            <div class="step-item relative z-10 flex flex-col items-center gap-2 w-1/3" data-step="3">
                <div class="step-circle w-10 h-10 rounded-full border-2 flex items-center justify-center font-bold text-sm transition-all duration-300
                            bg-white border-gray-300 text-gray-400">
                    3
                </div>
                <span class="step-label text-xs font-semibold text-gray-400 text-center leading-tight">
                    Confirma<br>tu reserva
                </span>
            </div>

        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     CONTENIDO DE CADA PASO
════════════════════════════════════════════════════════════ -->
<div class="pb-32 px-4" id="step-content" style="background: linear-gradient(to bottom, #fffbf4, #D1CBCB);">

    <!-- ── PASO 1: Elige tu servicio ─────────────────────── -->
    <div id="step-1-content" class="max-w-5xl mx-auto pt-2">

        <div class="text-center mb-10">
            <span class="inline-block text-[#08beff] text-xs tracking-[0.3em] uppercase font-semibold mb-3">Paso 1</span>
            <h2 class="text-3xl font-bold text-gray-800">
                ¿Qué servicio <span class="text-[#cc0247]">necesitas?</span>
            </h2>
            <div class="mt-3 w-16 h-1 bg-gradient-to-r from-[#cc0247] to-[#08beff] mx-auto rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
            @foreach($servicios as $servicio)
            <div class="servicio-card relative rounded-2xl overflow-hidden h-56 cursor-pointer
                        border-2 border-transparent
                        shadow-[0_8px_36px_rgba(0,0,0,0.22)]
                        hover:shadow-[0_18px_56px_rgba(0,0,0,0.35)]
                        hover:-translate-y-1.5 transition-all duration-300 group"
                 data-id="{{ $servicio->id }}"
                 data-nombre="{{ $servicio->nombre }}"
                 data-duracion="{{ $servicio->duracion_minutos }}"
                 onclick="seleccionarServicio(this)">

                <!-- Foto -->
                @if($servicio->imagen)
                    <img src="{{ asset('imagenes/' . $servicio->imagen) }}"
                         alt="{{ $servicio->nombre }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                @else
                    <div class="w-full h-full bg-[#fffbf4] flex items-center justify-center">
                        <i class="bi bi-tooth text-5xl text-[#cc0247]/30"></i>
                    </div>
                @endif

                <!-- Nombre: aparece al hover con overlay oscuro -->
                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/50 transition-all duration-300 flex items-end justify-center pb-5 pointer-events-none">
                    <span class="text-white font-bold text-lg opacity-0 group-hover:opacity-100 translate-y-3 group-hover:translate-y-0 transition-all duration-300 drop-shadow-lg px-4 text-center pointer-events-none">
                        {{ $servicio->nombre }}
                    </span>
                </div>

            </div>
            @endforeach
        </div>

    </div>

    <!-- ── PASO 2 ──────────────────────────────────────── -->
    <div id="step-2-content" class="hidden max-w-4xl mx-auto pt-2 px-6">

        <div class="text-center mb-10">
            <span class="inline-block text-[#08beff] text-xs tracking-[0.3em] uppercase font-semibold mb-3">Paso 2</span>
            <h2 class="text-3xl font-bold text-gray-800">
                Elige fecha <span class="text-[#cc0247]">y hora</span>
            </h2>
            <div class="mt-3 w-16 h-1 bg-gradient-to-r from-[#cc0247] to-[#08beff] mx-auto rounded-full"></div>
        </div>

        <!-- Layout 50 / 50 -->
        <div class="flex flex-col lg:flex-row gap-6 items-stretch">

            <!-- ── Mitad izquierda: Calendario ────────── -->
            <div class="cal-card bg-white rounded-3xl shadow-[0_12px_48px_rgba(0,0,0,0.12)] p-7 w-full lg:w-1/2">

                <!-- Cabecera mes -->
                <div class="flex items-center justify-between mb-6">
                    <button id="cal-prev" type="button"
                            class="w-9 h-9 rounded-full flex items-center justify-center text-gray-400 hover:bg-[#cc0247]/10 hover:text-[#cc0247] transition-all disabled:opacity-20 disabled:cursor-not-allowed disabled:hover:bg-transparent disabled:hover:text-gray-400">
                        <i class="bi bi-chevron-left text-sm"></i>
                    </button>
                    <span id="cal-titulo" class="font-bold text-gray-800 text-lg tracking-wide uppercase"></span>
                    <button id="cal-next" type="button"
                            class="w-9 h-9 rounded-full flex items-center justify-center text-gray-400 hover:bg-[#cc0247]/10 hover:text-[#cc0247] transition-all">
                        <i class="bi bi-chevron-right text-sm"></i>
                    </button>
                </div>

                <!-- Días de la semana -->
                <div class="grid grid-cols-7 mb-2">
                    @foreach(['Lu','Ma','Mi','Ju','Vi','Sa','Do'] as $d)
                    <div class="text-center text-[0.68rem] font-semibold text-gray-400 uppercase pb-2">{{ $d }}</div>
                    @endforeach
                </div>

                <!-- Celdas del mes -->
                <div id="cal-grid" class="grid grid-cols-7 gap-y-1 place-items-center"></div>

                <!-- Leyenda -->
                <div class="flex items-center gap-6 mt-6 pt-4 border-t border-gray-100 justify-center">
                    <span class="flex items-center gap-1.5 text-[0.7rem] text-gray-400">
                        <span class="w-3 h-3 rounded-full bg-[#cc0247] inline-block"></span> Seleccionado
                    </span>
                    <span class="flex items-center gap-1.5 text-[0.7rem] text-gray-400">
                        <span class="w-3 h-3 rounded-full border-2 border-[#cc0247] inline-block"></span> Hoy
                    </span>
                    <span class="flex items-center gap-1.5 text-[0.7rem] text-gray-400">
                        <span class="w-3 h-3 rounded-full bg-gray-200 inline-block"></span> No disponible
                    </span>
                </div>
            </div>

            <!-- ── Mitad derecha: Horarios disponibles ── -->
            <div class="w-full lg:w-1/2 bg-white rounded-3xl shadow-[0_12px_48px_rgba(0,0,0,0.12)] p-7 flex flex-col">

                <!-- Encabezado panel -->
                <div class="mb-5">
                    <p class="text-xs font-semibold text-[#08beff] uppercase tracking-[0.25em]">Horarios disponibles</p>
                    <p id="slots-fecha-label" class="text-base font-bold text-gray-700 mt-1 min-h-[1.5rem]"></p>
                </div>

                <!-- Duración del servicio -->
                <div id="slots-duracion-badge" class="hidden mb-4">
                    <span class="inline-flex items-center gap-1.5 text-[0.7rem] font-semibold text-[#cc0247] bg-[#cc0247]/8 px-3 py-1.5 rounded-full">
                        <i class="bi bi-clock"></i>
                        <span id="slots-duracion-label"></span>
                    </span>
                </div>

                <!-- Mensaje selecciona fecha -->
                <div id="slots-placeholder" class="flex flex-1 flex-col items-center justify-center text-gray-300 gap-3">
                    <i class="bi bi-calendar3 text-5xl"></i>
                    <p class="text-sm font-medium text-center">Selecciona un día del calendario<br>para ver los horarios disponibles</p>
                </div>

                <!-- Loading -->
                <div id="slots-loading" class="hidden flex flex-1 items-center justify-center">
                    <div class="w-8 h-8 border-2 border-[#cc0247] border-t-transparent rounded-full animate-spin"></div>
                </div>

                <!-- Sin slots -->
                <div id="slots-empty" class="hidden flex flex-1 flex-col items-center justify-center text-gray-300 gap-3">
                    <i class="bi bi-calendar-x text-5xl"></i>
                    <p class="text-sm font-medium text-center">Sin horarios disponibles.<br>Prueba con otro día.</p>
                </div>

                <!-- Grid de slots -->
                <div id="slots-container" class="hidden">
                    <div id="slots-grid" class="grid grid-cols-3 gap-3"></div>
                </div>

            </div>
        </div>

        <!-- Botón volver -->
        <div class="flex justify-start mt-8">
            <button onclick="goToStep(1)"
                    class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-[#cc0247] transition-colors font-semibold">
                <i class="bi bi-arrow-left"></i> Cambiar servicio
            </button>
        </div>
    </div>

    <div id="step-3-content" class="hidden max-w-lg mx-auto pt-2">

        <div class="text-center mb-10">
            <span class="inline-block text-[#08beff] text-xs tracking-[0.3em] uppercase font-semibold mb-3">Paso 3</span>
            <h2 class="text-3xl font-bold text-gray-800">
                Confirma tu <span class="text-[#cc0247]">reserva</span>
            </h2>
            <div class="mt-3 w-16 h-1 bg-gradient-to-r from-[#cc0247] to-[#08beff] mx-auto rounded-full"></div>
        </div>

        <!-- Resumen -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-6 flex flex-col gap-4">
            <div class="flex items-center gap-3 border-b border-gray-100 pb-4">
                <div class="w-9 h-9 rounded-full bg-[#cc0247]/10 flex items-center justify-center shrink-0">
                    <i class="bi bi-scissors text-[#cc0247]"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-widest font-semibold">Servicio</p>
                    <p id="resumen-servicio" class="text-gray-800 font-bold text-sm"></p>
                </div>
            </div>
            <div class="flex items-center gap-3 border-b border-gray-100 pb-4">
                <div class="w-9 h-9 rounded-full bg-[#08beff]/10 flex items-center justify-center shrink-0">
                    <i class="bi bi-calendar3 text-[#08beff]"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-widest font-semibold">Fecha</p>
                    <p id="resumen-fecha" class="text-gray-800 font-bold text-sm"></p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-[#cc0247]/10 flex items-center justify-center shrink-0">
                    <i class="bi bi-clock text-[#cc0247]"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-widest font-semibold">Hora</p>
                    <p id="resumen-hora" class="text-gray-800 font-bold text-sm"></p>
                </div>
            </div>
        </div>

        @auth
        <!-- Formulario de confirmación -->
        <form method="POST" action="{{ route('citas.store') }}" id="form-reserva">
            @csrf
            <input type="hidden" name="servicio_id"  id="input-servicio-id">
            <input type="hidden" name="fecha"         id="input-fecha">
            <input type="hidden" name="hora_inicio"   id="input-hora-inicio">
            <input type="hidden" name="hora_fin"      id="input-hora-fin">

            <button type="submit"
                    class="w-full py-3 bg-[#cc0247] hover:bg-[#a8013b] active:bg-[#8c0131] rounded-2xl text-white font-bold text-sm transition-all shadow-[0_4px_18px_rgba(204,2,71,.35)] hover:-translate-y-px">
                <i class="bi bi-check-circle mr-2"></i>Confirmar reserva
            </button>
        </form>
        @else
        <a href="{{ route('login') }}"
           class="w-full flex items-center justify-center gap-2 py-3 bg-[#cc0247] hover:bg-[#a8013b] rounded-2xl text-white font-bold text-sm transition-all shadow-[0_4px_18px_rgba(204,2,71,.35)]">
            <i class="bi bi-box-arrow-in-right"></i> Inicia sesión para confirmar
        </a>
        @endauth

        <!-- Botón volver -->
        <div class="flex justify-start mt-5">
            <button onclick="goToStep(2)"
                    class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-[#cc0247] transition-colors font-semibold">
                <i class="bi bi-arrow-left"></i> Cambiar fecha u hora
            </button>
        </div>
    </div>

</div>

<!-- Datos de configuración para JS -->
<div id="app-config"
     data-auth="{{ auth()->check() ? '1' : '0' }}"
     data-login-url="{{ route('login.loading') }}"
     class="hidden"></div>

@endsection

@push('scripts')
<script>
    const _cfg      = document.getElementById('app-config').dataset;
    const AUTH_USER = _cfg.auth === '1';
    const LOGIN_URL = _cfg.loginUrl;
    /* ═══════════════════════════════════════════════════
       ESTADO GLOBAL
    ═══════════════════════════════════════════════════ */
    const reserva = {
        servicioId: null, servicioNombre: null, servicioDuracion: null,
        fecha: null, horaInicio: null, horaFin: null
    };

    /* ═══════════════════════════════════════════════════
       STEP TRACKER
    ═══════════════════════════════════════════════════ */
    const TOTAL_STEPS = 3;
    let currentStep = 1;

    function goToStep(step) {
        if (step < 1 || step > TOTAL_STEPS) return;
        currentStep = step;
        renderSteps();
        document.getElementById('step-1-content').classList.toggle('hidden', step !== 1);
        document.getElementById('step-2-content').classList.toggle('hidden', step !== 2);
        document.getElementById('step-3-content').classList.toggle('hidden', step !== 3);
        document.getElementById('pasos').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    function renderSteps() {
        document.querySelectorAll('.step-item').forEach(item => {
            const s      = parseInt(item.dataset.step);
            const circle = item.querySelector('.step-circle');
            const label  = item.querySelector('.step-label');
            if (s <= currentStep) {
                circle.className = `step-circle w-10 h-10 rounded-full border-2 flex items-center justify-center font-bold text-sm transition-all duration-300
                    bg-[#cc0247] border-[#cc0247] text-white shadow-[0_0_14px_rgba(204,2,71,.45)]`;
                label.className  = 'step-label text-xs font-semibold text-[#cc0247] text-center leading-tight';
            } else {
                circle.className = `step-circle w-10 h-10 rounded-full border-2 flex items-center justify-center font-bold text-sm transition-all duration-300
                    bg-white border-gray-300 text-gray-400`;
                label.className  = 'step-label text-xs font-semibold text-gray-400 text-center leading-tight';
            }
        });
        const pct = (currentStep - 1) / (TOTAL_STEPS - 1) * 100;
        document.getElementById('step-line').style.width = pct + '%';
    }

    /* ═══════════════════════════════════════════════════
       PASO 1 — SELECCIÓN DE SERVICIO
    ═══════════════════════════════════════════════════ */
    function seleccionarServicio(card) {
        document.querySelectorAll('.servicio-card').forEach(c => {
            c.classList.remove('border-[#cc0247]', 'shadow-[0_0_0_3px_rgba(204,2,71,.25)]');
            c.classList.add('border-transparent');
        });
        card.classList.remove('border-transparent');
        card.classList.add('border-[#cc0247]', 'shadow-[0_0_0_3px_rgba(204,2,71,.25)]');

        reserva.servicioId       = card.dataset.id;
        reserva.servicioNombre   = card.dataset.nombre;
        reserva.servicioDuracion = parseInt(card.dataset.duracion);

        reserva.fecha = null; reserva.horaInicio = null; reserva.horaFin = null;
        resetSlots();
        // Mostrar badge de duración cuando se carguen slots
        const badge = document.getElementById('slots-duracion-badge');
        const label = document.getElementById('slots-duracion-label');
        if (badge && label) {
            label.textContent = `Duración: ${reserva.servicioDuracion} min`;
            badge.classList.remove('hidden');
        }
        setTimeout(() => goToStep(2), 300);
    }

    /* ═══════════════════════════════════════════════════
       PASO 2 — CALENDARIO CUSTOM
    ═══════════════════════════════════════════════════ */
    const MESES = ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
                   'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
    const hoy   = new Date(); hoy.setHours(0,0,0,0);
    let calAno  = hoy.getFullYear();
    let calMes  = hoy.getMonth(); // 0-based

    function renderCalendario() {
        const titulo = document.getElementById('cal-titulo');
        titulo.textContent = `${MESES[calMes]} ${calAno}`;

        const grid = document.getElementById('cal-grid');
        grid.innerHTML = '';

        // Día de la semana del 1º del mes (0=dom → convertir a lun=0)
        const primerDia = new Date(calAno, calMes, 1).getDay();
        const offset    = (primerDia === 0) ? 6 : primerDia - 1;
        const diasMes   = new Date(calAno, calMes + 1, 0).getDate();

        // Celdas vacías iniciales
        for (let i = 0; i < offset; i++) {
            const vacio = document.createElement('div');
            grid.appendChild(vacio);
        }

        // Celdas de días
        for (let d = 1; d <= diasMes; d++) {
            const fecha  = new Date(calAno, calMes, d);
            const btn    = document.createElement('button');
            btn.type     = 'button';
            btn.textContent = d;

            const fechaStr = `${calAno}-${String(calMes+1).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
            btn.dataset.fecha = fechaStr;

            const esHoy       = fecha.getTime() === hoy.getTime();
            const esPasado    = fecha < hoy;
            const esFinde     = fecha.getDay() === 0 || fecha.getDay() === 6;
            const seleccionado = reserva.fecha === fechaStr;

            if (esPasado || esFinde) {
                btn.className = 'cal-dia w-9 h-9 rounded-full text-xs text-gray-300 cursor-not-allowed flex items-center justify-center';
                btn.disabled  = true;
            } else if (seleccionado) {
                btn.className = 'cal-dia w-9 h-9 rounded-full text-xs font-bold bg-[#cc0247] text-white flex items-center justify-center shadow-[0_4px_12px_rgba(204,2,71,.4)] cursor-pointer';
                btn.onclick   = () => elegirFecha(fechaStr);
            } else if (esHoy) {
                btn.className = 'cal-dia w-9 h-9 rounded-full text-xs font-bold border-2 border-[#cc0247] text-[#cc0247] flex items-center justify-center hover:bg-[#cc0247] hover:text-white transition-all cursor-pointer';
                btn.onclick   = () => elegirFecha(fechaStr);
            } else {
                btn.className = 'cal-dia w-9 h-9 rounded-full text-xs text-gray-600 hover:bg-[#fffbf4] hover:text-[#cc0247] transition-all flex items-center justify-center cursor-pointer font-medium';
                btn.onclick   = () => elegirFecha(fechaStr);
            }

            grid.appendChild(btn);
        }
    }

    function elegirFecha(fechaStr) {
        reserva.fecha      = fechaStr;
        reserva.horaInicio = null;
        reserva.horaFin    = null;
        renderCalendario();
        cargarSlots(fechaStr);
    }

    /* ─── Slots ──────────────────────────────────────── */
    function actualizarNavMes() {
        const esActual = calAno === hoy.getFullYear() && calMes === hoy.getMonth();
        document.getElementById('cal-prev').disabled = esActual;
    }

    document.getElementById('cal-prev').addEventListener('click', () => {
        const limite = new Date(hoy.getFullYear(), hoy.getMonth(), 1);
        const actual = new Date(calAno, calMes, 1);
        if (actual <= limite) return;
        calMes--;
        if (calMes < 0) { calMes = 11; calAno--; }
        renderCalendario();
        actualizarNavMes();
    });

    document.getElementById('cal-next').addEventListener('click', () => {
        calMes++;
        if (calMes > 11) { calMes = 0; calAno++; }
        renderCalendario();
        actualizarNavMes();
    });

    /* ─── Slots ──────────────────────────────────────── */
    function resetSlots() {
        document.getElementById('slots-placeholder').classList.remove('hidden');
        document.getElementById('slots-loading').classList.add('hidden');
        document.getElementById('slots-empty').classList.add('hidden');
        document.getElementById('slots-container').classList.add('hidden');
    }

    async function cargarSlots(fecha) {
        document.getElementById('slots-placeholder').classList.add('hidden');
        document.getElementById('slots-container').classList.add('hidden');
        document.getElementById('slots-empty').classList.add('hidden');
        document.getElementById('slots-loading').classList.remove('hidden');

        const url  = `{{ route('reservas.slots') }}?fecha=${fecha}&duracion=${reserva.servicioDuracion}`;
        const res  = await fetch(url);
        const slots = await res.json();

        document.getElementById('slots-loading').classList.add('hidden');

        // Label fecha legible siempre (incluso si no hay slots)
        const [a, m, d] = fecha.split('-');
        document.getElementById('slots-fecha-label').textContent =
            `${parseInt(d)} de ${MESES[parseInt(m)-1].toLowerCase()} de ${a}`;

        const disponibles = slots.filter(s => s.disponible);
        if (disponibles.length === 0) {
            document.getElementById('slots-empty').classList.remove('hidden');
            return;
        }

        const grid = document.getElementById('slots-grid');
        grid.innerHTML = '';

        slots.forEach(slot => {
            const btn = document.createElement('button');
            btn.type  = 'button';
            btn.dataset.inicio = slot.hora_inicio;
            btn.dataset.fin    = slot.hora_fin;

            if (slot.disponible) {
                btn.className = 'slot-btn group relative py-4 px-3 rounded-2xl border-2 border-gray-100 bg-white text-gray-700 text-sm font-bold transition-all duration-200 hover:border-[#cc0247] hover:bg-[#cc0247]/5 hover:text-[#cc0247] cursor-pointer text-center';
                btn.innerHTML = `
                    <span class="block text-lg leading-tight">${slot.hora_inicio}</span>
                    <span class="block text-xs text-gray-400 font-normal mt-0.5 group-hover:text-[#cc0247]/60">hasta ${slot.hora_fin}</span>
                `;
                btn.onclick   = () => seleccionarSlot(btn);
            } else {
                btn.className = 'py-4 px-3 rounded-2xl border-2 border-gray-100 bg-gray-50 text-gray-300 text-sm font-bold cursor-not-allowed text-center';
                btn.innerHTML = `
                    <span class="block text-lg leading-tight line-through">${slot.hora_inicio}</span>
                    <span class="block text-xs text-gray-200 font-normal mt-0.5">ocupado</span>
                `;
                btn.disabled  = true;
            }
            grid.appendChild(btn);
        });

        document.getElementById('slots-container').classList.remove('hidden');
    }

    function seleccionarSlot(btn) {
        document.querySelectorAll('.slot-btn').forEach(b => {
            b.classList.remove('border-[#cc0247]', 'bg-[#cc0247]', 'text-white', '!border-[#cc0247]');
            b.classList.add('border-gray-100', 'bg-white', 'text-gray-700');
            // Restaurar spans
            const spans = b.querySelectorAll('span');
            if (spans[0]) spans[0].classList.remove('text-white');
            if (spans[1]) spans[1].classList.remove('text-white/60');
        });

        btn.classList.remove('border-gray-100', 'bg-white', 'text-gray-700');
        btn.classList.add('border-[#cc0247]', 'bg-[#cc0247]', 'text-white');
        const spans = btn.querySelectorAll('span');
        if (spans[1]) { spans[1].classList.add('text-white/60'); spans[1].classList.remove('text-gray-400'); }

        reserva.horaInicio = btn.dataset.inicio;
        reserva.horaFin    = btn.dataset.fin;

        setTimeout(() => rellenarPaso3(), 250);
    }

    /* ═══════════════════════════════════════════════════
       PASO 3 — RESUMEN
    ═══════════════════════════════════════════════════ */
    function rellenarPaso3() {
        if (!AUTH_USER) {
            // Guardar intención en sessionStorage para retomar tras login
            sessionStorage.setItem('reserva_pendiente', JSON.stringify(reserva));
            window.location.href = LOGIN_URL;
            return;
        }
        const [a, m, d] = reserva.fecha.split('-');
        const fechaLeg  = `${parseInt(d)} de ${MESES[parseInt(m)-1].toLowerCase()} de ${a}`;

        document.getElementById('resumen-servicio').textContent = reserva.servicioNombre;
        document.getElementById('resumen-fecha').textContent    = fechaLeg;
        document.getElementById('resumen-hora').textContent     = `${reserva.horaInicio} – ${reserva.horaFin}`;

        document.getElementById('input-servicio-id').value  = reserva.servicioId;
        document.getElementById('input-fecha').value        = reserva.fecha;
        document.getElementById('input-hora-inicio').value  = reserva.horaInicio;
        document.getElementById('input-hora-fin').value     = reserva.horaFin;

        goToStep(3);
    }

    /* ═══════════════════════════════════════════════════
       INIT
    ═══════════════════════════════════════════════════ */
    renderSteps();
    renderCalendario();
    actualizarNavMes();
</script>
@endpush