@extends('layouts.admin')

@section('titulo', 'Estadísticas')
@section('subtitulo', 'Resumen de actividad')

@push('styles')
<style>
    .kpi-card:nth-child(2) { animation-delay: .08s; }
    .kpi-card:nth-child(3) { animation-delay: .16s; }
    .chart-wrap { animation: fadeUp .5s .22s ease-out both; }
</style>
@endpush

@section('content')

{{-- KPI Cards --}}
<div class="grid grid-cols-[repeat(auto-fit,minmax(210px,1fr))] gap-4 mb-8">

    {{-- Citas del mes --}}
    <div class="kpi-card anim-up bg-[rgba(255,255,255,.03)] border border-[rgba(255,255,255,.07)] rounded-[14px] p-[1.4rem_1.6rem]">
        <div class="flex items-center justify-between mb-4">
            <span class="text-[.7rem] font-semibold tracking-[.12em] uppercase text-[rgba(255,255,255,.32)]">Citas este mes</span>
            <div class="w-8 h-8 rounded-[8px] bg-[rgba(8,190,255,.12)] flex items-center justify-center text-[#08beff]">
                <i class="bi bi-calendar-check text-sm"></i>
            </div>
        </div>
        <div class="font-['Cormorant_Garamond'] text-[3rem] font-bold text-white leading-none mb-2">
            {{ $totalCitasMes }}
        </div>
        <div class="text-[.74rem] text-[rgba(255,255,255,.32)]">
            <span class="w-[7px] h-[7px] rounded-full inline-block mr-[.4rem] bg-[#08beff]"></span>
            {{ ucfirst(\Carbon\Carbon::now()->locale('es')->isoFormat('MMMM')) }}
        </div>
    </div>

    {{-- Nuevos clientes --}}
    <div class="kpi-card anim-up bg-[rgba(255,255,255,.03)] border border-[rgba(255,255,255,.07)] rounded-[14px] p-[1.4rem_1.6rem]">
        <div class="flex items-center justify-between mb-4">
            <span class="text-[.7rem] font-semibold tracking-[.12em] uppercase text-[rgba(255,255,255,.32)]">Nuevos clientes</span>
            <div class="w-8 h-8 rounded-[8px] bg-[rgba(204,2,71,.1)] flex items-center justify-center text-[#ff6b8a]">
                <i class="bi bi-person-plus text-sm"></i>
            </div>
        </div>
        <div class="font-['Cormorant_Garamond'] text-[3rem] font-bold text-white leading-none mb-2">
            {{ $nuevosClientes }}
        </div>
        <div class="text-[.74rem] text-[rgba(255,255,255,.32)]">
            <span class="w-[7px] h-[7px] rounded-full inline-block mr-[.4rem] bg-[#cc0247]"></span>
            Registrados este mes
        </div>
    </div>

    {{-- Ingresos --}}
    <div class="kpi-card anim-up bg-[rgba(255,255,255,.03)] border border-[rgba(255,255,255,.07)] rounded-[14px] p-[1.4rem_1.6rem]">
        <div class="flex items-center justify-between mb-4">
            <span class="text-[.7rem] font-semibold tracking-[.12em] uppercase text-[rgba(255,255,255,.32)]">Ingresos generados</span>
            <div class="w-8 h-8 rounded-[8px] bg-[rgba(255,255,255,.06)] flex items-center justify-center text-[rgba(255,255,255,.55)]">
                <i class="bi bi-cash-stack text-sm"></i>
            </div>
        </div>
        <div class="font-['Cormorant_Garamond'] text-[3rem] font-bold text-white leading-none mb-2">
            {{ number_format($ingresos, 2, ',', '.') }}<span class="text-[1.5rem] text-[rgba(255,255,255,.35)] ml-1">€</span>
        </div>
        <div class="text-[.74rem] text-[rgba(255,255,255,.32)]">
            <span class="w-[7px] h-[7px] rounded-full inline-block mr-[.4rem] bg-white opacity-40"></span>
            Solo citas completadas
        </div>
    </div>

</div>

{{-- Gráfico Top 5 servicios --}}
<div class="chart-wrap bg-[rgba(255,255,255,.025)] border border-[rgba(255,255,255,.07)] rounded-2xl p-6">

    <div class="flex items-center justify-between mb-6">
        <div>
            <div class="text-[.92rem] font-semibold text-white">Top 5 servicios</div>
            <div class="text-[.75rem] text-[rgba(255,255,255,.32)] mt-[.2rem]">Más reservados en total</div>
        </div>
        <div class="inline-flex items-center gap-2 px-3 py-[.35rem] bg-[rgba(8,190,255,.08)] border border-[rgba(8,190,255,.2)] rounded-full text-[.72rem] font-semibold text-[#08beff]">
            <i class="bi bi-bar-chart-fill"></i>
            {{ $serviciosTop->sum('citas_count') }} citas totales
        </div>
    </div>

    @if($serviciosTop->isEmpty())
        <div class="text-center py-16 text-[rgba(255,255,255,.32)] text-[.88rem]">
            <i class="bi bi-bar-chart block text-[2.5rem] mb-4 opacity-40"></i>
            Todavía no hay datos suficientes.
        </div>
    @else
        <div class="relative h-[280px]">
            <canvas id="chartServicios"></canvas>
        </div>
    @endif

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    const labels = @json($serviciosTop->pluck('nombre'));
    const datos  = @json($serviciosTop->pluck('citas_count'));

    new Chart(document.getElementById('chartServicios'), {
        type: 'bar',
        data: {
            labels,
            datasets: [{
                label: 'Citas',
                data: datos,
                backgroundColor: [
                    'rgba(8,190,255,.75)',
                    'rgba(8,190,255,.58)',
                    'rgba(8,190,255,.44)',
                    'rgba(8,190,255,.30)',
                    'rgba(8,190,255,.18)',
                ],
                borderColor: 'rgba(8,190,255,.9)',
                borderWidth: 1,
                borderRadius: 6,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#12121f',
                    borderColor: 'rgba(255,255,255,.1)',
                    borderWidth: 1,
                    titleColor: '#fff',
                    bodyColor: 'rgba(255,255,255,.55)',
                    padding: 10,
                    callbacks: {
                        label: ctx => ` ${ctx.parsed.y} citas`
                    }
                }
            },
            scales: {
                x: {
                    grid: { color: 'rgba(255,255,255,.04)' },
                    ticks: { color: 'rgba(255,255,255,.38)', font: { size: 12 } }
                },
                y: {
                    grid: { color: 'rgba(255,255,255,.04)' },
                    ticks: { color: 'rgba(255,255,255,.38)', font: { size: 12 }, stepSize: 1 },
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endpush