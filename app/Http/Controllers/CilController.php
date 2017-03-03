<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class CilController extends Controller
{
    public function Index(){

    	return view('cil.cil_index');
    }
    public function Usuarios(){

    	return view('cil.cil_usuarios');
    }
}
