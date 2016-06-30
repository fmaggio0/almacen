<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\AutorizacionesMaster;
use App\AutorizacionesDetalles;
use App\Http\Requests;

class AutorizacionesController extends Controller
{
    public function index(){

		return view('usuario.index');
	}
	
	public function store(Request $request){

    $master = new AutorizacionesMaster;

    $post = $request->all();

    $master->tipo_retiro = $post['tipo_retiro'];
    $master->id_subarea = $post['destino'];
    $master->id_usuario = $post['usuario'];
    $master->save();

    $j = $master->id_master;

		if($j > 0)
		{
	        for($i=0;$i <count($post['articulos1']);$i++)
	        {
	            $detalles = array(
	                                'id_master' => $j,
	                                'id_articulo'=> $post['articulos1'][$i],
	                                'id_empleado'  => $post['empleados1'][$i],
	                                'cantidad' => $post['cantidad1'][$i]
	                                );
	            AutorizacionesDetalles::create($detalles);
	        }
	    return back()->withInput();
    	}
	}
}
