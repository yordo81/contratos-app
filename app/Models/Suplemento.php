<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Suplemento extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'contrato_id',
        'numero_suplemento',
        'descripcion',
        'fecha',
        'archivo_suplemento',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'fecha' => 'date',
        ];
    }

    /**
     * Get the contrato that owns the suplemento.
     */
    public function contrato(): BelongsTo
    {
        return $this->belongsTo(Contrato::class);
    }
}
