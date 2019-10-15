<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'personas';

    public function estudiante() {
        return $this->hasOne('App\Estudiante', 'persona_id');
    }

    public function docente() {
        return $this->hasOne('App\Docente', 'persona_id');
    }
}
