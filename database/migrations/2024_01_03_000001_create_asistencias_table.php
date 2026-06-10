<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('asistencias')) {
            return;
        }

        Schema::create('asistencias', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->foreignUuid('miembro_id')->constrained('miembros')->cascadeOnDelete();
            $table->date('fecha');
            $table->boolean('asistio')->default(false);
            $table->timestampTz('creado_en')->nullable()->default(DB::raw('now()'));
            $table->unique(['miembro_id', 'fecha']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};
