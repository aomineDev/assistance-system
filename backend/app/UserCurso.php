<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCurso extends Model
{
    protected $table = 'users_cursos';

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function curso() {
        return $this->belongsTo('App\Curso');
    }
}
