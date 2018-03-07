<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Empleados;
use DB;
use Response;

class InformesController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('compras.informes.empleados');
    }
    public function IndexEmpleado($id){

        $empleados = Empleados::find($id);
        return view('compras.informes.empleados_informe')->with('empleados', $empleados);
    }

    public function indexStock(){

        $articulos = DB::table('articulos')
            ->join('rubros', 'rubros.id_rubro', '=', 'articulos.id_rubro')
            ->leftJoin('subrubros', 'subrubros.id_subrubro', '=', 'articulos.id_subrubro')
            ->select('articulos.descripcion','articulos.stock_actual', 'articulos.unidad', 'articulos.stock_minimo', 'articulos.id_rubro','articulos.id_subrubro', 'articulos.estado', 'subrubros.descripcion as subrubro', 'rubros.descripcion as rubro', 
                DB::raw("( SELECT sum(salidas_detalles.cantidad) as cantidad FROM salidas_detalles
                    WHERE id_articulo = articulos.id_articulo) as cantidad_salidas"), 
                DB::raw("( SELECT sum(ingresos_detalles.cantidad) as cantidad1 FROM ingresos_detalles
                    WHERE id_articulo = articulos.id_articulo) as cantidad_ingresos"))
            ->orderBy('rubro', 'ASC')
            ->get();



        $datos = [];
        /* Creamos una matriz con índice 'id_foreign' con elementos variables */
        foreach ($articulos as $articulo) {
            $datos[$articulo->rubro][] = $articulo;
        }


        //return $datos;
        return view('compras.informes.movimientos_stock')->with('datos', $datos);

    }

}
