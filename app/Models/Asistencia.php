<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasUuids;

    protected $table = 'asistencias';

    protected $fillable = [
        'miembro_id',
        'fecha',
        'asistio',
    ];

    protected $casts = [
        'asistio' => 'boolean',
        'fecha' => 'date',
    ];

    public $timestamps = false;

    const CREATED_AT = 'creado_en';
    const UPDATED_AT = null;

    public function miembro()
    {
        return $this->belongsTo(Miembro::class, 'miembro_id');
    }
}
