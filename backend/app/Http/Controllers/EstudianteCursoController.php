<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EstudianteCurso;

class EstudianteCursoController extends Controller
{
    public function getCursosByEstudiante($id) {
        $estudianteCursos = EstudianteCurso::where('estudiante_id', $id)->get();
        $allEstudianteCursos = [];
        foreach($estudianteCursos as $item) {
            $curso = $item->curso;
            $estudiante = $item->estudiante;
            $docente = $curso->docente;
            $response = [
                'curso_id' => $curso->id,
                'nombre' => $curso->nombre,
                'docente_id' => $docente->id,
                'docente' => $docente->persona->nombre_completo
            ];
            array_push($allEstudianteCursos, $response);
        }
        return $allEstudianteCursos;
    }
}
