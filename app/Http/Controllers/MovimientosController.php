<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use App\Http\Controllers\Controller;
use App\SalidasMaster;
use App\SalidasDetalles;


class MovimientosController extends Controller
{
	public function index(){

		return view('salidas.movimientos');
	}

	public function store(Request $request){

        $master = new SalidasMaster;

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
                SalidasDetalles::create($detalles);
            }
            return \View::make('salidas.movimientos');
        }
	}
}
