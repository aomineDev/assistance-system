<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $table = 'asistencias';

    public function curso() {
        return $this->belongsTo('App\Curso');
    }
}
