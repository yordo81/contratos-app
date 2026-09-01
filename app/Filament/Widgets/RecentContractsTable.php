<?php

namespace App\Filament\Widgets;

use App\Models\Contrato;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class RecentContractsTable extends TableWidget
{
    protected static ?string $heading = 'Contratos Recientes';
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Contrato::with(['tipoContrato', 'formaPago'])
                    ->latest('fecha_firma')
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('numero_contrato_proveedor_cliente')
                    ->label('No. Contrato')
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('proveedor_cliente')
                    ->label('Proveedor / Cliente')
                    ->searchable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('tipoContrato.nombre')
                    ->label('Tipo')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'Prestación de servicios' => 'info',
                        'Compra venta' => 'warning',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('dictamen')
                    ->label('Dictamen')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Aprobado' => 'success',
                        'Rechazado' => 'danger',
                        'En revisión' => 'warning',
                        'Pendiente' => 'gray',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('fecha_firma')
                    ->label('Fecha Firma')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('formaPago.nombre')
                    ->label('Forma de Pago'),

                Tables\Columns\TextColumn::make('observaciones')
                    ->label('Obs.')
                    ->limit(30)
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->poll('60s');
    }
}
