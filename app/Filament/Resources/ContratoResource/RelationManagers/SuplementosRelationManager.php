<?php

namespace App\Filament\Resources\ContratoResource\RelationManagers;

use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class SuplementosRelationManager extends RelationManager
{
    protected static string $relationship = 'suplementos';

    protected static ?string $recordTitleAttribute = 'numero_suplemento';

    // ── Authorization ──────────────────────────────────────────────────────

    public function canCreate(): bool
    {
        return auth()->user()?->canEdit() ?? false;
    }

    public function canEdit($record): bool
    {
        return auth()->user()?->canEdit() ?? false;
    }

    public function canDelete($record): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public function canDeleteAny(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    // ── Form ───────────────────────────────────────────────────────────────

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('numero_suplemento')
                    ->label('Numero de Suplemento')
                    ->required()
                    ->maxLength(255),

                Forms\Components\DatePicker::make('fecha')
                    ->label('Fecha del Suplemento')
                    ->nullable()
                    ->native(false),

                Forms\Components\Textarea::make('descripcion')
                    ->label('Descripcion')
                    ->nullable()
                    ->rows(3),

                Forms\Components\FileUpload::make('archivo_suplemento')
                    ->label('Archivo PDF del Suplemento')
                    ->disk('public')
                    ->directory('suplementos')
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(10240)
                    ->downloadable()
                    ->previewable(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('numero_suplemento')
            ->columns([
                Tables\Columns\TextColumn::make('numero_suplemento')
                    ->label('Numero')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('fecha')
                    ->label('Fecha')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('descripcion')
                    ->label('Descripcion')
                    ->limit(50)
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('archivo_suplemento')
                    ->label('Archivo')
                    ->formatStateUsing(fn ($state): string => $state ? 'PDF adjunto' : 'Sin archivo')
                    ->color(fn ($state): string => $state ? 'success' : 'gray'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Actions\CreateAction::make(),
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
                Actions\Action::make('download')
                    ->label('Descargar')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn ($record): string => $record->archivo_suplemento ? asset('storage/' . $record->archivo_suplemento) : '#')
                    ->openUrlInNewTab()
                    ->visible(fn ($record): bool => !empty($record->archivo_suplemento)),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
