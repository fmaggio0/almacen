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
	    $articulos = DB::table('articulos')
            ->join('rubros', 'articulos.id_rubro', '=', 'rubros.id_rubro')
            ->join('subrubros', 'articulos.id_subrubro', '=', 'subrubros.id_subrubro')
            ->join('users', 'articulos.id_usuario', '=', 'users.id')
            ->select(['articulos.id_articulo', 'articulos.descripcion', 'articulos.unidad', 'users.name as usuario', 'rubros.descripcion AS descripcionrubro', 'subrubros.descripcion AS descripcionsubrubro', 'articulos.estado', 'articulos.updated_at', 'articulos.id_rubro', 'articulos.id_subrubro']);

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
            ->join('subareas', 'salidas_master.id_subarea', '=', 'subareas.id_subarea')
            ->join('articulos', 'articulos.id_articulo', '=', 'salidas_detalles.id_articulo')
            ->join('empleados', 'salidas_detalles.id_empleado', '=', 'empleados.id_empleado')
            ->join('users', 'salidas_master.id_usuario', '=', 'users.id')
            ->select(['salidas_master.id_master as id_master', 'salidas_master.tipo_retiro', 'subareas.descripcion_subarea as subarea', 'salidas_master.updated_at', 'users.name', 'salidas_master.estado as estado'])
            ->distinct();

        return Datatables::of($salidas)
            ->addColumn('action', function ($salidas) {

                if($salidas->estado == false)
                {
                    return '<a href="edit/'.$salidas->id_master.'" class="btn btn-xs btn-primary edit"><i class="glyphicon glyphicon-edit edit"></i></a>';
                }
                else
                {
                    /*return '<a href="#" value="'.$salidas->id_articulo.'" data-desc="'.$articulos->descripcion.'" data-selectunidad="'.$articulos->unidad.'" data-selectrubro="'.$articulos->id_rubro.'" data-selectsubrubro="'.$articulos->id_subrubro.'" class="btn btn-xs btn-primary edit"><i class="glyphicon glyphicon-edit edit"></i></a><a href="#" value="'.$articulos->id_articulo.'" class="btn btn-xs btn-danger delete"><i class="glyphicon glyphicon-remove"></i></a>';*/
                }
            })
            ->editColumn('estado', function($salidas){
                if( $salidas->estado == true )
                {
                    return "<span class='label label-danger'>estado</span>";
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
        $salidas = DB::table('salidas_detalles')
            ->join('articulos', 'salidas_detalles.id_articulo', '=', 'articulos.id_articulo')
            ->join('empleados', 'salidas_detalles.id_empleado', '=', 'empleados.id_empleado')
            ->select(['articulos.descripcion', 'empleados.nombre', 'salidas_detalles.cantidad'])
            ->where('salidas_detalles.id_master', '=', $id);

        return Datatables::of($salidas)->make(true);
    }
}