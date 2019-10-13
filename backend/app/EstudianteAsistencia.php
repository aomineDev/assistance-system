<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstudianteAsistencia extends Model
{
    protected $table = 'estudiantes_asistencias';

    public function estudiante() {
        return $this->belongsTo('App\Estudiante');
    }
}
