<nav class="bg-green-700 shadow" x-data="{ open: false }">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="text-white font-bold text-lg flex items-center">
                    <i class="bi bi-shield-check mr-2"></i> Club de San Roque
                </a>
            </div>

            <div class="hidden md:flex items-center space-x-6 lg:space-x-8">
                <a href="{{ route('dashboard') }}" class="text-white hover:bg-green-600 px-3 py-2 rounded text-sm font-medium flex items-center transition-colors">
                    <i class="bi bi-speedometer2 mr-1"></i> Dashboard
                </a>
                <a href="{{ route('asistencias.index') }}" class="text-white hover:bg-green-600 px-3 py-2 rounded text-sm font-medium flex items-center transition-colors">
                    <i class="bi bi-clipboard-check mr-1"></i> Asistencias
                </a>
                <a href="{{ route('asistencias.historial') }}" class="text-white hover:bg-green-600 px-3 py-2 rounded text-sm font-medium flex items-center transition-colors">
                    <i class="bi bi-clock-history mr-1"></i> Historial
                </a>
                <a href="{{ route('miembros.create') }}" class="text-white hover:bg-green-600 px-3 py-2 rounded text-sm font-medium flex items-center transition-colors">
                    <i class="bi bi-person-plus mr-1"></i> Nuevo Registro
                </a>
            </div>

            <div class="hidden md:flex items-center space-x-4">
                <span class="text-white text-sm flex items-center">
                    <i class="bi bi-person-circle mr-1"></i> {{ session('supabase_user.nombre') ?? 'Admin' }}
                </span>
                <a href="{{ route('admin.register') }}" class="text-white hover:bg-green-600 px-2 py-1 rounded text-xs flex items-center" title="Registrar Admin">
                    <i class="bi bi-shield-lock"></i>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-white bg-green-600 hover:bg-green-500 px-3 py-1.5 rounded text-sm flex items-center">
                        <i class="bi bi-box-arrow-right mr-1"></i> Salir
                    </button>
                </form>
            </div>

            <button @click="open = !open" class="md:hidden text-white p-2 focus:outline-none">
                <i class="bi bi-list text-2xl"></i>
            </button>
        </div>

        <div x-show="open" @click.away="open = false" class="md:hidden pb-3 space-y-1">
            <a href="{{ route('dashboard') }}" class="text-white hover:bg-green-600 block px-3 py-2 rounded text-sm font-medium flex items-center">
                <i class="bi bi-speedometer2 mr-1"></i> Dashboard
            </a>
            <a href="{{ route('asistencias.index') }}" class="text-white hover:bg-green-600 block px-3 py-2 rounded text-sm font-medium flex items-center">
                <i class="bi bi-clipboard-check mr-1"></i> Asistencias
            </a>
            <a href="{{ route('asistencias.historial') }}" class="text-white hover:bg-green-600 block px-3 py-2 rounded text-sm font-medium flex items-center">
                <i class="bi bi-clock-history mr-1"></i> Historial
            </a>
            <a href="{{ route('miembros.create') }}" class="text-white hover:bg-green-600 block px-3 py-2 rounded text-sm font-medium flex items-center">
                <i class="bi bi-person-plus mr-1"></i> Nuevo Registro
            </a>
            <div class="pt-2 border-t border-green-600">
                <span class="text-white text-sm block px-3 py-1">
                    <i class="bi bi-person-circle mr-1"></i> {{ session('supabase_user.nombre') ?? 'Admin' }}
                </span>
                <a href="{{ route('admin.register') }}" class="text-white hover:bg-green-600 block px-3 py-2 rounded text-sm">
                    <i class="bi bi-shield-lock mr-1"></i> Registrar Admin
                </a>
                <form method="POST" action="{{ route('logout') }}" class="block px-3 py-1">
                    @csrf
                    <button type="submit" class="text-white bg-green-600 hover:bg-green-500 px-3 py-1.5 rounded text-sm w-full text-left flex items-center">
                        <i class="bi bi-box-arrow-right mr-1"></i> Salir
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
