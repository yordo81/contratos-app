<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TipoContratoResource\Pages;
use App\Models\TipoContrato;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TipoContratoResource extends Resource
{
    protected static ?string $model = TipoContrato::class;

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-tag';
    }

    public static function getNavigationLabel(): string
    {
        return 'Tipos de Contrato';
    }

    public static function getModelLabel(): string
    {
        return 'Tipo de Contrato';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Tipos de Contrato';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Catálogos';
    }

    public static function getNavigationSort(): int
    {
        return 1;
    }

    // ── Authorization ──────────────────────────────────────────────────────

    public static function canAccess(): bool
    {
        return true; // All authenticated users can view catalogs
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public static function canDeleteAny(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    // ── Form ───────────────────────────────────────────────────────────────

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Información del Tipo de Contrato')
                    ->icon('heroicon-o-information-circle')
                    ->schema([
                        Forms\Components\TextInput::make('nombre')
                            ->label('Nombre')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->placeholder('Ej: Prestación de servicios'),

                        Forms\Components\Textarea::make('descripcion')
                            ->label('Descripción')
                            ->nullable()
                            ->rows(3)
                            ->placeholder('Descripción del tipo de contrato'),

                        Forms\Components\Toggle::make('activo')
                            ->label('Activo')
                            ->default(true),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('descripcion')
                    ->label('Descripción')
                    ->limit(60)
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\IconColumn::make('activo')
                    ->label('Activo')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('contratos_count')
                    ->label('Contratos')
                    ->counts('contratos')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('nombre')
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTipoContratos::route('/'),
            'create' => Pages\CreateTipoContrato::route('/create'),
            'edit' => Pages\EditTipoContrato::route('/{record}/edit'),
        ];
    }
}
