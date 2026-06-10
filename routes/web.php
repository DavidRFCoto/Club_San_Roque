<?php

use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\Auth\SupabaseAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MiembroController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

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
