<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contrato extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'proveedor_cliente',
        'tipo_contrato',
        'objeto_contrato',
        'numero_contrato_proveedor_cliente',
        'dictamen',
        'forma_pago',
        'fecha_firma',
        'fecha_inicio_vigencia',
        'fecha_fin_vigencia',
        'observaciones',
        'archivo_contrato',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'fecha_firma' => 'date',
            'fecha_inicio_vigencia' => 'date',
            'fecha_fin_vigencia' => 'date',
        ];
    }

    /**
     * Get the suplementos for the contrato.
     */
    public function suplementos(): HasMany
    {
        return $this->hasMany(Suplemento::class);
    }
}
