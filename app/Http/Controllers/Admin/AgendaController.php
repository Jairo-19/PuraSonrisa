<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\Consulta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AgendaController extends Controller
{
    private const HORA_INICIO = 8;
    private const HORA_FIN    = 20;

    /** GET /admin/agenda — Vista diaria */
    public function dia(Request $request): View
    {
        $fecha      = $request->query('fecha', now()->toDateString());
        $consultaId = $request->query('consulta_id');

        $todasConsultas = Consulta::activas()->orderBy('id')->get();

        // Filtrar por sala si se especifica
        $consultas = $consultaId
            ? $todasConsultas->filter(fn (Consulta $c) => (string) $c->id === (string) $consultaId)->values()
            : $todasConsultas;

        // Cargar citas del día filtradas por consulta
        $consultas->each(function (Consulta $consulta) use ($fecha): void {
            $consulta->setRelation(
                'citas',
                $consulta->citas()
                    ->with(['paciente', 'servicio'])
                    ->whereDate('fecha', $fecha)
                    ->orderBy('hora_inicio')
                    ->get()
            );
        });

        $fechaCarbon = Carbon::parse($fecha)->locale('es');

        return view('admin.agenda', [
            'consultas'      => $consultas,
            'todasConsultas' => $todasConsultas,
            'fecha'          => $fecha,
            'fechaLabel'     => ucfirst($fechaCarbon->isoFormat('dddd, D [de] MMMM [de] YYYY')),
            'consultaId'     => $consultaId,
            'esHoy'          => $fecha === now()->toDateString(),
            'HORA_INICIO'    => self::HORA_INICIO,
            'HORA_FIN'       => self::HORA_FIN,
        ]);
    }

    /** GET /admin/agenda/mes — Vista mensual */
    public function mes(Request $request): View
    {
        $mes        = max(1, min(12, (int) $request->query('mes',  now()->month)));
        $anio       = max(2020, min(2099, (int) $request->query('anio', now()->year)));
        $consultaId = $request->query('consulta_id');

        $todasConsultas = Consulta::activas()->orderBy('id')->get();

        $inicio = Carbon::create($anio, $mes, 1)->startOfMonth();
        $fin    = $inicio->clone()->endOfMonth();

        // Citas del mes agrupadas por fecha
        $citas = Cita::with(['paciente', 'servicio', 'consulta'])
            ->whereBetween('fecha', [$inicio->toDateString(), $fin->toDateString()])
            ->when($consultaId, fn ($q) => $q->where('consulta_id', $consultaId))
            ->orderBy('hora_inicio')
            ->get()
            ->groupBy(fn (Cita $c): string => $c->fecha->format('Y-m-d'));

        return view('admin.agenda-mes', [
            'citas'          => $citas,
            'todasConsultas' => $todasConsultas,
            'mes'            => $mes,
            'anio'           => $anio,
            'inicio'         => $inicio,
            'fin'            => $fin,
            'consultaId'     => $consultaId,
            'mesLabel'       => ucfirst($inicio->locale('es')->isoFormat('MMMM [de] YYYY')),
        ]);
    }
}
