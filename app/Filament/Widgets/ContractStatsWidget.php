<?php

namespace App\Filament\Widgets;

use App\Models\Contrato;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class ContractStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 0;

    protected int | string | array $columnSpan = 'full';

    /**
     * Date range filter properties (Livewire-bound).
     */
    public ?string $fechaDesde = null;
    public ?string $fechaHasta = null;

    /**
     * Reset cached stats when filters change.
     */
    public function updatedFechaDesde(): void
    {
        $this->cachedStats = null;
    }

    public function updatedFechaHasta(): void
    {
        $this->cachedStats = null;
    }

    public function resetFilters(): void
    {
        $this->fechaDesde = null;
        $this->fechaHasta = null;
        $this->cachedStats = null;
    }

    /**
     * Apply date range filter to a query.
     */
    protected function applyDateFilter($query): void
    {
        if ($this->fechaDesde) {
            $query->whereDate('fecha_firma', '>=', $this->fechaDesde);
        }
        if ($this->fechaHasta) {
            $query->whereDate('fecha_firma', '<=', $this->fechaHasta);
        }
    }

    /**
     * Check if any filter is active.
     */
    public function hasActiveFilters(): bool
    {
        return filled($this->fechaDesde) || filled($this->fechaHasta);
    }

    /**
     * Get the filter label for display.
     */
    public function getFilterLabel(): string
    {
        if (!$this->hasActiveFilters()) {
            return 'Todos los contratos';
        }

        $desde = $this->fechaDesde ? Carbon::parse($this->fechaDesde)->format('d/m/Y') : '...';
        $hasta = $this->fechaHasta ? Carbon::parse($this->fechaHasta)->format('d/m/Y') : '...';

        return "Del {$desde} al {$hasta}";
    }

    /**
     * Override to render filter bar + stats.
     */
    public function content(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make()
                    ->heading($this->getHeading())
                    ->description($this->getDescription())
                    ->icon('heroicon-o-funnel')
                    ->schema([
                        \Filament\Schemas\Components\Grid::make(3)
                            ->schema([
                                \Filament\Forms\Components\DatePicker::make('fechaDesde')
                                    ->label('Fecha Desde')
                                    ->native(false)
                                    ->placeholder('Desde')
                                    ->dehydrated()
                                    ->reactive()
                                    ->afterStateUpdated(fn () => $this->cachedStats = null),

                                \Filament\Forms\Components\DatePicker::make('fechaHasta')
                                    ->label('Fecha Hasta')
                                    ->native(false)
                                    ->placeholder('Hasta')
                                    ->dehydrated()
                                    ->reactive()
                                    ->afterStateUpdated(fn () => $this->cachedStats = null),

                                \Filament\Forms\Components\Placeholder::make('filter_status')
                                    ->label('Filtro activo')
                                    ->content(fn () => $this->getFilterLabel())
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->collapsible(),

                \Filament\Schemas\Components\Section::make()
                    ->schema($this->getCachedStats())
                    ->columns($this->getColumns())
                    ->contained(false)
                    ->gridContainer(),
            ]);
    }

    /**
     * Get the heading with filter context.
     */
    protected function getHeading(): ?string
    {
        return 'Estadísticas de Contratos';
    }

    protected function getStats(): array
    {
        // Base query with date filter
        $baseQuery = Contrato::query();
        $this->applyDateFilter($baseQuery);

        $totalContratos = (clone $baseQuery)->count();

        $aprobados = (clone $baseQuery)->where('dictamen', 'Aprobado')->count();
        $enRevision = (clone $baseQuery)->where('dictamen', 'En revisión')->count();
        $pendientes = (clone $baseQuery)->where('dictamen', 'Pendiente')->count();
        $rechazados = (clone $baseQuery)->where('dictamen', 'Rechazado')->count();

        // Vigentes uses its own date logic (based on vigencia, not firma)
        $vigentesQuery = Contrato::query();
        if ($this->fechaDesde) {
            $vigentesQuery->whereDate('fecha_firma', '>=', $this->fechaDesde);
        }
        if ($this->fechaHasta) {
            $vigentesQuery->whereDate('fecha_firma', '<=', $this->fechaHasta);
        }
        $vigentes = $vigentesQuery
            ->whereDate('fecha_firma', '<=', Carbon::now())
            ->where(function ($query) {
                $query->whereNull('fecha_fin_vigencia')
                    ->orWhereDate('fecha_fin_vigencia', '>=', Carbon::now());
            })
            ->count();

        $porVencerQuery = Contrato::query();
        if ($this->fechaDesde) {
            $porVencerQuery->whereDate('fecha_fin_vigencia', '>=', $this->fechaDesde);
        }
        if ($this->fechaHasta) {
            $porVencerQuery->whereDate('fecha_fin_vigencia', '<=', $this->fechaHasta);
        }
        $porVencer = $porVencerQuery
            ->whereDate('fecha_fin_vigencia', '>=', Carbon::now())
            ->whereDate('fecha_fin_vigencia', '<=', Carbon::now()->addDays(30))
            ->count();

        // Suplementos count
        $suplementosQuery = Contrato::query();
        $this->applyDateFilter($suplementosQuery);
        $totalSuplementos = $suplementosQuery->withCount('suplementos')
            ->get()
            ->sum('suplementos_count');

        // Active filter label
        $filterLabel = $this->hasActiveFilters() ? $this->getFilterLabel() : 'Todos los contratos';

        return [
            Stat::make('Total Contratos', $totalContratos)
                ->description($filterLabel)
                ->descriptionIcon('heroicon-o-document-text')
                ->color('primary'),

            Stat::make('Aprobados', $aprobados)
                ->description($totalContratos > 0 ? round(($aprobados / $totalContratos) * 100) . '% del total' : 'Sin datos')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),

            Stat::make('En Revisión', $enRevision)
                ->description("Pendientes: {$pendientes} · Rechazados: {$rechazados}")
                ->descriptionIcon('heroicon-o-clock')
                ->color('warning'),

            Stat::make('Vigentes', $vigentes)
                ->description($porVencer > 0 ? "{$porVencer} por vencer en 30 días" : 'Ninguno por vencer pronto')
                ->descriptionIcon('heroicon-o-shield-check')
                ->color($porVencer > 0 ? 'warning' : 'success'),

            Stat::make('Suplementos', $totalSuplementos)
                ->description('Total de suplementos adjuntos')
                ->descriptionIcon('heroicon-o-paper-clip')
                ->color('gray'),
        ];
    }
}
