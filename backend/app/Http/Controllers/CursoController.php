<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Curso;

class CursoController extends Controller
{
    public function index($id) {
        $curso = Curso::find($id);
        $semestre = $curso->semestre;

        return response()->json([
            'id' => $curso->id,
            'nombre' => $curso->nombre,
            'codigo' => $curso->codigo,
            'semestre_id' => $semestre->id,
            'semestre' => $semestre->nombre
        ]);
    }
}
