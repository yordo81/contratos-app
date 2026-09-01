<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RolResource\Pages;
use App\Models\Rol;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RolResource extends Resource
{
    protected static ?string $model = Rol::class;

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-shield-check';
    }

    public static function getNavigationLabel(): string
    {
        return 'Roles';
    }

    public static function getModelLabel(): string
    {
        return 'Rol';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Roles';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Gestión de Usuarios';
    }

    public static function getNavigationSort(): int
    {
        return 1;
    }

    public static function canAccess(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
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
        return false; // Roles cannot be deleted
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    // ── Form ───────────────────────────────────────────────────────────────

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Información del Rol')
                    ->icon('heroicon-o-information-circle')
                    ->schema([
                        Forms\Components\TextInput::make('nombre')
                            ->label('Nombre')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->placeholder('Ej: Administrador'),

                        Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->placeholder('Ej: admin')
                            ->dehydrateStateUsing(fn (string $state): string => strtolower(str_replace(' ', '-', $state)))
                            ->suffixIcon('heroicon-o-finger-print'),

                        Forms\Components\Textarea::make('descripcion')
                            ->label('Descripción')
                            ->nullable()
                            ->rows(3)
                            ->placeholder('Descripción de los permisos de este rol'),
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

                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->badge()
                    ->color('info')
                    ->sortable(),

                Tables\Columns\TextColumn::make('descripcion')
                    ->label('Descripción')
                    ->limit(60)
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('users_count')
                    ->label('Usuarios')
                    ->counts('users')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRols::route('/'),
            'create' => Pages\CreateRol::route('/create'),
            'edit' => Pages\EditRol::route('/{record}/edit'),
        ];
    }
}
