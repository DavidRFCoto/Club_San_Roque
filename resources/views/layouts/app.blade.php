<!DOCTYPE html>
<html lang="es" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIGEF-Club')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="h-full">
    <div class="min-h-full">
        @if(session()->has('supabase_user'))
            @include('partials.navbar')
        @endif

        <main>
            @if(session('success'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)">
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow" role="alert">
                        <div class="flex items-center">
                            <i class="bi bi-check-circle-fill text-green-500 mr-2"></i>
                            <span>{{ session('success') }}</span>
                            <button @click="show = false" class="ml-auto"><i class="bi bi-x-lg"></i></button>
                        </div>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow" role="alert">
                        <div class="flex items-center">
                            <i class="bi bi-exclamation-triangle-fill text-red-500 mr-2"></i>
                            <span>{{ $errors->first() }}</span>
                        </div>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
