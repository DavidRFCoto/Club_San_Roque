<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Miembro extends Model
{
    use HasUuids;

    protected $table = 'miembros';

    protected $fillable = [
        'nombre',
        'fecha_nacimiento',
        'sexo',
        'categoria',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'fecha_nacimiento' => 'date',
    ];

    public $timestamps = false;

    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'miembro_id');
    }
}
