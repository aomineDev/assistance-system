<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EstudianteCurso;

class EstudianteCursoController extends Controller
{
    public function index($id) {
        $estudianteCursos = EstudianteCurso::where('estudiante_id', $id)->get();
        $allEstudiantesCursos = [];

        foreach($estudianteCursos as $item) {
            $estudiante = $item->estudiante;
            $curso = $item->curso;

            $response = [
                'id' => $item->id,
                'estudiante' => $estudiante->persona->nombre_completo,
                'curso' => $curso->nombre
            ];

            array_push($allEstudiantesCursos, $response);
        };

        return $allEstudiantesCursos;
    }
}
