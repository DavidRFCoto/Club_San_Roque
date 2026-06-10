<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('miembros')) {
            return;
        }

        Schema::create('miembros', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->string('nombre');
            $table->date('fecha_nacimiento');
            $table->string('sexo');
            $table->string('categoria')->default('Consejero');
            $table->boolean('activo')->default(true);
            $table->timestampTz('creado_en')->nullable()->default(DB::raw('now()'));
            $table->timestampTz('actualizado_en')->nullable()->default(DB::raw('now()'));
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('miembros');
    }
};
