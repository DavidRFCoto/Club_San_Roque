<?php

namespace App\Services;

use App\Models\Miembro;
use Carbon\Carbon;

class MiembroService
{
    public function calcularCategoria(string $fechaNacimiento): string
    {
        $edad = Carbon::parse($fechaNacimiento)->age;

        return match (true) {
            $edad >= 0 && $edad <= 5 => 'Castorcitos',
            $edad >= 6 && $edad <= 9 => 'Aventureros',
            $edad >= 10 && $edad <= 15 => 'Conquistadores',
            $edad >= 16 => 'Consejeros',
            default => 'Fuera de rango',
        };
    }

    public function crear(array $datos): Miembro
    {
        $datos['categoria'] = $this->calcularCategoria($datos['fecha_nacimiento']);
        return Miembro::create($datos);
    }

    public function actualizar(Miembro $miembro, array $datos): bool
    {
        if (isset($datos['fecha_nacimiento'])) {
            $datos['categoria'] = $this->calcularCategoria($datos['fecha_nacimiento']);
        }
        return $miembro->update($datos);
    }

    public function toggleEstado(Miembro $miembro): bool
    {
        return $miembro->update(['activo' => !$miembro->activo]);
    }

    public function listar()
    {
        return Miembro::orderBy('creado_en', 'desc')->get();
    }

    public function obtenerPorId(string $id): ?Miembro
    {
        return Miembro::find($id);
    }

    public function eliminar(string $id): bool
    {
        return Miembro::destroy($id) > 0;
    }
}
