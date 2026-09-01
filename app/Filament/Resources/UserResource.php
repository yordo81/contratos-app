<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\Rol;
use App\Models\User;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-users';
    }

    public static function getNavigationLabel(): string
    {
        return 'Usuarios';
    }

    public static function getModelLabel(): string
    {
        return 'Usuario';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Usuarios';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Gestión de Usuarios';
    }

    public static function getNavigationSort(): int
    {
        return 2;
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
                Section::make('Información del Usuario')
                    ->icon('heroicon-o-user')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nombre')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Nombre completo'),

                        Forms\Components\TextInput::make('email')
                            ->label('Correo Electrónico')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->placeholder('usuario@ejemplo.com'),

                        Forms\Components\Select::make('role_id')
                            ->label('Rol')
                            ->options(fn () => Rol::pluck('nombre', 'id'))
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->placeholder('Seleccionar rol'),

                        Section::make('Contraseña')
                            ->icon('heroicon-o-key')
                            ->schema([
                                Forms\Components\TextInput::make('password')
                                    ->label('Contraseña')
                                    ->password()
                                    ->revealable()
                                    ->required(fn (string $operation): bool => $operation === 'create')
                                    ->rules([
                                        Password::min(8)
                                            ->mixedCase()
                                            ->numbers()
                                            ->symbols(),
                                    ])
                                    ->dehydrated(fn ($state): bool => filled($state))
                                    ->dehydrateStateUsing(fn ($state): string => Hash::make($state))
                                    ->placeholder('Mín. 8 caracteres, mayúsc., minúsc., número y símbolo'),

                                Forms\Components\TextInput::make('password_confirmation')
                                    ->label('Confirmar Contraseña')
                                    ->password()
                                    ->revealable()
                                    ->same('password')
                                    ->dehydrated(false),
                            ])
                            ->columns(2),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Correo')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('role.nombre')
                    ->label('Rol')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'Administrador' => 'danger',
                        'Editor' => 'warning',
                        'Consultor' => 'info',
                        default => 'gray',
                    })
                    ->sortable(),

                Tables\Columns\IconColumn::make('email_verified_at')
                    ->label('Verificado')
                    ->boolean()
                    ->getStateUsing(fn ($record): bool => $record->email_verified_at !== null)
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role_id')
                    ->label('Rol')
                    ->options(fn () => Rol::pluck('nombre', 'id'))
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Actions\EditAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
