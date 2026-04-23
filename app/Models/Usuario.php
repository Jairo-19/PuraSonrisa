<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Usuario extends Model
{
    use HasFactory;
    // ─── Atributos ─────────────────────────────────────────────
    protected $fillable = [
        'nombre',
        'email',
        'password',
        'rol',
        'telefono',
        'fecha_nacimiento',
        'dni',
        'alergias',
        'condiciones_medicas',
    ];

    // ─── Tipos ─────────────────────────────────────────────────
    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    // ─── Ocultos ───────────────────────────────────────────────
    protected $hidden = [
        'password',
    ];

    // ─── Relaciones ────────────────────────────────────────────

    /** Citas donde este usuario es el paciente */
    public function citasPaciente(): HasMany
    {
        return $this->hasMany(Cita::class, 'paciente_id');
    }

    /** Citas donde este usuario es el empleado */
    public function citasEmpleado(): HasMany
    {
        return $this->hasMany(Cita::class, 'empleado_id');
    }

    /** Historial clínico del paciente */
    public function historialClinico(): HasMany
    {
        return $this->hasMany(HistorialClinico::class, 'paciente_id');
    }

    // ─── Scopes ────────────────────────────────────────────────

    /// Scope para filtrar solo los clientes
    public function scopeClientes($query)
    {
        return $query->where('rol', 'cliente');
    }

    /// Scope para filtrar solo los empleados
    public function scopeEmpleados($query)
    {
        return $query->where('rol', 'empleado');
    }
}
