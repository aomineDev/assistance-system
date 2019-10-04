<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Asistencia;

class AsistenciaController extends Controller
{
    public function getAsistenciasByCurso($id) {
        $asistencias = Asistencia::where('curso_id', $id)->get();
        $allAsistencias = [];
        foreach($asistencias as $item) {
            $curso = $item->curso;
            $semestre = $curso->semestre;
            $response = [
                'id' => $item->id,
                'curso' => $curso->nombre,
                'semestre_id' => $semestre->id,
                'semestre' => $semestre->nombre,
                'aula' => $item->aula,
                'tema' => $item->tema,
                'software' => $item->software,
                'avance' => $item->avance,
                'fecha' => $item->fecha,
                'proyector' => $item->proyector
            ];
            array_push($allAsistencias, $response);
        }
        return $allAsistencias;
    }

    public function getAsistencia($id) {
        $asistencia = Asistencia::find($id);
        $curso = $asistencia->curso;
        $semestre = $curso->semestre;

        return response()->json([
            'id' => $asistencia->id,
            'curso' => $curso->nombre,
            'codigo' => $curso->codigo,
            'semestre_id' => $semestre->id,
            'semestre' => $semestre->nombre,
            'aula' => $asistencia->aula,
            'tema' => $asistencia->tema,
            'software' => $asistencia->software,
            'avance' => $asistencia->avance,
            'fecha' => $asistencia->fecha,
            'proyector' => $asistencia->proyector
        ]);
    }
}
