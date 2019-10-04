<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserCurso;

class UserCursoController extends Controller
{
    public function index($id) {
        $userCursos = UserCurso::where('user_id', $id)->get();
        $allUserCursos = [];
        foreach($userCursos as $item) {
            $curso = $item->curso;
            $user = $item->user;
            $response = [
                'id' => $item->id,
                'curso' => $curso->nombre,
                'docente' => $user->persona->nombre_completo
            ];
            array_push($allUserCursos, $response);
        }
        return $allUserCursos;

    }
}
