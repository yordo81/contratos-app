<?php

namespace Database\Seeders;

use App\Models\Contrato;
use App\Models\FormaPago;
use App\Models\Suplemento;
use App\Models\TipoContrato;
use Illuminate\Database\Seeder;

class ContratoSeeder extends Seeder
{
    public function run(): void
    {
        $tipoServicios = TipoContrato::where('nombre', 'Prestación de servicios')->first();
        $tipoCompra = TipoContrato::where('nombre', 'Compra venta')->first();

        $formaTransferencia = FormaPago::where('nombre', 'Transferencia bancaria')->first();
        $formaCheque = FormaPago::where('nombre', 'Cheque')->first();
        $formaEfectivo = FormaPago::where('nombre', 'Efectivo')->first();
        $formaCredito = FormaPago::where('nombre', 'Tarjeta de crédito')->first();

        $contratos = [
            [
                'proveedor_cliente' => 'Constructora ABC S.A. de C.V.',
                'tipo_contrato_id' => $tipoCompra->id,
                'objeto_contrato' => 'Adquisicion de materiales de construccion para el proyecto de infraestructura vial del estado, incluyendo cemento, acero, agregados y materiales complementarios.',
                'numero_contrato_proveedor_cliente' => 'CV-2025-001',
                'dictamen' => 'Aprobado',
                'forma_pago_id' => $formaTransferencia->id,
                'fecha_firma' => '2025-01-15',
                'fecha_inicio_vigencia' => '2025-01-15',
                'fecha_fin_vigencia' => '2025-12-31',
                'observaciones' => 'Contrato marco para adquisiciones recurrentes durante el ejercicio fiscal.',
                'archivo_contrato' => null,
            ],
            [
                'proveedor_cliente' => 'Tecnologia y Consultoria del Norte S.A.',
                'tipo_contrato_id' => $tipoServicios->id,
                'objeto_contrato' => 'Servicios de consultoria tecnologica para la implementacion del sistema integrado de gestion documental, incluyendo configuracion, capacitacion y soporte tecnico por 12 meses.',
                'numero_contrato_proveedor_cliente' => 'PS-2025-042',
                'dictamen' => 'Aprobado',
                'forma_pago_id' => $formaTransferencia->id,
                'fecha_firma' => '2025-02-20',
                'fecha_inicio_vigencia' => '2025-02-20',
                'fecha_fin_vigencia' => '2026-02-28',
                'observaciones' => 'Incluye 3 fases de implementacion. Pago por hitos de avance.',
                'archivo_contrato' => null,
            ],
            [
                'proveedor_cliente' => 'Distribuidora de Alimentos Frescos S. de R.L.',
                'tipo_contrato_id' => $tipoCompra->id,
                'objeto_contrato' => 'Suministro de alimentos frescos y perecederos para el programa de alimentacion escolar durante el ciclo 2025-2026.',
                'numero_contrato_proveedor_cliente' => 'CV-2025-018',
                'dictamen' => 'En revision',
                'forma_pago_id' => $formaCheque->id,
                'fecha_firma' => '2025-03-10',
                'fecha_inicio_vigencia' => '2025-03-10',
                'fecha_fin_vigencia' => '2026-06-30',
                'observaciones' => 'Pendiente de revision por parte de la contraloria. Entregas semanales en 15 planteles.',
                'archivo_contrato' => null,
            ],
            [
                'proveedor_cliente' => 'Servicios de Limpieza Integral S.A.',
                'tipo_contrato_id' => $tipoServicios->id,
                'objeto_contrato' => 'Servicio de limpieza y mantenimiento general de las instalaciones administrativas del edificio central, incluyendo areas comunes, oficinas y sanatorios.',
                'numero_contrato_proveedor_cliente' => 'PS-2025-007',
                'dictamen' => 'Aprobado',
                'forma_pago_id' => $formaTransferencia->id,
                'fecha_firma' => '2025-01-05',
                'fecha_inicio_vigencia' => '2025-01-05',
                'fecha_fin_vigencia' => '2025-12-31',
                'observaciones' => 'Servicio diario de lunes a viernes. Personal de 8 personas incluido.',
                'archivo_contrato' => null,
            ],
            [
                'proveedor_cliente' => 'Transportes y Logistica del Sur S.A. de C.V.',
                'tipo_contrato_id' => $tipoServicios->id,
                'objeto_contrato' => 'Servicio de transporte de personal administrativo y material documental entre oficinas satelite y la sede principal.',
                'numero_contrato_proveedor_cliente' => 'PS-2025-033',
                'dictamen' => 'Rechazado',
                'forma_pago_id' => $formaEfectivo->id,
                'fecha_firma' => '2025-04-01',
                'fecha_inicio_vigencia' => '2025-04-01',
                'fecha_fin_vigencia' => null,
                'observaciones' => 'Rechazado por incumplimiento de requisitos de licitacion. No presento poliza de cumplimiento.',
                'archivo_contrato' => null,
            ],
            [
                'proveedor_cliente' => 'Imprenta Grafica Moderna S.A.',
                'tipo_contrato_id' => $tipoCompra->id,
                'objeto_contrato' => 'Impresion de material publicitario, formularios oficiales, credenciales y material grafico institucional para el primer semestre 2025.',
                'numero_contrato_proveedor_cliente' => 'CV-2025-055',
                'dictamen' => 'Aprobado',
                'forma_pago_id' => $formaTransferencia->id,
                'fecha_firma' => '2025-02-01',
                'fecha_inicio_vigencia' => '2025-02-01',
                'fecha_fin_vigencia' => '2025-07-31',
                'observaciones' => 'Pedidos por separado segun requerimiento de cada-area.',
                'archivo_contrato' => null,
            ],
            [
                'proveedor_cliente' => 'Consultoria Juridica y Fiscal Asociados S.C.',
                'tipo_contrato_id' => $tipoServicios->id,
                'objeto_contrato' => 'Servicios de asesoria juridica y fiscal para revision de contratos, dictamenes legales y representacion en arbitrajes administrativos.',
                'numero_contrato_proveedor_cliente' => 'PS-2025-061',
                'dictamen' => 'Aprobado',
                'forma_pago_id' => $formaTransferencia->id,
                'fecha_firma' => '2025-03-15',
                'fecha_inicio_vigencia' => '2025-03-15',
                'fecha_fin_vigencia' => '2026-03-14',
                'observaciones' => 'Hasta 20 horas mensuales de asesoria incluidas.',
                'archivo_contrato' => null,
            ],
            [
                'proveedor_cliente' => 'Suministros Hospitalarios Nacional S.A. de C.V.',
                'tipo_contrato_id' => $tipoCompra->id,
                'objeto_contrato' => 'Adquisicion de equipo medico y suministros hospitalarios para el centro de salud comunitario, incluyendo camas, monitores, instrumental quirurgico y material desechable.',
                'numero_contrato_proveedor_cliente' => 'CV-2025-072',
                'dictamen' => 'Pendiente',
                'forma_pago_id' => $formaCredito->id,
                'fecha_firma' => '2025-04-10',
                'fecha_inicio_vigencia' => '2025-04-10',
                'fecha_fin_vigencia' => '2025-11-30',
                'observaciones' => 'En proceso de validacion de precios con base de referencia. Contrato sujeto a disponibilidad presupuestal.',
                'archivo_contrato' => null,
            ],
            [
                'proveedor_cliente' => 'Mantenimiento Industrial del Bajio S.A.',
                'tipo_contrato_id' => $tipoServicios->id,
                'objeto_contrato' => 'Servicio de mantenimiento preventivo y correctivo de la flota vehicular institucional, incluyendo 45 unidades tipo pickup y sedan.',
                'numero_contrato_proveedor_cliente' => 'PS-2025-019',
                'dictamen' => 'Aprobado',
                'forma_pago_id' => $formaTransferencia->id,
                'fecha_firma' => '2025-01-20',
                'fecha_inicio_vigencia' => '2025-01-20',
                'fecha_fin_vigencia' => '2025-12-31',
                'observaciones' => 'Servicio en planta. Incluye refacciones basicas.',
                'archivo_contrato' => null,
            ],
            [
                'proveedor_cliente' => 'Agua Purificada Cristalina S. de R.L.',
                'tipo_contrato_id' => $tipoCompra->id,
                'objeto_contrato' => 'Suministro de agua purificada en garrafon de 20 litros y Sistema de Filtrado para oficinas administrativas, 120 garrafones mensuales promedio.',
                'numero_contrato_proveedor_cliente' => 'CV-2025-088',
                'dictamen' => 'Aprobado',
                'forma_pago_id' => $formaEfectivo->id,
                'fecha_firma' => '2025-04-01',
                'fecha_inicio_vigencia' => '2025-04-01',
                'fecha_fin_vigencia' => '2026-03-31',
                'observaciones' => 'Entrega quincenal. Incluye montacarga para oficinas en segundo piso.',
                'archivo_contrato' => null,
            ],
        ];

        foreach ($contratos as $contratoData) {
            $contrato = Contrato::create($contratoData);

            // Crear 1-3 suplementos para algunos contratos aleatoriamente
            if (rand(1, 100) > 40) {
                $numSuplementos = rand(1, 3);
                for ($i = 1; $i <= $numSuplementos; $i++) {
                    Suplemento::create([
                        'contrato_id' => $contrato->id,
                        'numero_suplemento' => "SUP-{$contrato->numero_contrato_proveedor_cliente}-{$i}",
                        'descripcion' => $this->getSuplementoDescripcion($i, $contrato->tipoContrato?->nombre ?? ''),
                        'fecha' => $this->getSuplementoFecha($contrato->fecha_firma, $i),
                        'archivo_suplemento' => null,
                    ]);
                }
            }
        }
    }

    private function getSuplementoDescripcion(int $numero, string $tipoContrato): string
    {
        $descripcionesServicios = [
            1 => 'Primer suplemento: Ampliacion del alcance de servicios para incluir soporte tecnico remoto las 24 horas.',
            2 => 'Segundo suplemento: Extension del periodo de garantia de 12 a 18 meses sin costo adicional.',
            3 => 'Tercer suplemento: Incorporacion de capacitaciones adicionales para 20 usuarios en el sistema.',
        ];

        $descripcionesCompra = [
            1 => 'Primer suplemento: Incremento del volumen de materiales en un 15% segun requerimientos actualizados.',
            2 => 'Segundo suplemento: Reduccion del plazo de entrega de 30 a 15 dias habiles.',
            3 => 'Tercer suplemento: Actualizacion de precios conforme al indice INPC del periodo.',
        ];

        $opciones = str_contains($tipoContrato, 'servicios') ? $descripcionesServicios : $descripcionesCompra;

        return $opciones[$numero] ?? "Suplemento numero {$numero} al contrato.";
    }

    private function getSuplementoFecha(\Carbon\Carbon $fechaFirma, int $numero): string
    {
        return $fechaFirma->copy()->addMonths($numero)->format('Y-m-d');
    }
}
