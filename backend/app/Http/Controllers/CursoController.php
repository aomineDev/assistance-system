<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Curso;

class CursoController extends Controller
{
    public function getCursosByDocente($id) {
        $docenteCursos = Curso::where('docente_id', $id)->get();
        $allDocenteCursos = [];
        foreach($docenteCursos as $item) {
            $docente = $item->docente;
            $response = [
                'curso_id' => $item->id,
                'nombre' => $item->nombre,
                'docente_id' => $docente->id
            ];
            array_push($allDocenteCursos, $response);
        }
        return $allDocenteCursos;
    }
}
