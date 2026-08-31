<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Consulta de Contratos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', system-ui, -apple-system, sans-serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    {{-- Header --}}
    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="bg-amber-500 p-2 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Consulta de Contratos</h1>
                        <p class="text-sm text-gray-500">Sistema de Gestión de Contratos</p>
                    </div>
                </div>
                <a href="{{ route('filament.admin.auth.login') }}" class="text-sm text-gray-500 hover:text-gray-700 transition-colors">
                    Acceso Admin
                </a>
            </div>
        </div>
    </header>

    {{-- Main Content --}}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Search and Filters --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
            <form action="{{ route('contratos.index') }}" method="GET" class="space-y-4">
                {{-- Search Bar --}}
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                        <div class="relative">
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                placeholder="Buscar por proveedor, número de contrato u objeto..."
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors">
                            <svg class="absolute left-3 top-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Filters --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label for="tipo_contrato" class="block text-sm font-medium text-gray-700 mb-1">Tipo de Contrato</label>
                        <select name="tipo_contrato" id="tipo_contrato"
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                            <option value="">Todos</option>
                            <option value="Prestación de servicios" {{ request('tipo_contrato') == 'Prestación de servicios' ? 'selected' : '' }}>Prestación de servicios</option>
                            <option value="Compra venta" {{ request('tipo_contrato') == 'Compra venta' ? 'selected' : '' }}>Compra venta</option>
                        </select>
                    </div>

                    <div>
                        <label for="dictamen" class="block text-sm font-medium text-gray-700 mb-1">Dictamen</label>
                        <select name="dictamen" id="dictamen"
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                            <option value="">Todos</option>
                            <option value="Aprobado" {{ request('dictamen') == 'Aprobado' ? 'selected' : '' }}>Aprobado</option>
                            <option value="Rechazado" {{ request('dictamen') == 'Rechazado' ? 'selected' : '' }}>Rechazado</option>
                            <option value="En revisión" {{ request('dictamen') == 'En revisión' ? 'selected' : '' }}>En revisión</option>
                            <option value="Pendiente" {{ request('dictamen') == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                        </select>
                    </div>

                    <div>
                        <label for="forma_pago" class="block text-sm font-medium text-gray-700 mb-1">Forma de Pago</label>
                        <select name="forma_pago" id="forma_pago"
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                            <option value="">Todas</option>
                            <option value="Transferencia bancaria" {{ request('forma_pago') == 'Transferencia bancaria' ? 'selected' : '' }}>Transferencia bancaria</option>
                            <option value="Efectivo" {{ request('forma_pago') == 'Efectivo' ? 'selected' : '' }}>Efectivo</option>
                            <option value="Cheque" {{ request('forma_pago') == 'Cheque' ? 'selected' : '' }}>Cheque</option>
                            <option value="Tarjeta de crédito" {{ request('forma_pago') == 'Tarjeta de crédito' ? 'selected' : '' }}>Tarjeta de crédito</option>
                            <option value="Tarjeta de débito" {{ request('forma_pago') == 'Tarjeta de débito' ? 'selected' : '' }}>Tarjeta de débito</option>
                            <option value="Otro" {{ request('forma_pago') == 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                    </div>

                    <div>
                        <label for="fecha_desde" class="block text-sm font-medium text-gray-700 mb-1">Fecha Desde</label>
                        <input type="date" name="fecha_desde" id="fecha_desde" value="{{ request('fecha_desde') }}"
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label for="fecha_hasta" class="block text-sm font-medium text-gray-700 mb-1">Fecha Hasta</label>
                        <input type="date" name="fecha_hasta" id="fecha_hasta" value="{{ request('fecha_hasta') }}"
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                    </div>

                    <div class="flex items-end gap-2 sm:col-span-3">
                        <button type="submit"
                            class="px-6 py-2.5 bg-amber-500 text-white font-medium rounded-lg hover:bg-amber-600 focus:ring-4 focus:ring-amber-300 transition-colors">
                            <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Buscar
                        </button>
                        <a href="{{ route('contratos.index') }}"
                            class="px-6 py-2.5 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-colors">
                            Limpiar
                        </a>
                    </div>
                </div>
            </form>
        </div>

        {{-- Results --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900">Resultados</h2>
                    <span class="text-sm text-gray-500">
                        {{ $contratos->total() }} contrato(s) encontrado(s)
                    </span>
                </div>
            </div>

            @if($contratos->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Proveedor/Cliente</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Contrato</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dictamen</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Firma</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vigencia</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($contratos as $contrato)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $contrato->proveedor_cliente }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($contrato->tipo_contrato == 'Prestación de servicios')
                                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                Prestación de servicios
                                            </span>
                                        @else
                                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                                Compra venta
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $contrato->numero_contrato_proveedor_cliente }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @switch($contrato->dictamen)
                                            @case('Aprobado')
                                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Aprobado</span>
                                                @break
                                            @case('Rechazado')
                                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Rechazado</span>
                                                @break
                                            @case('En revisión')
                                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">En revisión</span>
                                                @break
                                            @default
                                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">{{ $contrato->dictamen ?? 'Pendiente' }}</span>
                                        @endswitch
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $contrato->fecha_firma ? $contrato->fecha_firma->format('d/m/Y') : '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            @if($contrato->fecha_inicio_vigencia && $contrato->fecha_fin_vigencia)
                                                {{ $contrato->fecha_inicio_vigencia->format('d/m/Y') }} - {{ $contrato->fecha_fin_vigencia->format('d/m/Y') }}
                                            @elseif($contrato->fecha_inicio_vigencia)
                                                Desde {{ $contrato->fecha_inicio_vigencia->format('d/m/Y') }}
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('contratos.show', $contrato) }}"
                                                class="inline-flex items-center px-3 py-1.5 bg-gray-100 text-gray-700 text-xs font-medium rounded-lg hover:bg-gray-200 transition-colors">
                                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                Ver
                                            </a>
                                            @if($contrato->archivo_contrato)
                                                <a href="{{ route('contratos.download', $contrato) }}"
                                                    class="inline-flex items-center px-3 py-1.5 bg-amber-500 text-white text-xs font-medium rounded-lg hover:bg-amber-600 transition-colors">
                                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                                    </svg>
                                                    PDF
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $contratos->links() }}
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No se encontraron contratos</h3>
                    <p class="mt-1 text-sm text-gray-500">Intenta con otros términos de búsqueda o filtros.</p>
                    <div class="mt-6">
                        <a href="{{ route('contratos.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-amber-500 text-white font-medium rounded-lg hover:bg-amber-600 transition-colors">
                            Limpiar filtros
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </main>

    {{-- Footer --}}
    <footer class="mt-12 border-t border-gray-200 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <p class="text-center text-sm text-gray-500">
                © {{ date('Y') }} Sistema de Gestión de Contratos. Todos los derechos reservados.
            </p>
        </div>
    </footer>
</body>
</html>
