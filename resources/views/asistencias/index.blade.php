@extends('layouts.app')

@section('title', 'Control de Asistencias - SIGEF Club')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-2">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-800 flex items-center">
            <i class="bi bi-clipboard-check mr-2 text-green-600"></i> Control de Asistencia
        </h2>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('asistencias.historial') }}" class="text-sm bg-green-100 text-green-700 hover:bg-green-200 px-3 py-2 rounded flex items-center">
                <i class="bi bi-clock-history mr-1"></i> Historial
            </a>
            <a href="{{ route('dashboard') }}" class="text-sm text-gray-500 hover:text-gray-700 flex items-center">
                <i class="bi bi-arrow-left mr-1"></i> Dashboard
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form method="POST" action="{{ route('asistencias.store') }}" x-data="{ fecha: '{{ $fecha }}' }">
            @csrf

            <div class="mb-6">
                <label for="fecha" class="block text-sm font-medium text-gray-700 mb-1">Fecha de la Reunion/Actividad:</label>
                <input type="date" name="fecha" id="fecha" x-model="fecha"
                       class="rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 px-3 py-2 border"
                       @change="window.location.href = '{{ route('asistencias.index') }}?fecha=' + $event.target.value">
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="px-4 py-3 text-center text-xs font-medium uppercase w-16">Asistio?</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase">Nombre Completo</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase">Categoria</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($miembros as $miembro)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-center">
                                <input type="checkbox" name="asistencia[]" value="{{ $miembro->id }}"
                                       {{ isset($asistenciasPrevias[$miembro->id]) && $asistenciasPrevias[$miembro->id]->asistio ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-green-600 focus:ring-green-500 h-5 w-5">
                            </td>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                {{ $miembro->nombre }}
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $miembro->categoria ?? 'Sin asignar' }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-4 py-8 text-center text-gray-500">
                                No hay miembros registrados para pasar lista.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(count($miembros) > 0)
            <div class="mt-6 text-center sm:text-right">
                <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center rounded-md bg-green-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-green-500">
                    <i class="bi bi-save mr-2"></i> Guardar Asistencia Completa
                </button>
            </div>
            @endif
        </form>
    </div>
</div>
@endsection
