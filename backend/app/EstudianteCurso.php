<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstudianteCurso extends Model
{
    protected $table = 'estudiantes_cursos';

    public function estudiante() {
        return $this->belongsTo('App\Estudiante');
    }

    public function curso() {
        return $this->belongsTo('App\Curso');
    }
}
