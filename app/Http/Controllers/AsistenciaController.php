<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAsistenciaRequest;
use App\Models\Miembro;
use App\Services\AsistenciaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AsistenciaController extends Controller
{
    public function __construct(
        private AsistenciaService $asistenciaService
    ) {}

    public function index(Request $request): View
    {
        $fecha = $request->get('fecha', date('Y-m-d'));
        $miembros = Miembro::orderBy('nombre')->get();
        $asistenciasPrevias = $this->asistenciaService->obtenerPorFecha($fecha);

        return view('asistencias.index', compact('miembros', 'asistenciasPrevias', 'fecha'));
    }

    public function store(StoreAsistenciaRequest $request): RedirectResponse
    {
        $this->asistenciaService->guardarAsistencias(
            $request->input('fecha'),
            $request->input('asistencia', [])
        );

        return redirect()->route('asistencias.index', ['fecha' => $request->input('fecha')])
            ->with('success', 'Asistencia procesada exitosamente.');
    }

    public function historial(Request $request): View
    {
        $fechaDesde = $request->get('fecha_desde');
        $fechaHasta = $request->get('fecha_hasta');
        $nombre = $request->get('nombre');
        $fechas = $this->asistenciaService->listarFechas();
        $asistencias = $this->asistenciaService->obtenerHistorial($fechaDesde, $fechaHasta, $nombre);

        return view('asistencias.historial', compact('asistencias', 'fechas', 'fechaDesde', 'fechaHasta', 'nombre'));
    }
}
