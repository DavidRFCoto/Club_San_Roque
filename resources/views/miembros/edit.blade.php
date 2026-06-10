@extends('layouts.app')

@section('title', 'Editar Miembro - SIGEF Club')

@section('content')
<div class="max-w-lg mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 bg-yellow-600 text-white">
            <h3 class="text-lg font-semibold flex items-center">
                <i class="bi bi-pencil-square mr-2"></i> Modificar Miembro
            </h3>
        </div>

        <form class="p-6 space-y-5" method="POST" action="{{ route('miembros.update', $miembro) }}">
            @csrf
            @method('PUT')

            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre Completo</label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $miembro->nombre) }}" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500 px-3 py-2 border">
            </div>

            <div>
                <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700">Fecha de Nacimiento</label>
                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento"
                       value="{{ old('fecha_nacimiento', $miembro->fecha_nacimiento?->format('Y-m-d')) }}" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500 px-3 py-2 border">
            </div>

            <div>
                <label for="sexo" class="block text-sm font-medium text-gray-700">Sexo</label>
                <select name="sexo" id="sexo"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500 px-3 py-2 border">
                    <option value="Masculino" {{ $miembro->sexo === 'Masculino' ? 'selected' : '' }}>Masculino</option>
                    <option value="Femenino" {{ $miembro->sexo === 'Femenino' ? 'selected' : '' }}>Femenino</option>
                </select>
            </div>

            <div>
                <label for="activo" class="block text-sm font-medium text-gray-700">Estado</label>
                <select name="activo" id="activo"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500 px-3 py-2 border">
                    <option value="1" {{ $miembro->activo ? 'selected' : '' }}>Activo</option>
                    <option value="0" {{ !$miembro->activo ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>

            <div class="flex flex-col space-y-3">
                <button type="submit" class="w-full flex justify-center items-center rounded-md bg-yellow-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-yellow-500">
                    <i class="bi bi-save mr-2"></i> Actualizar Informacion
                </button>
                <a href="{{ route('dashboard') }}" class="w-full text-center text-sm text-gray-500 hover:text-gray-700">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
