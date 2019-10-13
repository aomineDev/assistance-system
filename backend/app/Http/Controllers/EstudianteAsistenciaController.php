<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EstudianteAsistencia;

class EstudianteAsistenciaController extends Controller
{
    public function updateAsistencia(Request $request, $id) {
        $asistencias =EstudianteAsistencia::where('asistencia_id', $id)->get();

        foreach($asistencias as $index => $item) {
            $asistencias[$index]->firma = $request->input($index);
            $asistencias[$index]->save();
        }

        return $asistencias;
    }
}
