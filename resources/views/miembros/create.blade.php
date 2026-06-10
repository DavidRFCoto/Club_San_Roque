@extends('layouts.app')

@section('title', 'Registrar Miembro - SIGEF Club')

@section('content')
<div class="max-w-lg mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 bg-green-700 text-white">
            <h3 class="text-lg font-semibold flex items-center">
                <i class="bi bi-person-plus mr-2"></i> Club de San Roque
            </h3>
            <p class="text-sm text-green-200">Registro de Miembros</p>
        </div>

        <form class="p-6 space-y-5" method="POST" action="{{ route('miembros.store') }}">
            @csrf

            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre Completo</label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 px-3 py-2 border"
                       placeholder="Ej. Katya Hernandez">
            </div>

            <div>
                <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700">Fecha de Nacimiento</label>
                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 px-3 py-2 border">
            </div>

            <div>
                <label for="sexo" class="block text-sm font-medium text-gray-700">Sexo</label>
                <select name="sexo" id="sexo"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 px-3 py-2 border">
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                </select>
            </div>

            <div class="flex flex-col space-y-3">
                <button type="submit" class="w-full flex justify-center items-center rounded-md bg-green-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-green-500">
                    <i class="bi bi-cloud-upload mr-2"></i> Guardar en Supabase
                </button>
                <a href="{{ route('dashboard') }}" class="w-full text-center text-sm text-gray-500 hover:text-gray-700">
                    Ver lista de miembros
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
