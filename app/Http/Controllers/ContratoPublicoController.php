<?php

namespace App\Http\Controllers;

use App\Models\Contrato;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ContratoPublicoController extends Controller
{
    public function index(Request $request)
    {
        $query = Contrato::with(['tipoContrato', 'formaPago', 'suplementos']);

        // Búsqueda por texto general
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('proveedor_cliente', 'LIKE', "%{$search}%")
                    ->orWhere('numero_contrato_proveedor_cliente', 'LIKE', "%{$search}%")
                    ->orWhere('objeto_contrato', 'LIKE', "%{$search}%");
            });
        }

        // Filtro por tipo de contrato (ahora por ID)
        if ($tipoContratoId = $request->input('tipo_contrato_id')) {
            $query->where('tipo_contrato_id', $tipoContratoId);
        }

        // Filtro por dictamen
        if ($dictamen = $request->input('dictamen')) {
            $query->where('dictamen', $dictamen);
        }

        // Filtro por forma de pago (ahora por ID)
        if ($formaPagoId = $request->input('forma_pago_id')) {
            $query->where('forma_pago_id', $formaPagoId);
        }

        // Filtro por rango de fechas de firma
        if ($fechaDesde = $request->input('fecha_desde')) {
            $query->whereDate('fecha_firma', '>=', $fechaDesde);
        }

        if ($fechaHasta = $request->input('fecha_hasta')) {
            $query->whereDate('fecha_firma', '<=', $fechaHasta);
        }

        $contratos = $query->latest('fecha_firma')->paginate(15)->withQueryString();

        return view('contratos.index', compact('contratos'));
    }

    public function show(Contrato $contrato)
    {
        $contrato->load(['tipoContrato', 'formaPago', 'suplementos']);

        return view('contratos.show', compact('contrato'));
    }

    public function downloadContrato(Contrato $contrato): Response
    {
        if (!$contrato->archivo_contrato) {
            abort(404, 'No hay archivo adjunto para este contrato.');
        }

        $path = $contrato->archivo_contrato;

        if (!Storage::disk('public')->exists($path)) {
            abort(404, 'El archivo no se encuentra en el servidor.');
        }

        $filename = 'contrato_' . $contrato->numero_contrato_proveedor_cliente . '.pdf';

        return Storage::disk('public')->download($path, $filename);
    }

    public function downloadSuplemento($suplementoId): Response
    {
        $suplemento = \App\Models\Suplemento::findOrFail($suplementoId);

        if (!$suplemento->archivo_suplemento) {
            abort(404, 'No hay archivo adjunto para este suplemento.');
        }

        $path = $suplemento->archivo_suplemento;

        if (!Storage::disk('public')->exists($path)) {
            abort(404, 'El archivo no se encuentra en el servidor.');
        }

        $filename = 'suplemento_' . $suplemento->numero_suplemento . '.pdf';

        return Storage::disk('public')->download($path, $filename);
    }
}
