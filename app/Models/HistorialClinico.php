<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HistorialClinico extends Model
{
    use HasFactory;
    // ─── Tabla ─────────────────────────────────────────────────
    protected $table = 'historial_clinico';

    // ─── Atributos ─────────────────────────────────────────────
    protected $fillable = [
        'paciente_id',
        'descripcion',
        'fecha',
    ];

    // ─── Tipos ─────────────────────────────────────────────────
    protected $casts = [
        'fecha' => 'date',
    ];

    // ─── Relaciones ────────────────────────────────────────────

    /** Paciente al que pertenece este historial */
    public function paciente(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'paciente_id');
    }

    /** Imágenes asociadas a este historial */
    public function imagenes(): HasMany
    {
        return $this->hasMany(ImagenClinica::class, 'historial_id');
    }
}
