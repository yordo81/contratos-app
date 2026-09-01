<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FormaPago extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'activo' => 'boolean',
        ];
    }

    public function contratos(): HasMany
    {
        return $this->hasMany(Contrato::class);
    }

    public function __toString(): string
    {
        return $this->nombre;
    }
}
