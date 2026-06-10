@extends('layouts.app')

@section('title', 'Dashboard - SIGEF Club')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6"
     x-data="{
         search: '',
         estado: 'todos',
         categoria: 'todos',
         miembros: {{ json_encode($miembros->map(fn($m) => [
             'id' => $m->id,
             'nombre' => $m->nombre,
             'fecha_nacimiento' => $m->fecha_nacimiento?->format('d/m/Y'),
             'categoria' => $m->categoria,
             'activo' => $m->activo,
             'estado' => $m->activo ? 'activo' : 'inactivo',
         ])) }}
     }">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <input type="text" x-model="search" placeholder="Buscar por nombre..."
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 px-3 py-2 border">
            </div>
            <div>
                <select x-model="estado" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 px-3 py-2 border">
                    <option value="todos">Todos los Estados</option>
                    <option value="activo">Activo</option>
                    <option value="inactivo">Inactivo</option>
                </select>
            </div>
            <div>
                <select x-model="categoria" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 px-3 py-2 border">
                    <option value="todos">Todas las Categorias</option>
                    <option value="Castorcitos">Castorcitos</option>
                    <option value="Aventureros">Aventureros</option>
                    <option value="Conquistadores">Conquistadores</option>
                    <option value="Consejeros">Consejeros</option>
                </select>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-green-700 flex items-center">
                <i class="bi bi-people mr-2"></i> Gestion de Miembros
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase">Nombre</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase">Fecha Nac.</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase">Categoria</th>
                        <th class="px-4 py-3 text-center text-xs font-medium uppercase">Estado</th>
                        <th class="px-4 py-3 text-center text-xs font-medium uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    <template x-for="m in miembros" :key="m.id">
                        <tr x-show="m.nombre.toLowerCase().includes(search.toLowerCase())
                                    && (estado === 'todos' || m.estado === estado)
                                    && (categoria === 'todos' || m.categoria === categoria)"
                            class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm font-medium text-gray-900" x-text="m.nombre"></td>
                            <td class="px-4 py-3 text-sm text-gray-500" x-text="m.fecha_nacimiento"></td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800" x-text="m.categoria"></span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span :class="m.activo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                                      class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium">
                                    <i :class="m.activo ? 'bi-check-circle' : 'bi-x-circle'" class="mr-1"></i>
                                    <span x-text="m.activo ? 'Activo' : 'Inactivo'"></span>
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex justify-center space-x-2">
                                    <a :href="`{{ route('miembros.edit', ':miembro') }}`.replace(':miembro', m.id)"
                                       class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-yellow-700 bg-yellow-100 hover:bg-yellow-200">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form :action="`{{ route('miembros.destroy', ':miembro') }}`.replace(':miembro', m.id)" method="POST" class="inline"
                                          onsubmit="return confirm('Eliminar miembro?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-red-700 bg-red-100 hover:bg-red-200">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    </template>
                    <tr x-show="miembros.length === 0 || !miembros.some(m => m.nombre.toLowerCase().includes(search.toLowerCase()))">
                        <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                            No se encontraron registros.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

