<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $table = 'cursos';

    public function semestre() {
        return $this->belongsTo('App\Semestre');
    }
}
