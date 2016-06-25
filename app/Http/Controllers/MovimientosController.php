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
        $detalles = new SalidasDetalles;

        $post = $request->all();

        $master->tipo_retiro = $post['tipo_retiro'];
        $master->id_destino = $post['destino'];
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
                $detalles::insert($detalles);
            }
            return \View::make('salidas.movimientos');
        }
	}
}
