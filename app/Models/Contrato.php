<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contrato extends Model
{
    protected $fillable = [
        'proveedor_cliente',
        'tipo_contrato_id',
        'objeto_contrato',
        'numero_contrato_proveedor_cliente',
        'dictamen',
        'forma_pago_id',
        'fecha_firma',
        'fecha_inicio_vigencia',
        'fecha_fin_vigencia',
        'observaciones',
        'archivo_contrato',
    ];

    protected function casts(): array
    {
        return [
            'fecha_firma' => 'date',
            'fecha_inicio_vigencia' => 'date',
            'fecha_fin_vigencia' => 'date',
        ];
    }

    /**
     * Auto-set fecha_inicio_vigencia to fecha_firma when saving.
     */
    protected static function booted(): void
    {
        static::saving(function (Contrato $contrato) {
            if ($contrato->fecha_firma && !$contrato->fecha_inicio_vigencia) {
                $contrato->fecha_inicio_vigencia = $contrato->fecha_firma;
            }
        });
    }

    public function tipoContrato(): BelongsTo
    {
        return $this->belongsTo(TipoContrato::class);
    }

    public function formaPago(): BelongsTo
    {
        return $this->belongsTo(FormaPago::class);
    }

    public function suplementos(): HasMany
    {
        return $this->hasMany(Suplemento::class);
    }

    /**
     * Accessor for backward compatibility with views.
     */
    public function getTipoContratoDisplayAttribute(): string
    {
        return $this->tipoContrato?->nombre ?? 'Sin tipo';
    }

    /**
     * Accessor for backward compatibility with views.
     */
    public function getFormaPagoDisplayAttribute(): string
    {
        return $this->formaPago?->nombre ?? 'Sin forma de pago';
    }
}
