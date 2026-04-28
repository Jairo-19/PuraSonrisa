@extends('layouts.admin')

@php
    $ayer   = \Carbon\Carbon::parse($fecha)->subDay()->toDateString();
    $manana = \Carbon\Carbon::parse($fecha)->addDay()->toDateString();

    $PX_H     = 72;          // píxeles por hora
    $PX_MIN   = $PX_H / 60;  // píxeles por minuto
    $HEADER_H = 34;           // altura del encabezado de columna
    $HORAS    = range($HORA_INICIO, $HORA_FIN - 1);

    $qBase = $consultaId ? ['consulta_id' => $consultaId] : [];
@endphp

@section('titulo', 'Agenda')
@section('subtitulo', $fechaLabel)

@section('acciones')
<div class="flex items-center gap-4 flex-wrap">

    <!-- Desplegable de filtro por sala: al cambiar la selección envía el formulario automáticamente -->
    <form method="GET" action="{{ route('admin.agenda') }}" id="frm-sala">
        <input type="hidden" name="fecha" value="{{ $fecha }}">
        <div class="relative">
            <select name="consulta_id" onchange="document.getElementById('frm-sala').submit()"
                    class="bg-[rgba(255,255,255,.06)] border border-[rgba(255,255,255,.13)]
                           rounded-xl px-3 py-[.45rem] text-[.82rem] text-white outline-none
                           cursor-pointer transition-colors focus:border-[#08beff] min-w-[160px]">
                <option value="">Todas las salas</option>
                @foreach($todasConsultas as $c)
                <option value="{{ $c->id }}" {{ (string)$consultaId === (string)$c->id ? 'selected' : '' }}>
                    {{ $c->nombre }}
                </option>
                @endforeach
            </select>

        </div>
    </form>

    <!-- Separador visual entre el filtro de sala y el selector de vista -->
    <span class="w-px h-5 bg-[rgba(255,255,255,.1)] shrink-0"></span>

    <!-- Botones para alternar entre la vista diaria y la vista mensual -->
    <div class="flex rounded-xl border border-[rgba(255,255,255,.13)] overflow-hidden text-[.8rem]">
        <span class="px-4 py-[.45rem] font-semibold bg-[rgba(8,190,255,.13)] text-[#08beff] select-none">
            <i class="bi bi-calendar-day mr-2"></i>Día
        </span>
        <a href="{{ route('admin.agenda.mes', array_merge(['mes' => \Carbon\Carbon::parse($fecha)->month, 'anio' => \Carbon\Carbon::parse($fecha)->year], $qBase)) }}"
           class="px-4 py-[.45rem] font-medium text-[rgba(255,255,255,.38)]
                  hover:text-white hover:bg-[rgba(255,255,255,.05)] transition-colors no-underline">
            <i class="bi bi-calendar3 mr-2"></i>Mes
        </a>
    </div>

    <!-- Separador visual entre el selector de vista y los controles de navegación -->
    <span class="w-px h-5 bg-[rgba(255,255,255,.1)] shrink-0"></span>

    <!-- Controles de navegación de fecha: botón día anterior, selector de fecha y botón día siguiente -->
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.agenda', array_merge(['fecha' => $ayer], $qBase)) }}"
           class="w-[34px] h-[34px] flex items-center justify-center rounded-xl text-[rgba(255,255,255,.4)]
                  border border-[rgba(255,255,255,.13)] hover:bg-[rgba(255,255,255,.07)]
                  hover:text-white transition-all no-underline">
            <i class="bi bi-chevron-left text-sm"></i>
        </a>

        <form method="GET" action="{{ route('admin.agenda') }}">
            @if($consultaId)
            <input type="hidden" name="consulta_id" value="{{ $consultaId }}">
            @endif
            <input type="date" name="fecha" value="{{ $fecha }}"
                   onchange="this.form.submit()"
                   class="bg-[rgba(255,255,255,.06)] border border-[rgba(255,255,255,.13)] rounded-xl
                          px-3 py-[.45rem] text-[.82rem] text-white outline-none cursor-pointer
                          transition-colors focus:border-[#08beff]">
        </form>

        @if(!$esHoy)
        <a href="{{ route('admin.agenda', $qBase) }}"
           class="inline-flex items-center gap-1.5 px-3 py-[.45rem] rounded-xl text-[.76rem] font-semibold
                  text-[rgba(255,255,255,.45)] border border-[rgba(255,255,255,.13)]
                  hover:bg-[rgba(255,255,255,.07)] hover:text-white transition-all no-underline">
            <i class="bi bi-circle-fill text-[.42rem] text-[#08beff]"></i> Hoy
        </a>
        @endif

        <a href="{{ route('admin.agenda', array_merge(['fecha' => $manana], $qBase)) }}"
           class="w-[34px] h-[34px] flex items-center justify-center rounded-xl text-[rgba(255,255,255,.4)]
                  border border-[rgba(255,255,255,.13)] hover:bg-[rgba(255,255,255,.07)]
                  hover:text-white transition-all no-underline">
            <i class="bi bi-chevron-right text-sm"></i>
        </a>
    </div>

    <!-- Separador y botón de nueva cita -->
    <span class="w-px h-5 bg-[rgba(255,255,255,.1)] shrink-0"></span>

    <a href="{{ route('admin.citas.crear', array_merge(['fecha' => $fecha], $qBase)) }}"
       class="inline-flex items-center gap-2 px-[1.1rem] py-[.45rem] bg-[#cc0247] rounded-full
              text-[.78rem] font-semibold text-white no-underline transition-all
              hover:bg-[#a8013b] hover:-translate-y-px active:translate-y-0"
       style="box-shadow:0 0 0 0;" onmouseover="this.style.boxShadow='0 6px 22px rgba(204,2,71,.38)'" onmouseout="this.style.boxShadow='none'">
        <i class="bi bi-calendar-plus-fill"></i>
        Nueva cita
    </a>
</div>
@endsection

@push('styles')
<style>
    /* Altura de cada franja horaria: 72px = 1 hora */
    :root { --ph: 72px; }

    .agenda-grid {
        display: grid;
        min-width: 480px;
    }

    .col-horas {
        border-right: 1px solid rgba(255,255,255,.07);
        position: sticky;
        left: 0;
        background: #08080f;
        z-index: 5;
    }

    .col-sala {
        position: relative;
        border-right: 1px solid rgba(255,255,255,.05);
    }
    .col-sala:last-child { border-right: none; }

    .hora-cell {
        height: var(--ph);
        border-top: 1px solid rgba(255,255,255,.05);
        display: flex;
        align-items: flex-start;
        justify-content: flex-end;
        padding: 4px 8px 0 0;
        font-size: .64rem;
        font-weight: 500;
        color: rgba(255,255,255,.26);
        box-sizing: border-box;
    }

    .slot-bg {
        height: var(--ph);
        border-top: 1px solid rgba(255,255,255,.04);
        box-sizing: border-box;
    }
    .slot-bg.par { background: rgba(255,255,255,.013); }

    .cita-block {
        position: absolute;
        left: 4px;
        right: 4px;
        border-radius: 8px;
        padding: 5px 8px;
        font-size: .71rem;
        line-height: 1.35;
        overflow: hidden;
        cursor: pointer;
        transition: filter .15s, transform .15s;
        z-index: 10;
        box-sizing: border-box;
        text-align: left;
        border: none;
        width: calc(100% - 8px);
    }
    .cita-block:hover { filter: brightness(1.18); transform: scaleX(1.025); z-index: 15; }
    .cita-block:focus { outline: 2px solid rgba(255,255,255,.3); outline-offset: 1px; }

    #linea-ahora {
        position: absolute;
        right: 0;
        height: 2px;
        background: #cc0247;
        box-shadow: 0 0 8px rgba(204,2,71,.7);
        z-index: 20;
        pointer-events: none;
    }
    #linea-ahora::before {
        content: '';
        position: absolute;
        left: -4px; top: -4px;
        width: 10px; height: 10px;
        border-radius: 50%;
        background: #cc0247;
    }

    /* Popover */
    #cita-popover {
        position: fixed;
        z-index: 9999;
        background: #12121f;
        border: 1px solid rgba(255,255,255,.13);
        border-radius: 12px;
        padding: 14px 16px;
        width: 248px;
        box-shadow: 0 12px 40px rgba(0,0,0,.65);
        pointer-events: none;
        opacity: 0;
        transform: translateY(6px) scale(.97);
        transition: opacity .15s, transform .15s;
    }
    #cita-popover.visible {
        opacity: 1;
        transform: translateY(0) scale(1);
        pointer-events: auto;
    }
    .pop-row {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: .77rem;
        color: rgba(255,255,255,.58);
        margin-top: 6px;
    }
    .pop-row i  { font-size: .68rem; width: 13px; flex-shrink: 0; }
    .pop-row span { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

    .badge-pendiente  { background: rgba(255,193,7,.15);  color: #ffc107; padding: 2px 8px; border-radius: 99px; }
    .badge-confirmada { background: rgba(8,190,255,.15);  color: #08beff; padding: 2px 8px; border-radius: 99px; }
    .badge-completada { background: rgba(34,197,94,.15);  color: #22c55e; padding: 2px 8px; border-radius: 99px; }
</style>
@endpush

@section('content')

{{-- Flash de éxito (crear/eliminar cita) --}}
@if(session('flash_success'))
<div class="flex items-center gap-3 mb-5 px-5 py-[.85rem] bg-[rgba(8,190,255,.08)] border border-[rgba(8,190,255,.2)] rounded-xl text-[.84rem] text-[#08beff]">
    <i class="bi bi-check-circle-fill text-base shrink-0"></i>
    {{ session('flash_success') }}
</div>
@endif

<!-- Chips de sala: muestra nombre, color y número de citas del día por cada sala visible -->
<div class="flex flex-wrap gap-2 mb-5">
    @forelse($consultas as $consulta)
    <div class="flex items-center gap-2 px-3 py-1.5 rounded-xl border sala-chip-summary"
         data-color="{{ $consulta->color }}">
        <span class="w-2.5 h-2.5 rounded-full shrink-0 sala-chip-dot"></span>
        <span class="text-[.82rem] font-semibold text-white">{{ $consulta->nombre }}</span>
        <span class="ml-1 text-[.67rem] font-semibold px-2 py-0.5 rounded-full sala-chip-badge">
            {{ $consulta->citas->count() }} {{ $consulta->citas->count() === 1 ? 'cita' : 'citas' }}
        </span>
    </div>
    @empty
    <span class="text-[.8rem] text-[rgba(255,255,255,.3)] italic">Sin salas disponibles</span>
    @endforelse
</div>

<!-- Cuadrícula del calendario diario: columna fija de horas más una columna por cada sala -->
<div class="rounded-2xl border border-[rgba(255,255,255,.07)] overflow-x-auto" style="background:#08080f;">
    <div class="relative agenda-grid" data-cols="56px {{ $consultas->count() > 0 ? str_repeat('1fr ', $consultas->count()) : '1fr' }}">

        <!-- Línea roja que marca la hora actual sobre la cuadrícula (solo visible cuando es el día de hoy) -->
        @if($esHoy)
        @php
            $minActual = now()->hour * 60 + now()->minute;
            $minBase   = $HORA_INICIO * 60;
            $minMax    = $HORA_FIN * 60;
            $topAhora  = round(($minActual - $minBase) * $PX_MIN + $HEADER_H);
        @endphp
        @if($minActual >= $minBase && $minActual <= $minMax)
        <div id="linea-ahora" style="top:{{ $topAhora }}px; left:56px;"></div>
        @endif
        @endif

        <!-- Columna fija con las etiquetas de hora, de 08:00 a 20:00, alineada a la izquierda -->
        <div class="col-horas">
            <div style="height:34px;"></div>
            @foreach($HORAS as $h)
            <div class="hora-cell">{{ str_pad($h, 2, '0', STR_PAD_LEFT) }}:00</div>
            @endforeach
        </div>

        <!-- Columna de citas para cada sala: incluye encabezado, franjas de fondo y bloques de cita -->
        @foreach($consultas as $consulta)
        <div class="col-sala" data-color="{{ $consulta->color }}">

            <!-- Encabezado de columna: punto de color y nombre de la sala -->
            <div class="col-sala-header flex items-center justify-center gap-1.5 border-b border-[rgba(255,255,255,.07)]"
                 style="height:34px;">
                <span class="col-sala-hdot w-2 h-2 rounded-full shrink-0"></span>
                <span class="text-[.71rem] font-semibold text-white/65 truncate max-w-[160px]">
                    {{ $consulta->nombre }}
                </span>
            </div>

            <!-- Franjas de fondo alternadas que delimitan visualmente cada hora del día -->
            @foreach($HORAS as $h)
            <div class="slot-bg {{ $h % 2 === 0 ? 'par' : '' }}"></div>
            @endforeach

            <!-- Bloques de cita posicionados absolutamente según hora de inicio y duración en minutos -->
            @foreach($consulta->citas as $cita)
            @php
                $tI     = \Carbon\Carbon::parse($cita->hora_inicio);
                $tF     = \Carbon\Carbon::parse($cita->hora_fin);
                $mI     = $tI->hour * 60 + $tI->minute;
                $mF     = $tF->hour * 60 + $tF->minute;
                $top    = round(($mI - $HORA_INICIO * 60) * $PX_MIN) + $HEADER_H;
                $height = max(round(($mF - $mI) * $PX_MIN), 28);
            @endphp
            <button type="button" class="cita-block"
                    data-nombre="{{ $cita->paciente->nombre }}"
                    data-telefono="{{ $cita->paciente->telefono ?? '—' }}"
                    data-email="{{ $cita->paciente->email }}"
                    data-servicio="{{ $cita->servicio->nombre ?? '—' }}"
                    data-hora="{{ $tI->format('H:i') }}–{{ $tF->format('H:i') }}"
                    data-estado="{{ $cita->estado }}"
                    data-color="{{ $consulta->color }}"
                    data-top="{{ $top }}"
                    data-height="{{ $height }}"
                    data-id="{{ $cita->id }}"
                    data-delete-url="{{ route('admin.citas.destroy', $cita) }}">
                @if($height >= 42)
                <div class="font-bold text-white truncate leading-tight">{{ $cita->paciente->nombre }}</div>
                @endif
                @if($height >= 58)
                <div class="text-white/75 truncate text-[.66rem] mt-0.5">
                    <i class="bi bi-telephone-fill mr-0.5 text-[.6rem]"></i>{{ $cita->paciente->telefono ?? '—' }}
                </div>
                @endif
                @if($height >= 76)
                <div class="text-white/70 truncate text-[.64rem]">
                    <i class="bi bi-envelope-fill mr-0.5 text-[.6rem]"></i>{{ $cita->paciente->email }}
                </div>
                @endif
                <div class="text-white/55 text-[.62rem] {{ $height >= 42 ? 'mt-0.5' : '' }}">
                    {{ $tI->format('H:i') }}–{{ $tF->format('H:i') }}
                </div>
            </button>
            @endforeach

        </div>
        @endforeach

    </div><!-- Fin de la cuadrícula del calendario diario -->
</div>

<!-- Leyenda inferior: identifica el color de cada sala y la línea de hora actual -->
<div class="flex flex-wrap items-center gap-5 mt-4 px-1">
    <span class="text-[.67rem] text-[rgba(255,255,255,.28)] uppercase tracking-widest font-medium">Salas:</span>
    @foreach($todasConsultas as $c)
    <span class="flex items-center gap-1.5 text-[.73rem] text-[rgba(255,255,255,.5)]">
        <span class="w-3 h-3 rounded-sm inline-block leyenda-dot" data-color="{{ $c->color }}"></span>
        {{ $c->nombre }}
    </span>
    @endforeach
    @if($esHoy)
    <span class="flex items-center gap-1.5 text-[.73rem] text-[rgba(255,255,255,.5)]">
        <span class="w-5 h-0.5 rounded inline-block bg-[#cc0247]"></span> Hora actual
    </span>
    @endif
</div>

<!-- Popover de detalle de cita: aparece al hacer clic sobre un bloque y muestra datos del paciente -->
<!-- data-es-hoy="1" indica que es el día de hoy y activa la línea de hora actual -->
<div id="cita-popover" role="tooltip" data-es-hoy="{{ $esHoy ? '1' : '0' }}">
    <div class="flex items-center gap-2 mb-1">
        <span id="pop-dot" class="w-2.5 h-2.5 rounded-full shrink-0"></span>
        <span id="pop-nombre" class="text-[.88rem] font-bold text-white leading-tight"></span>
    </div>
    <div class="pop-row"><i class="bi bi-clock"></i><span id="pop-hora"></span></div>
    <div class="pop-row"><i class="bi bi-scissors"></i><span id="pop-servicio"></span></div>
    <div class="pop-row"><i class="bi bi-telephone"></i><span id="pop-telefono"></span></div>
    <div class="pop-row"><i class="bi bi-envelope"></i><span id="pop-email"></span></div>
    <div class="pop-row mt-1">
        <i class="bi bi-circle-fill text-[.4rem]"></i>
        <span id="pop-estado" class="text-[.73rem] px-2 py-0.5 rounded-full font-semibold capitalize"></span>
    </div>
    <!-- Botón de eliminar la cita -->
    <form id="pop-delete-form" method="POST" class="mt-3">
        @csrf
        @method('DELETE')
        <button type="submit"
                onclick="return confirm('¿Eliminar esta cita? El hueco quedará libre para nuevas reservas.')"
                class="w-full flex items-center justify-center gap-1.5 py-[.55rem] rounded-lg
                       text-[.76rem] font-semibold text-[rgba(255,100,100,.8)]
                       border border-[rgba(204,2,71,.25)] bg-[rgba(204,2,71,.06)]
                       transition-colors hover:bg-[rgba(204,2,71,.15)] hover:text-[#ff6b8a]
                       cursor-pointer">
            <i class="bi bi-trash3"></i> Eliminar cita
        </button>
    </form>
</div>

@endsection

@push('scripts')
<script>
(function () {
    'use strict';

    /* ── Colores dinámicos desde data-attributes ────────────── */
    // Chips de sala en el resumen superior
    document.querySelectorAll('.sala-chip-summary').forEach(function (el) {
        var c = el.dataset.color;
        el.style.background  = c + '14';
        el.style.borderColor = c + '35';
        var dot   = el.querySelector('.sala-chip-dot');
        var badge = el.querySelector('.sala-chip-badge');
        if (dot)   { dot.style.background = c; dot.style.boxShadow = '0 0 6px ' + c + '70'; }
        if (badge) { badge.style.background = c + '22'; badge.style.color = c; }
    });

    // Plantilla de columnas del grid diario
    var agendaGrid = document.querySelector('.agenda-grid[data-cols]');
    if (agendaGrid) agendaGrid.style.gridTemplateColumns = agendaGrid.dataset.cols;

    // Encabezados de columna de sala
    document.querySelectorAll('.col-sala[data-color]').forEach(function (col) {
        var c   = col.dataset.color;
        var hdr = col.querySelector('.col-sala-header');
        var dot = col.querySelector('.col-sala-hdot');
        if (hdr) hdr.style.background = c + '0e';
        if (dot) { dot.style.background = c; dot.style.boxShadow = '0 0 5px ' + c + '80'; }
    });

    // Bloques de cita: posición absoluta y colores
    document.querySelectorAll('.cita-block[data-top]').forEach(function (btn) {
        var c = btn.dataset.color;
        btn.style.top        = btn.dataset.top + 'px';
        btn.style.height     = btn.dataset.height + 'px';
        btn.style.background = c + 'cc';
        btn.style.borderLeft = '3px solid ' + c;
        btn.style.boxShadow  = '0 2px 14px ' + c + '35';
    });

    // Puntos de color en la leyenda inferior
    document.querySelectorAll('.leyenda-dot').forEach(function (el) {
        el.style.background = el.dataset.color;
    });

    /* Constantes de la cuadrícula (sincronizadas con los valores PHP del controlador) */
    var PX_H      = 72;
    var PX_MIN    = PX_H / 60;    /* píxeles por minuto */
    var HEADER_H  = 34;           /* altura del encabezado de columna en píxeles */
    var HORA_INI  = 8 * 60;       /* hora de inicio en minutos desde medianoche */
    var HORA_FIN  = 20 * 60;      /* hora de fin en minutos desde medianoche */
    var ES_HOY    = document.getElementById('cita-popover').dataset.esHoy === '1';

    /* ── Popover ──────────────────────────────────────── */
    var pop       = document.getElementById('cita-popover');
    var popNombre   = document.getElementById('pop-nombre');
    var popHora     = document.getElementById('pop-hora');
    var popServicio = document.getElementById('pop-servicio');
    var popTelefono = document.getElementById('pop-telefono');
    var popEmail    = document.getElementById('pop-email');
    var popEstado   = document.getElementById('pop-estado');
    var popDot      = document.getElementById('pop-dot');
    var popDeleteForm = document.getElementById('pop-delete-form');

    var badges = { pendiente: 'badge-pendiente', confirmada: 'badge-confirmada', completada: 'badge-completada' };

    document.querySelectorAll('.cita-block').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            var d = btn.dataset;

            popNombre.textContent   = d.nombre;
            popHora.textContent     = d.hora;
            popServicio.textContent = d.servicio;
            popTelefono.textContent = d.telefono;
            popEmail.textContent    = d.email;
            popEstado.textContent   = d.estado;
            popDot.style.background = d.color;

            // Actualizar la URL de eliminar para esta cita concreta
            if (popDeleteForm && d.deleteUrl) {
                popDeleteForm.action = d.deleteUrl;
            }

            popEstado.className = '';
            if (badges[d.estado]) popEstado.classList.add(badges[d.estado]);

            var rect = btn.getBoundingClientRect();
            var PW   = 260;
            var left = rect.right + 10;
            var top  = rect.top;

            if (left + PW > window.innerWidth - 10)  left = rect.left - PW - 10;
            if (top + 220  > window.innerHeight)      top  = window.innerHeight - 230;

            pop.style.left = Math.max(6, left) + 'px';
            pop.style.top  = Math.max(6, top)  + 'px';
            pop.classList.add('visible');
        });
    });

    document.addEventListener('click', function () { pop.classList.remove('visible'); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') pop.classList.remove('visible'); });

    /* ── Línea hora actual (refresco 30s) ────────────── */
    var AGENDA = window.AGENDA_CFG || {};
    if (ES_HOY) {
        (function tick() {
            var line = document.getElementById('linea-ahora');
            if (!line) return;
            var n   = new Date();
            var min = n.getHours() * 60 + n.getMinutes();
            if (min >= HORA_INI && min <= HORA_FIN) {
                line.style.top     = Math.round((min - HORA_INI) * PX_MIN + HEADER_H) + 'px';
                line.style.display = 'block';
            } else {
                line.style.display = 'none';
            }
            setTimeout(tick, 30000);
        }());
    }
}());
</script>
@endpush
