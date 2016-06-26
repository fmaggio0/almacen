<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Datatables;
use DB;
use App\SalidasMaster;
use App\SalidasDetalles;

class DatatablesController extends Controller
{
    public function getIndex()
	{
	    return view('datatables.index');
	}

	/**
	 * Process datatables ajax request.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function anyData()
	{
	    /*->select('articulos.id_articulo', 'articulos.descripcion', 'articulos.unidad', 'articulos.usuario', 'rubros.descripcion', 'subrubros.descripcion')->join('rubros', 'articulos.id_rubro', '=', 'rubros.id_rubro')->join('subrubros', 'articulos.id_subrubro', '=', 'subrubros.id_subrubro')*/

	    $articulos = DB::table('articulos')
            ->join('rubros', 'articulos.id_rubro', '=', 'rubros.id_rubro')
            ->join('subrubros', 'articulos.id_subrubro', '=', 'subrubros.id_subrubro')
            ->select(['articulos.id_articulo', 'articulos.descripcion', 'articulos.unidad', 'articulos.usuario', 'rubros.descripcion AS descripcionrubro', 'subrubros.descripcion AS descripcionsubrubro', 'articulos.estado', 'articulos.updated_at', 'articulos.id_rubro', 'articulos.id_subrubro']);

        return Datatables::of($articulos)
            ->addColumn('action', function ($articulos) {

            	if($articulos->estado == false)
            	{
                	return '<a href="edit/'.$articulos->id_articulo.'" class="btn btn-xs btn-primary edit"><i class="glyphicon glyphicon-edit edit"></i></a>';
                }
                else
                {
                	return '<a href="#" value="'.$articulos->id_articulo.'" data-desc="'.$articulos->descripcion.'" data-selectunidad="'.$articulos->unidad.'" data-selectrubro="'.$articulos->id_rubro.'" data-selectsubrubro="'.$articulos->id_subrubro.'" class="btn btn-xs btn-primary edit"><i class="glyphicon glyphicon-edit edit"></i></a><a href="#" value="'.$articulos->id_articulo.'" class="btn btn-xs btn-danger delete"><i class="glyphicon glyphicon-remove"></i></a>';
                }
            })
            ->editColumn('estado', function($articulos){
        		if( $articulos->estado == false )
        		{
        			return "<span class='label label-danger'>Inactivo</span>";
        		}
        		else
        		{
        			return "<span class='label label-success'>Activo</span>";
        		}

        	})
            ->make(true);
	}

    public function salidastable()
    {

        $salidas = DB::table('salidas_master')
            ->join('salidas_detalles', 'salidas_master.id_master', '=', 'salidas_detalles.id_master')
            ->join('destinos', 'salidas_master.id_destino', '=', 'destinos.id_destino')
            ->join('articulos', 'articulos.id_articulo', '=', 'salidas_detalles.id_articulo')
            ->join('empleados', 'salidas_detalles.id_empleado', '=', 'empleados.id_empleado')
            ->join('users', 'salidas_master.usuario', '=', 'users.id')
            ->select(['salidas_master.id_master as id_master', 'salidas_master.tipo_retiro', 'destinos.descripcion_destino', 'salidas_master.updated_at', 'users.name', 'salidas_master.pendiente as pendiente']);

        return Datatables::of($salidas)
            ->addColumn('action', function ($salidas) {

                if($salidas->pendiente == false)
                {
                    return '<a href="edit/'.$salidas->id_master.'" class="btn btn-xs btn-primary edit"><i class="glyphicon glyphicon-edit edit"></i></a>';
                }
                else
                {
                    /*return '<a href="#" value="'.$salidas->id_articulo.'" data-desc="'.$articulos->descripcion.'" data-selectunidad="'.$articulos->unidad.'" data-selectrubro="'.$articulos->id_rubro.'" data-selectsubrubro="'.$articulos->id_subrubro.'" class="btn btn-xs btn-primary edit"><i class="glyphicon glyphicon-edit edit"></i></a><a href="#" value="'.$articulos->id_articulo.'" class="btn btn-xs btn-danger delete"><i class="glyphicon glyphicon-remove"></i></a>';*/
                }
            })
            ->editColumn('pendiente', function($salidas){
                if( $salidas->pendiente == true )
                {
                    return "<span class='label label-danger'>Pendiente</span>";
                }
                else
                {
                    return "<span class='label label-success'>Registrado</span>";
                }

            })
            ->make(true);
    }
    public function salidasdetallestabla($id)
    {
        $posts = SalidasDetalles::find($id)->posts();

        return Datatables::of($posts)->make(true);
    }
}