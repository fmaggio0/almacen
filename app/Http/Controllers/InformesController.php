<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class InformesController extends Controller
{
    public function index(){
        return view('compras.informes.empleados');
    }
    public function IndexEmpleado($id){
        return view('compras.informes.empleados_informe')->with('id', $id);
    }

}
