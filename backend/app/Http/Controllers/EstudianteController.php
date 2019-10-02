<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Estudiante;

class EstudianteController extends Controller
{
    public function index() {
        $estudiante = Estudiante::find(1);
        $semestre = $estudiante->semestre;
        $name = $estudiante->persona;
        return response()->json(
            $estudiante
        );
    }
}
