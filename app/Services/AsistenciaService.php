<?php

namespace App\Services;

use App\Models\Asistencia;
use App\Models\Miembro;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class AsistenciaService
{
    public function obtenerPorFecha(string $fecha): Collection
    {
        return Asistencia::whereDate('fecha', $fecha)->get()->keyBy('miembro_id');
    }

    public function guardarAsistencias(string $fecha, array $asistieronIds): void
    {
        $miembros = Miembro::all();

        foreach ($miembros as $miembro) {
            Asistencia::updateOrCreate(
                ['miembro_id' => $miembro->id, 'fecha' => $fecha],
                ['asistio' => in_array($miembro->id, $asistieronIds)]
            );
        }
    }

    public function listarFechas(): Collection
    {
        return Asistencia::selectRaw('fecha, COUNT(*) as total, SUM(CASE WHEN asistio THEN 1 ELSE 0 END) as presentes')
            ->groupBy('fecha')
            ->orderBy('fecha', 'desc')
            ->get();
    }

    public function obtenerHistorial($fechaDesde = null, $fechaHasta = null, $nombre = null, $porPagina = 15): LengthAwarePaginator
    {
        $query = Asistencia::with('miembro')
            ->orderBy('fecha', 'desc')
            ->orderBy('miembro_id');

        if ($fechaDesde) {
            $query->whereDate('fecha', '>=', $fechaDesde);
        }

        if ($fechaHasta) {
            $query->whereDate('fecha', '<=', $fechaHasta);
        }

        if ($nombre) {
            $query->whereHas('miembro', function ($q) use ($nombre) {
                $q->where('nombre', 'ilike', "%{$nombre}%");
            });
        }

        return $query->paginate($porPagina);
    }
}
