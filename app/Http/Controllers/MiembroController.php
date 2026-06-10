<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMiembroRequest;
use App\Http\Requests\UpdateMiembroRequest;
use App\Models\Miembro;
use App\Services\MiembroService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MiembroController extends Controller
{
    public function __construct(
        private MiembroService $miembroService
    ) {}

    public function index(): View
    {
        $miembros = $this->miembroService->listar();
        return view('dashboard.index', compact('miembros'));
    }

    public function create(): View
    {
        return view('miembros.create');
    }

    public function store(StoreMiembroRequest $request): RedirectResponse
    {
        $this->miembroService->crear($request->validated());
        return redirect()->route('dashboard')->with('success', 'Miembro registrado exitosamente.');
    }

    public function edit(Miembro $miembro): View
    {
        return view('miembros.edit', compact('miembro'));
    }

    public function update(UpdateMiembroRequest $request, Miembro $miembro): RedirectResponse
    {
        $this->miembroService->actualizar($miembro, $request->validated());
        return redirect()->route('dashboard')->with('success', 'Miembro actualizado correctamente.');
    }

    public function destroy(Miembro $miembro): RedirectResponse
    {
        $this->miembroService->eliminar($miembro->id);
        return redirect()->route('dashboard')->with('success', 'Miembro eliminado.');
    }

    public function toggleEstado(Miembro $miembro): RedirectResponse|JsonResponse
    {
        $this->miembroService->toggleEstado($miembro);
        $miembro->refresh();

        if (request()->wantsJson()) {
            return response()->json(['activo' => $miembro->activo]);
        }

        return redirect()->route('dashboard')->with('success', 'Estado actualizado correctamente.');
    }
}
