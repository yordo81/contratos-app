<?php

namespace App\Filament\Widgets;

use App\Models\Contrato;
use Filament\Widgets\ChartWidget;

class ContractsByTypeChart extends ChartWidget
{
    protected static ?int $sort = 1;

    public function getHeading(): ?string
    {
        return 'Contratos por Tipo';
    }

    public function getMaxHeight(): ?string
    {
        return '300px';
    }

    public function getData(): array
    {
        $data = Contrato::selectRaw('tipo_contrato_id, count(*) as total')
            ->groupBy('tipo_contrato_id')
            ->with('tipoContrato:id,nombre')
            ->get();

        $labels = $data->pluck('tipoContrato.nombre', 'tipo_contrato_id')->values()->toArray();
        $values = $data->pluck('total')->toArray();

        $colors = ['#F59E0B', '#3B82F6', '#10B981', '#EF4444', '#8B5CF6', '#EC4899', '#06B6D4'];

        return [
            'datasets' => [
                [
                    'data' => $values,
                    'backgroundColor' => array_slice($colors, 0, count($values)),
                ],
            ],
            'labels' => $labels,
        ];
    }

    public function getType(): string
    {
        return 'doughnut';
    }
}
