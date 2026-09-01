<?php

namespace Database\Seeders;

use App\Models\TipoContrato;
use Illuminate\Database\Seeder;

class TipoContratoSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = [
            ['nombre' => 'Prestación de servicios', 'descripcion' => 'Contrato para la prestación de servicios profesionales'],
            ['nombre' => 'Compra venta', 'descripcion' => 'Contrato de compra-venta de bienes o productos'],
            ['nombre' => 'Arrendamiento', 'descripcion' => 'Contrato de arrendamiento de inmuebles o bienes'],
            ['nombre' => 'Obra pública', 'descripcion' => 'Contrato para ejecución de obras públicas'],
            ['nombre' => 'Concesión', 'descripcion' => 'Contrato de concesión de servicios públicos'],
            ['nombre' => 'Mantenimiento', 'descripcion' => 'Contrato de mantenimiento preventivo o correctivo'],
            ['nombre' => 'Consultoría', 'descripcion' => 'Contrato de servicios de consultoría especializada'],
        ];

        foreach ($tipos as $tipo) {
            TipoContrato::updateOrCreate(
                ['nombre' => $tipo['nombre']],
                $tipo
            );
        }
    }
}
