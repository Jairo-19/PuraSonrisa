<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cita extends Model
{
    use HasFactory;
    // ─── Atributos ─────────────────────────────────────────────
    protected $fillable = [
        'paciente_id',
        'empleado_id',
        'servicio_id',
        'consulta_id',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'estado',
        'motivo',
    ];

    // ─── Tipos ─────────────────────────────────────────────────
    protected $casts = [
        'fecha' => 'date',
    ];

    // ─── Relaciones ────────────────────────────────────────────

    /** Paciente que tiene la cita */
    public function paciente(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'paciente_id');
    }

    /** Empleado que atiende la cita */
    public function empleado(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'empleado_id');
    }

    /** Servicio de la cita */
    public function servicio(): BelongsTo
    {
        return $this->belongsTo(Servicio::class, 'servicio_id');
    }

    /** Consulta (gabinete) donde se atiende la cita */
    public function consulta(): BelongsTo
    {
        return $this->belongsTo(Consulta::class, 'consulta_id');
    }

    // ─── Scopes ────────────────────────────────────────────────

    /// Scope para filtrar solo las citas pendientes
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    /// Scope para filtrar solo las citas confirmadas
    public function scopeConfirmadas($query)
    {
        return $query->where('estado', 'confirmada');
    }

    /// Scope para filtrar solo las citas canceladas
    public function scopeCompletadas($query)
    {
        return $query->where('estado', 'completada');
    }
}
