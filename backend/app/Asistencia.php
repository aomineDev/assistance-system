<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $table = 'asistencias';

    public function curso() {
        return $this->belongsTo('App\Curso');
    }

    public function docente() {
        return $this->belongsTo('App\Docente');
    }

    public function estudiantes() {
        return $this->hasMany('App\EstudianteAsistencia', 'asistencia_id');
    }
}
