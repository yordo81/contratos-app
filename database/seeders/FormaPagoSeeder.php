<?php

namespace Database\Seeders;

use App\Models\FormaPago;
use Illuminate\Database\Seeder;

class FormaPagoSeeder extends Seeder
{
    public function run(): void
    {
        $formas = [
            ['nombre' => 'Transferencia bancaria', 'descripcion' => 'Pago mediante transferencia electrónica a cuenta bancaria'],
            ['nombre' => 'Efectivo', 'descripcion' => 'Pago en efectivo'],
            ['nombre' => 'Cheque', 'descripcion' => 'Pago mediante cheque nominativo'],
            ['nombre' => 'Tarjeta de crédito', 'descripcion' => 'Pago con tarjeta de crédito'],
            ['nombre' => 'Tarjeta de débito', 'descripcion' => 'Pago con tarjeta de débito'],
            ['nombre' => 'Otro', 'descripcion' => 'Otra forma de pago no especificada'],
        ];

        foreach ($formas as $forma) {
            FormaPago::updateOrCreate(
                ['nombre' => $forma['nombre']],
                $forma
            );
        }
    }
}
