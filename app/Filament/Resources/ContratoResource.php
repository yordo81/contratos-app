<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContratoResource\Pages;
use App\Models\Contrato;
use Filament\Forms;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;

class ContratoResource extends Resource
{
    protected static ?string $model = Contrato::class;

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-document-text';
    }

    public static function getNavigationLabel(): string
    {
        return 'Contratos';
    }

    public static function getModelLabel(): string
    {
        return 'Contrato';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Contratos';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Gestión de Contratos';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Información del Contrato')
                    ->description('Datos principales del contrato')
                    ->icon('heroicon-o-information-circle')
                    ->schema([
                        Forms\Components\TextInput::make('proveedor_cliente')
                            ->label('Proveedor / Cliente')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Nombre del proveedor o cliente'),

                        Forms\Components\Select::make('tipo_contrato')
                            ->label('Tipo de Contrato')
                            ->options([
                                'Prestación de servicios' => 'Prestación de servicios',
                                'Compra venta' => 'Compra venta',
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('numero_contrato_proveedor_cliente')
                            ->label('No. Contrato del Proveedor/Cliente')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Número de contrato'),

                        Forms\Components\Select::make('dictamen')
                            ->label('Dictamen')
                            ->options([
                                'Aprobado' => 'Aprobado',
                                'Rechazado' => 'Rechazado',
                                'En revisión' => 'En revisión',
                                'Pendiente' => 'Pendiente',
                            ])
                            ->nullable(),

                        Forms\Components\Select::make('forma_pago')
                            ->label('Forma de Pago')
                            ->options([
                                'Transferencia bancaria' => 'Transferencia bancaria',
                                'Efectivo' => 'Efectivo',
                                'Cheque' => 'Cheque',
                                'Tarjeta de crédito' => 'Tarjeta de crédito',
                                'Tarjeta de débito' => 'Tarjeta de débito',
                                'Otro' => 'Otro',
                            ])
                            ->required(),
                    ])
                    ->columns(2),

                Section::make('Vigencia y Observaciones')
                    ->description('Fechas de vigencia y notas adicionales')
                    ->icon('heroicon-o-calendar')
                    ->schema([
                        Forms\Components\DatePicker::make('fecha_firma')
                            ->label('Fecha de Firma del Contrato')
                            ->required()
                            ->native(false),

                        Forms\Components\DatePicker::make('fecha_inicio_vigencia')
                            ->label('Inicio de Vigencia')
                            ->nullable()
                            ->native(false),

                        Forms\Components\DatePicker::make('fecha_fin_vigencia')
                            ->label('Fin de Vigencia')
                            ->nullable()
                            ->native(false)
                            ->afterOrEqual('fecha_inicio_vigencia'),

                        Forms\Components\Textarea::make('objeto_contrato')
                            ->label('Objeto del Contrato')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('observaciones')
                            ->label('Observaciones')
                            ->nullable()
                            ->rows(3)
                            ->columnSpanFull(),

                        FileUpload::make('archivo_contrato')
                            ->label('Archivo del Contrato (PDF)')
                            ->disk('public')
                            ->directory('contratos')
                            ->acceptedFileTypes(['application/pdf'])
                            ->maxSize(10240) // 10MB
                            ->downloadable()
                            ->previewable()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('proveedor_cliente')
                    ->label('Proveedor/Cliente')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('tipo_contrato')
                    ->label('Tipo')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Prestación de servicios' => 'info',
                        'Compra venta' => 'warning',
                        default => 'gray',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('numero_contrato_proveedor_cliente')
                    ->label('No. Contrato')
                    ->searchable(),

                Tables\Columns\TextColumn::make('dictamen')
                    ->label('Dictamen')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Aprobado' => 'success',
                        'Rechazado' => 'danger',
                        'En revisión' => 'warning',
                        'Pendiente' => 'gray',
                        default => 'gray',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('forma_pago')
                    ->label('Forma de Pago')
                    ->sortable(),

                Tables\Columns\TextColumn::make('fecha_firma')
                    ->label('Fecha Firma')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('fecha_inicio_vigencia')
                    ->label('Inicio Vigencia')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('fecha_fin_vigencia')
                    ->label('Fin Vigencia')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('observaciones')
                    ->label('Observaciones')
                    ->limit(50)
                    ->tooltip(fn (Contrato $record): string => $record->observaciones ?? 'Sin observaciones')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('tipo_contrato')
                    ->label('Tipo de Contrato')
                    ->options([
                        'Prestación de servicios' => 'Prestación de servicios',
                        'Compra venta' => 'Compra venta',
                    ]),

                Tables\Filters\SelectFilter::make('dictamen')
                    ->label('Dictamen')
                    ->options([
                        'Aprobado' => 'Aprobado',
                        'Rechazado' => 'Rechazado',
                        'En revisión' => 'En revisión',
                        'Pendiente' => 'Pendiente',
                    ]),

                Tables\Filters\Filter::make('fecha_firma')
                    ->label('Fecha de Firma')
                    ->form([
                        Forms\Components\DatePicker::make('fecha_desde')
                            ->label('Desde'),
                        Forms\Components\DatePicker::make('fecha_hasta')
                            ->label('Hasta'),
                    ])
                    ->query(function ($query, array $data): void {
                        $query
                            ->when($data['fecha_desde'], fn ($q, $date) => $q->whereDate('fecha_firma', '>=', $date))
                            ->when($data['fecha_hasta'], fn ($q, $date) => $q->whereDate('fecha_firma', '<=', $date));
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            \App\Filament\Resources\ContratoResource\RelationManagers\SuplementosRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContratos::route('/'),
            'create' => Pages\CreateContrato::route('/create'),
            'edit' => Pages\EditContrato::route('/{record}/edit'),
        ];
    }

    public static function getRecordTitleAttribute(): string
    {
        return 'numero_contrato_proveedor_cliente';
    }
}
