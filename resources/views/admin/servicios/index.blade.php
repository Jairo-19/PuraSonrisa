@extends('layouts.admin')

@section('titulo', 'Servicios')

@section('subtitulo', 'Gestión de servicios')

@section('acciones')
<!--informacion de la cantidad de servicios -->
<div class="inline-flex items-center gap-2 px-4 py-[.45rem] bg-[rgba(8,190,255,.08)] border border-[rgba(8,190,255,.2)] rounded-full text-[.78rem] font-semibold text-[#08beff]">
    <i class="bi bi-gear-fill"></i>
    {{ $servicios->count() }} registros
</div>

<!--botón crear nuevo servicio -->
<a href="{{ route('admin.servicios.crear') }}" class="btn-crear inline-flex items-center gap-2 px-[1.1rem] py-[.45rem] bg-[#cc0247] rounded-full text-[.78rem] font-semibold text-white no-underline cursor-pointer transition-all hover:bg-[#a8013b] hover:-translate-y-px active:translate-y-0">
    <i class="bi bi-plus-lg"></i>
    Nuevo servicio
</a>


<!--buscador de servicios -->
<div class="flex items-center gap-2 bg-[rgba(255,255,255,.05)] border border-[rgba(255,255,255,.07)] rounded-lg px-[.9rem] py-[.45rem]">
    <i class="bi bi-search"></i>
   <input type="text" id="search" placeholder="Busca por el nombre del servicio" class="bg-transparent border-0 outline-none text-[.82rem] text-white w-[180px] placeholder:text-[rgba(255,255,255,.32)]">
</div>
@endsection

@section('content')
<section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
     @foreach($servicios as $servicio)
        <div class="servicio flex flex-col rounded-2xl overflow-hidden bg-white
                    border border-gray-200
                    shadow-[0_8px_36px_rgba(0,0,0,0.22)]
                    hover:shadow-[0_18px_56px_rgba(0,0,0,0.35)]
                    hover:-translate-y-1.5 transition-all duration-300 h-full">

            <!-- Foto fija en altura -->
            <div class="h-44 w-full shrink-0 overflow-hidden">
                @if($servicio->imagen)
                    <img src="{{ asset('imagenes/' . $servicio->imagen) }}"
                         alt="{{ $servicio->nombre }}"
                         class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                @else
                    <div class="w-full h-full bg-[#fffbf4] flex items-center justify-center">
                        <i class="bi bi-tooth text-5xl text-[#cc0247]/30"></i>
                    </div>
                @endif
            </div>

            <!-- Línea de acento rosa→azul -->
            <div class="h-1 shrink-0 bg-gradient-to-r from-[#cc0247] to-[#08beff]"></div>

            <!-- Contenido -->
            <div class="flex flex-col flex-1 px-6 py-5 gap-2">
                <h3 class="text-base font-bold text-gray-800 leading-snug">{{ $servicio->nombre }}</h3>
                <p class="text-gray-500 text-sm leading-relaxed flex-1">{{ $servicio->descripcion }}</p>
            </div>

        </div>
        @endforeach
</section>

<!-- Mensaje sin resultados -->
<div id="sin-resultados" style="display:none" class="col-span-full text-center py-16 text-[rgba(255,255,255,.4)] text-[.9rem]">
    <i class="bi bi-search block text-[2.5rem] mb-3 opacity-30"></i>
    No se encontró ningún servicio.
</div>

@endsection

<!-- script de busqueda simple-->
@push('scripts')
<script>
    const searchInput = document.getElementById('search');
    const servicios = document.querySelectorAll('.servicio');
    searchInput.addEventListener('input', function() {
        const textominusculas = this.value.toLowerCase();
        let found = 0;
        servicios.forEach(function(card) {
            const textotarjetacompleta = card.querySelector('h3').textContent.toLowerCase();
            if (textotarjetacompleta.includes(textominusculas)) {
                card.style.display = '';
                found++;
            } else {
                card.style.display = 'none';
            }
        });
        document.getElementById('sin-resultados').style.display = found === 0 ? '' : 'none';
    });
    
</script>
@endpush