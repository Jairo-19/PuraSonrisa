<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImagenClinica extends Model
{
    use HasFactory;
    // ─── Tabla ─────────────────────────────────────────────────
    protected $table = 'imagenes_clinicas';

    // ─── Atributos ─────────────────────────────────────────────
    protected $fillable = [
        'historial_id',
        'nombre',
        'ruta',
        'tipo',
        'descripcion',
    ];

    // ─── Relaciones ────────────────────────────────────────────

    /** Historial clínico al que pertenece esta imagen */
    public function historial(): BelongsTo
    {
        return $this->belongsTo(HistorialClinico::class, 'historial_id');
    }
}
