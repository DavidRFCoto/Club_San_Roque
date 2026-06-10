@extends('layouts.app')

@section('title', 'Historial de Asistencias - SIGEF Club')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-2">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-800 flex items-center">
            <i class="bi bi-clock-history mr-2 text-green-600"></i> Historial de Asistencias
        </h2>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('asistencias.index') }}" class="text-sm bg-green-600 text-white hover:bg-green-500 px-3 py-2 rounded flex items-center">
                <i class="bi bi-plus-circle mr-1"></i> Nueva Asistencia
            </a>
            <a href="{{ route('dashboard') }}" class="text-sm text-gray-500 hover:text-gray-700 flex items-center">
                <i class="bi bi-arrow-left mr-1"></i> Dashboard
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
        <form method="GET" action="{{ route('asistencias.historial') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <label for="fecha_desde" class="block text-xs font-medium text-gray-600 mb-1">Fecha Desde</label>
                <input type="date" name="fecha_desde" id="fecha_desde" value="{{ $fechaDesde }}"
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 px-3 py-2 border text-sm">
            </div>
            <div>
                <label for="fecha_hasta" class="block text-xs font-medium text-gray-600 mb-1">Fecha Hasta</label>
                <input type="date" name="fecha_hasta" id="fecha_hasta" value="{{ $fechaHasta }}"
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 px-3 py-2 border text-sm">
            </div>
            <div>
                <label for="nombre" class="block text-xs font-medium text-gray-600 mb-1">Nombre del Miembro</label>
                <input type="text" name="nombre" id="nombre" value="{{ $nombre }}" placeholder="Buscar por nombre..."
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 px-3 py-2 border text-sm">
            </div>
            <div class="flex flex-col sm:flex-row gap-2">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-green-500 flex items-center justify-center">
                    <i class="bi bi-search mr-1"></i> Filtrar
                </button>
                <a href="{{ route('asistencias.historial') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-300 flex items-center justify-center">
                    <i class="bi bi-x-circle mr-1"></i> Limpiar
                </a>
            </div>
        </form>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow mb-6" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)">
            <div class="flex items-center">
                <i class="bi bi-check-circle-fill text-green-500 mr-2"></i>
                <span>{{ session('success') }}</span>
                <button @click="show = false" class="ml-auto"><i class="bi bi-x-lg"></i></button>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase">Fecha</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase">Nombre</th>
                        <th class="px-4 py-3 text-center text-xs font-medium uppercase">Asistio</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($asistencias as $asistencia)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($asistencia->fecha)->format('d/m/Y') }}
                        </td>
                        <td class="px-4 py-3 text-sm font-medium text-gray-900">
                            {{ $asistencia->miembro->nombre ?? 'Eliminado' }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($asistencia->asistio)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="bi bi-check-lg mr-1"></i> Presente
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <i class="bi bi-x-lg mr-1"></i> Ausente
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-4 py-8 text-center text-gray-500">
                            No se encontraron registros de asistencia.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($asistencias->hasPages())
        <div class="px-4 py-3 border-t border-gray-200">
            {{ $asistencias->links() }}
        </div>
        @endif
    </div>
</div>
@endsection