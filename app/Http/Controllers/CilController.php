<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User; 

use Auth;

use View;

class CilController extends Controller
{
    public function Index(){
    	return view('cil.cil_index');
    }
    public function Usuarios(){
    	return view('cil.cil_usuarios');
    }
    public function UsuariosModificar($id){

    	$user = User::find($id);

        return View::make('cil.cil_usuarios_modificar')->with('user', $user);
    }
}
