<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Servicio extends Model
{
    use HasFactory;
    // ─── Atributos ─────────────────────────────────────────────
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'duracion_minutos',
        'activo',
        'imagen',
    ];


    // ─── Tipos ─────────────────────────────────────────────────
    protected $casts = [
        'precio'           => 'decimal:2',
        'duracion_minutos' => 'integer',
        'activo'           => 'boolean',
    ];

    // ─── Relaciones ───────────────────────────────────────────────
    public function citas(): HasMany
    {
        return $this->hasMany(Cita::class, 'servicio_id');
    }

    // ─── Scopes ───────────────────────────────────────────────────
    //Los Scope sirven para filtrar solo los servicios activos
    //equivalente a un where('activo', true) pero de forma mas elegante y reutilizable
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }
}
