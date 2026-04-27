<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Consulta extends Model
{
    use HasFactory;

    // ─── Atributos ─────────────────────────────────────────────
    protected $fillable = [
        'nombre',
        'color',
        'activa',
    ];

    // ─── Tipos ─────────────────────────────────────────────────
    protected $casts = [
        'activa' => 'boolean',
    ];

    // ─── Relaciones ────────────────────────────────────────────

    /** Citas asignadas a esta consulta */
    public function citas(): HasMany
    {
        return $this->hasMany(Cita::class, 'consulta_id');
    }

    // ─── Scopes ────────────────────────────────────────────────

    /** Solo consultas activas */
    public function scopeActivas($query)
    {
        return $query->where('activa', true);
    }
}
