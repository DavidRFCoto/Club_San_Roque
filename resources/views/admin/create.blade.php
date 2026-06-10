@extends('layouts.app')

@section('title', 'Registrar Administrador - SIGEF Club')

@section('content')
<div class="max-w-lg mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 bg-gray-800 text-white">
            <h3 class="text-lg font-semibold flex items-center">
                <i class="bi bi-shield-lock mr-2"></i> Registrar Administrador
            </h3>
        </div>

        <form class="p-6 space-y-5" method="POST" action="{{ route('admin.register') }}">
            @csrf

            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre Completo</label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 px-3 py-2 border">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Correo Electronico</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 px-3 py-2 border">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Contrasena</label>
                <input type="password" name="password" id="password" required minlength="6"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 px-3 py-2 border">
            </div>

            <div>
                <label for="rol" class="block text-sm font-medium text-gray-700">Rol</label>
                <select name="rol" id="rol"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 px-3 py-2 border">
                    <option value="administrador">Administrador</option>
                    <option value="director">Director</option>
                </select>
            </div>

            <button type="submit" class="w-full flex justify-center items-center rounded-md bg-gray-800 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-gray-700">
                <i class="bi bi-person-badge mr-2"></i> Registrar Administrador
            </button>
        </form>
    </div>
</div>
@endsection
