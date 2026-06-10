@extends('layouts.app')

@section('title', 'Iniciar Sesion - SIGEF Club')

@section('content')
<div class="flex min-h-full items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md space-y-8">
        <div class="text-center">
            <i class="bi bi-shield-check text-green-600 text-5xl"></i>
            <h2 class="mt-4 text-3xl font-bold tracking-tight text-gray-900">Club de San Roque</h2>
        </div>

        <div class="bg-white py-8 px-6 shadow-xl rounded-xl">
            <form class="space-y-6" method="POST" action="{{ route('login') }}">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        <i class="bi bi-envelope mr-1"></i> Correo Electronico
                    </label>
                    <input id="email" name="email" type="email" autocomplete="email" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 px-3 py-2 border"
                           placeholder="admin@club.com" value="{{ old('email') }}">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        <i class="bi bi-lock mr-1"></i> Contrasena
                    </label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 px-3 py-2 border"
                           placeholder="********">
                </div>

                <button type="submit"
                        class="w-full flex justify-center rounded-md bg-green-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-green-500">
                    <i class="bi bi-box-arrow-in-right mr-2"></i> Ingresar
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
