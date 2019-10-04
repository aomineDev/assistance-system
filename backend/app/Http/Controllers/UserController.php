<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function index($id) {
        $user = User::find($id);
        $persona = $user->persona;
        return response()->json([
            'id' => $user->id,
            'nombre_completo' => $persona->nombre_completo
        ]);
    }
}
