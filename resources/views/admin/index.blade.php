@extends('layouts.admin')

@section('titulo', 'Usuarios')
@section('subtitulo', 'Gestión de clientes y empleados')

@push('styles')
<style>
    .stat-card:nth-child(2) { animation-delay: .08s; }
    .stat-card:nth-child(3) { animation-delay: .16s; }
    .btn-crear:hover { box-shadow: 0 6px 22px rgba(204,2,71,.38); }
    .anim-up2 { animation: fadeUp .5s .1s ease-out both; }
</style>
@endpush

@section('acciones')
<div class="inline-flex items-center gap-2 px-4 py-[.45rem] bg-[rgba(8,190,255,.08)] border border-[rgba(8,190,255,.2)] rounded-full text-[.78rem] font-semibold text-[#08beff]">
    <i class="bi bi-people-fill"></i>
    {{ $usuarios->count() }} registros
</div>
<a href="{{ route('admin.usuarios.crear') }}" class="btn-crear inline-flex items-center gap-2 px-[1.1rem] py-[.45rem] bg-[#cc0247] rounded-full text-[.78rem] font-semibold text-white no-underline cursor-pointer transition-all hover:bg-[#a8013b] hover:-translate-y-px active:translate-y-0">
    <i class="bi bi-plus-lg"></i>
    Nuevo cliente
</a>
@endsection

@section('content')
<div>

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
@endsection

@push('scripts')
<script>
    document.getElementById('search').addEventListener('input', function () {
        const q = this.value.toLowerCase();
        document.querySelectorAll('#tabla-usuarios tbody tr').forEach(function (row) {
            row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
        });
    });
</script>
@endpush
