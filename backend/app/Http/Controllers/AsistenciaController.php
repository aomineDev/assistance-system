<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Asistencia;
use App\EstudianteAsistencia;

class AsistenciaController extends Controller
{
    public function getAsistenciasByCurso($curso_id, $docente_id) {
        $asistencias = Asistencia::where('curso_id', $curso_id)
        ->where('docente_id', $docente_id)
        ->orderBy('fecha')
        ->get();

        $allAsistencias = [];
        foreach($asistencias as $item) {
            $curso = $item->curso;
            $semestre = $curso->semestre;
            $response = [
                'id' => $item->id,
                'curso' => $curso->nombre,
                'fecha' => $item->fecha
            ];
            array_push($allAsistencias, $response);
        }
        return $allAsistencias;
    }

    public function getAsistencia($id) {
        $asistencia = Asistencia::find($id);
        $curso = $asistencia->curso;
        $semestre = $curso->semestre;
        $docente = $asistencia->docente;
        $estudiantes = $asistencia->estudiantes;

        $details = [
            'id' => $asistencia->id,
            'curso' => $curso->nombre,
            'codigo' => $curso->codigo,
            'docente' => $docente->persona->nombre_completo,
            'semestre' => $semestre->nombre,
            'aula' => $asistencia->aula,
            'tema' => $asistencia->tema,
            'software' => $asistencia->software,
            'avance' => $asistencia->avance,
            'fecha' => $asistencia->fecha,
            'proyector' => $asistencia->proyector
        ];

        $allEstudiantes = [];
        $trueStudents = [];
        foreach($estudiantes as $item) {
            $estudiante = $item->estudiante;
            $responseOne = [
                'id' => $item->id,
                'nombre' => $estudiante->persona->nombre_completo,
                'codigo' => $estudiante->codigo,
                'firma' => $item->firma,
                'nota' => $item->nota
            ];
            $responseTwo = [
                'id' => $item->id,
                'firma' => $item->firma,
                'nota' => $item->nota
            ];
            array_push($allEstudiantes, $responseOne);
            array_push($trueStudents, $responseTwo);
        }

        usort($allEstudiantes, function($a, $b) {
            return strcmp($a['nombre'], $b['nombre']);
        });

        return response()->json([
            'details' => $details,
            'students' => $allEstudiantes,
            'trueStudents' => $trueStudents
        ]);
    }

    public function updateDetails(Request $request) {
        $id = $request->input('id');
        $asistencia = Asistencia::find($id);
        $asistencia->aula = $request->input('aula');
        $asistencia->tema = $request->input('tema');
        $asistencia->software = $request->input('software');
        $asistencia->avance = $request->input('avance');
        $asistencia->fecha = $request->input('fecha');
        $asistencia->proyector = $request->input('proyector');
        $asistencia->save();

        // $details = [
        //     'aula' => $asistencia->aula,
        //     'tema' => $asistencia->tema,
        //     'software' => $asistencia->software,
        //     'avance' => $asistencia->avance,
        //     'fecha' => $asistencia->fecha,
        //     'proyector' => $asistencia->proyector
        // ];

        return $request;
    }
}
