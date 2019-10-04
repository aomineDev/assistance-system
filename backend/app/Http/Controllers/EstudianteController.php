<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Estudiante;
use App\Persona;

class EstudianteController extends Controller
{
    public function index($id) {
        $estudiante = Estudiante::find($id);
        $semestre = $estudiante->semestre;
        $persona = $estudiante->persona;
        return response()->json([
            'id' => $estudiante->id,
            'nombre_completo' => $persona->nombre_completo,
            'semestre' => $semestre->nombre
        ]);
    }
}
