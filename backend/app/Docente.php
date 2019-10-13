<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    protected $table = 'docentes';

    public function persona() {
        return $this->belongsTo('App\Persona');
    }
}
