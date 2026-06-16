<?php

use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\Auth\SupabaseAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MiembroController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::get('/debug-config', function () {
    return response()->json([
        'supabase_url' => config('services.supabase.url'),
        'supabase_anon_key_length' => strlen(config('services.supabase.anon_key') ?? ''),
        'supabase_service_key_length' => strlen(config('services.supabase.service_key') ?? ''),
        'db_connection' => config('database.default'),
        'db_host' => config('database.connections.pgsql.host'),
        'db_username' => config('database.connections.pgsql.username'),
        'app_debug' => config('app.debug'),
        'app_env' => config('app.env'),
    ]);
});

Route::get('/login', [SupabaseAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [SupabaseAuthController::class, 'login']);
Route::post('/logout', [SupabaseAuthController::class, 'logout'])->name('logout');

Route::middleware('supabase.auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/miembros/crear', [MiembroController::class, 'create'])->name('miembros.create');
    Route::post('/miembros', [MiembroController::class, 'store'])->name('miembros.store');
    Route::get('/miembros/{miembro}/editar', [MiembroController::class, 'edit'])->name('miembros.edit');
    Route::put('/miembros/{miembro}', [MiembroController::class, 'update'])->name('miembros.update');
    Route::delete('/miembros/{miembro}', [MiembroController::class, 'destroy'])->name('miembros.destroy');
    Route::patch('/miembros/{miembro}/estado', [MiembroController::class, 'toggleEstado'])->name('miembros.toggle-estado');

    Route::get('/asistencias', [AsistenciaController::class, 'index'])->name('asistencias.index');
    Route::post('/asistencias', [AsistenciaController::class, 'store'])->name('asistencias.store');
    Route::get('/asistencias/historial', [AsistenciaController::class, 'historial'])->name('asistencias.historial');

    Route::get('/admin/register', [SupabaseAuthController::class, 'showRegisterForm'])->name('admin.register');
    Route::post('/admin/register', [SupabaseAuthController::class, 'register']);
});
