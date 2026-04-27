@extends('layouts.admin')

@php
    $mesPrev  = $mes === 1  ? 12 : $mes - 1;
    $anioPrev = $mes === 1  ? $anio - 1 : $anio;
    $mesNext  = $mes === 12 ? 1  : $mes + 1;
    $anioNext = $mes === 12 ? $anio + 1 : $anio;

    $qBase = $consultaId ? ['consulta_id' => $consultaId] : [];

    // Ajuste de primer día: lunes = 0
    $primerDia   = (int) $inicio->dayOfWeek; // 0=dom, 1=lun…6=sab
    $offsetLunes = $primerDia === 0 ? 6 : $primerDia - 1;
    $diasEnMes   = (int) $inicio->daysInMonth;
    $hoy         = now()->toDateString();

    $diasSemana  = ['L', 'M', 'X', 'J', 'V', 'S', 'D'];

    $meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
              'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
@endphp

@section('titulo', 'Agenda')
@section('subtitulo', $mesLabel)

@section('acciones')
<div class="flex items-center gap-4 flex-wrap">

    <!-- Desplegable de filtro por sala: al cambiar la selección envía el formulario automáticamente -->
    <form method="GET" action="{{ route('admin.agenda.mes') }}" id="frm-sala-mes">
        <input type="hidden" name="mes"  value="{{ $mes }}">
        <input type="hidden" name="anio" value="{{ $anio }}">
        <div class="relative">
            <select name="consulta_id" onchange="document.getElementById('frm-sala-mes').submit()"
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
        <a href="{{ route('admin.agenda', array_merge(['fecha' => $hoy], $qBase)) }}"
           class="px-4 py-[.45rem] font-medium text-[rgba(255,255,255,.38)]
                  hover:text-white hover:bg-[rgba(255,255,255,.05)] transition-colors no-underline">
            <i class="bi bi-calendar-day mr-2"></i>Día
        </a>
        <span class="px-4 py-[.45rem] font-semibold bg-[rgba(8,190,255,.13)] text-[#08beff] select-none">
            <i class="bi bi-calendar3 mr-2"></i>Mes
        </span>
    </div>

    <!-- Separador visual entre el selector de vista y los controles de navegación -->
    <span class="w-px h-5 bg-[rgba(255,255,255,.1)] shrink-0"></span>

    <!-- Controles de navegación: botón mes anterior, selectores de mes y año, botón mes siguiente -->
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.agenda.mes', array_merge(['mes' => $mesPrev, 'anio' => $anioPrev], $qBase)) }}"
           class="w-[34px] h-[34px] flex items-center justify-center rounded-xl text-[rgba(255,255,255,.4)]
                  border border-[rgba(255,255,255,.13)] hover:bg-[rgba(255,255,255,.07)]
                  hover:text-white transition-all no-underline">
            <i class="bi bi-chevron-left text-sm"></i>
        </a>

        <form method="GET" action="{{ route('admin.agenda.mes') }}" class="flex gap-1.5">
            @if($consultaId)
            <input type="hidden" name="consulta_id" value="{{ $consultaId }}">
            @endif
            <select name="mes" onchange="this.form.submit()"
                    class="bg-[rgba(255,255,255,.06)] border border-[rgba(255,255,255,.13)] rounded-xl
                           px-2.5 py-[.45rem] text-[.82rem] text-white outline-none cursor-pointer
                           transition-colors focus:border-[#08beff]">
                @foreach($meses as $idx => $nombre)
                <option value="{{ $idx + 1 }}" {{ $mes == ($idx + 1) ? 'selected' : '' }}>{{ $nombre }}</option>
                @endforeach
            </select>
            <select name="anio" onchange="this.form.submit()"
                    class="bg-[rgba(255,255,255,.06)] border border-[rgba(255,255,255,.13)] rounded-xl
                           px-2.5 py-[.45rem] text-[.82rem] text-white outline-none cursor-pointer
                           transition-colors focus:border-[#08beff]">
                @foreach(range(now()->year - 1, now()->year + 2) as $y)
                <option value="{{ $y }}" {{ $anio == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>
        </form>

        <a href="{{ route('admin.agenda.mes', array_merge(['mes' => $mesNext, 'anio' => $anioNext], $qBase)) }}"
           class="w-[34px] h-[34px] flex items-center justify-center rounded-xl text-[rgba(255,255,255,.4)]
                  border border-[rgba(255,255,255,.13)] hover:bg-[rgba(255,255,255,.07)]
                  hover:text-white transition-all no-underline">
            <i class="bi bi-chevron-right text-sm"></i>
        </a>
    </div>
</div>
@endsection

@push('styles')
<style>
    .cal-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 1px;
        background: rgba(255,255,255,.06);
        border-radius: 0 0 16px 16px;
        overflow: hidden;
    }
    .cal-head {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 1px;
        background: rgba(255,255,255,.06);
        border-radius: 16px 16px 0 0;
        overflow: hidden;
        margin-bottom: 1px;
    }
    .cal-head-cell {
        background: #0c0c1c;
        text-align: center;
        padding: 8px 0;
        font-size: .7rem;
        font-weight: 600;
        letter-spacing: .08em;
        text-transform: uppercase;
    }
    .cal-cell {
        background: #08080f;
        min-height: 108px;
        padding: 8px;
        transition: background .12s;
        position: relative;
    }
    .cal-cell:hover { background: #0c0c1b; }
    .cal-cell.vacia { background: #070710; }

    .dia-num {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 26px; height: 26px;
        border-radius: 50%;
        font-size: .78rem;
        font-weight: 600;
        text-decoration: none;
        transition: background .12s;
        margin-bottom: 4px;
    }
    .dia-num:hover { background: rgba(255,255,255,.08); }
    .dia-num.hoy   { background: #cc0247; color: #fff !important; }
    .dia-num.finde { color: rgba(255,255,255,.3); }
    .dia-num.normal{ color: rgba(255,255,255,.6); }

    .cita-chip {
        display: block;
        width: 100%;
        padding: 2px 6px;
        border-radius: 5px;
        font-size: .63rem;
        font-weight: 500;
        color: #fff;
        text-decoration: none;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-bottom: 2px;
        transition: opacity .12s;
    }
    .cita-chip:hover { opacity: .8; }

    .mas-link {
        display: block;
        font-size: .61rem;
        color: rgba(255,255,255,.35);
        text-decoration: none;
        margin-top: 1px;
        transition: color .12s;
    }
    .mas-link:hover { color: rgba(255,255,255,.65); }
</style>
@endpush

@section('content')

<!-- Indicador de sala activa: muestra nombre, color y recuento de citas del mes (solo al filtrar por sala) -->
@if($consultaId)
<div class="flex flex-wrap gap-2 mb-5">
    @foreach($todasConsultas->where('id', $consultaId) as $c)
    <div class="flex items-center gap-2 px-3 py-1.5 rounded-xl border sala-chip-summary"
         data-color="{{ $c->color }}">
        <span class="w-2.5 h-2.5 rounded-full shrink-0 sala-chip-dot"></span>
        <span class="text-[.82rem] font-semibold text-white">{{ $c->nombre }}</span>
        <span class="ml-1 text-[.67rem] font-semibold px-2 py-0.5 rounded-full sala-chip-badge">
            {{ $citas->flatten()->count() }} {{ $citas->flatten()->count() === 1 ? 'cita' : 'citas' }} en {{ $meses[$mes-1] }}
        </span>
    </div>
    @endforeach
</div>
@endif

<!-- Cabecera del calendario: etiquetas de los días de la semana de lunes a domingo -->
<div class="cal-head">
    @foreach($diasSemana as $idx => $dia)
    <div class="cal-head-cell {{ $idx >= 5 ? 'text-[rgba(255,255,255,.3)]' : 'text-[rgba(255,255,255,.45)]' }}">
        {{ $dia }}
    </div>
    @endforeach
</div>

<!-- Cuadrícula mensual: cada celda representa un día del mes con sus citas -->
<div class="cal-grid">

    <!-- Celdas vacías al inicio para alinear el primer día del mes con su día de la semana -->
    @for($i = 0; $i < $offsetLunes; $i++)
    <div class="cal-cell vacia"></div>
    @endfor

    <!-- Celdas de día: cada una muestra el número del día y sus citas -->
    @for($d = 1; $d <= $diasEnMes; $d++)
    @php
        $fechaDia  = \Carbon\Carbon::create($anio, $mes, $d);
        $key       = $fechaDia->format('Y-m-d');
        $citasDia  = $citas->get($key, collect());
        $esHoy     = $key === $hoy;
        $esFinde   = $fechaDia->isWeekend();
        $diaSemana = ($offsetLunes + $d - 1) % 7; // 0=lun … 6=dom
    @endphp
    <div class="cal-cell">

        <!-- Número del día: enlaza a la vista diaria; resaltado en rojo si es hoy, atenuado si es fin de semana -->
        <a href="{{ route('admin.agenda', array_merge(['fecha' => $key], $qBase)) }}"
           class="dia-num {{ $esHoy ? 'hoy' : ($esFinde ? 'finde' : 'normal') }}">
            {{ $d }}
        </a>

        <!-- Chips de cita: se muestran hasta 3 por día, con color de sala y datos básicos del paciente -->
        @foreach($citasDia->take(3) as $cita)
        @php $color = $cita->consulta?->color ?? '#08beff'; @endphp
        <a href="{{ route('admin.agenda', array_merge(['fecha' => $key], $qBase)) }}"
           title="{{ $cita->paciente->nombre }} · {{ \Carbon\Carbon::parse($cita->hora_inicio)->format('H:i') }}–{{ \Carbon\Carbon::parse($cita->hora_fin)->format('H:i') }}
{{ $cita->paciente->telefono ?? '' }}
{{ $cita->paciente->email }}"
           class="cita-chip"
           data-color="{{ $color }}">
            {{ \Carbon\Carbon::parse($cita->hora_inicio)->format('H:i') }} · {{ $cita->paciente->nombre }}
        </a>
        @endforeach

        <!-- Enlace "+N más" cuando el día tiene más de 3 citas; redirige a la vista diaria -->
        @if($citasDia->count() > 3)
        <a href="{{ route('admin.agenda', array_merge(['fecha' => $key], $qBase)) }}"
           class="mas-link">
            +{{ $citasDia->count() - 3 }} más
        </a>
        @endif

    </div>
    @endfor

    <!-- Celdas vacías al final para completar la última fila de la cuadrícula a 7 columnas -->
    @php
        $totalCeldas = $offsetLunes + $diasEnMes;
        $celdaFinal  = $totalCeldas % 7 === 0 ? 0 : 7 - ($totalCeldas % 7);
    @endphp
    @for($i = 0; $i < $celdaFinal; $i++)
    <div class="cal-cell vacia"></div>
    @endfor

</div>

<!-- Leyenda inferior: identifica el color de cada sala y el indicador del día de hoy -->
<div class="flex flex-wrap items-center gap-5 mt-5 px-1">
    <span class="text-[.67rem] text-[rgba(255,255,255,.28)] uppercase tracking-widest font-medium">Salas:</span>
    @foreach($todasConsultas as $c)
    <span class="flex items-center gap-1.5 text-[.73rem] text-[rgba(255,255,255,.5)]">
        <span class="w-3 h-3 rounded-sm inline-block leyenda-dot" data-color="{{ $c->color }}"></span>
        {{ $c->nombre }}
    </span>
    @endforeach
    <span class="flex items-center gap-1.5 text-[.73rem] text-[rgba(255,255,255,.5)]">
        <span class="w-[26px] h-[26px] rounded-full inline-flex items-center justify-center
                     text-[.7rem] font-bold bg-[#cc0247] text-white">{{ now()->day }}</span>
        Hoy
    </span>
</div>

@endsection

@push('scripts')
<script>
(function () {
    'use strict';

    /* Aplica colores de sala activa al indicador superior */
    document.querySelectorAll('.sala-chip-summary').forEach(function (el) {
        var c = el.dataset.color;
        el.style.background  = c + '14';
        el.style.borderColor = c + '35';
        var dot   = el.querySelector('.sala-chip-dot');
        var badge = el.querySelector('.sala-chip-badge');
        if (dot)   { dot.style.background = c; dot.style.boxShadow = '0 0 6px ' + c + '70'; }
        if (badge) { badge.style.background = c + '22'; badge.style.color = c; }
    });

    /* Aplica el color de fondo a cada chip de cita en el calendario mensual */
    document.querySelectorAll('.cita-chip[data-color]').forEach(function (el) {
        el.style.background = el.dataset.color + 'bb';
    });

    /* Aplica color a los puntos de la leyenda inferior */
    document.querySelectorAll('.leyenda-dot').forEach(function (el) {
        el.style.background = el.dataset.color;
    });

}());
</script>
@endpush
