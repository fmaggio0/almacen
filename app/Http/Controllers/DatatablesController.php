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
	public function articulostable()
	{
	    $articulos = DB::table('articulos')
            ->join('rubros', 'articulos.id_rubro', '=', 'rubros.id_rubro')
            ->join('subrubros', 'articulos.id_subrubro', '=', 'subrubros.id_subrubro')
            ->join('users', 'articulos.id_usuario', '=', 'users.id')
            ->select(['articulos.id_articulo', 'articulos.descripcion', 'articulos.unidad', 'users.name as usuario', 'rubros.descripcion AS descripcionrubro', 'subrubros.descripcion AS descripcionsubrubro', 'articulos.estado', 'articulos.updated_at', 'articulos.id_rubro', 'articulos.id_subrubro', 'articulos.stock_actual', 'articulos.stock_minimo']);

        return Datatables::of($articulos)
            ->addColumn('action', function ($articulos) {

            	if($articulos->estado == false)
            	{
                	return '<a href="#" value="'.$articulos->id_articulo.'" class="btn btn-xs btn-primary activar"><i class="glyphicon glyphicon-ok">';
                }
                else
                {
                	return '<a href="#" value="'.$articulos->id_articulo.'" data-desc="'.$articulos->descripcion.'" data-selectunidad="'.$articulos->unidad.'" data-selectrubro="'.$articulos->id_rubro.'" data-selectsubrubro="'.$articulos->id_subrubro.'" data-estado="'.$articulos->estado.'" class="btn btn-xs btn-primary edit"><i class="glyphicon glyphicon-edit edit"></i></a><a href="#" value="'.$articulos->id_articulo.'" class="btn btn-xs btn-danger delete"><i class="glyphicon glyphicon-remove"></i></a>';
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
            ->editColumn('stock_minimo', function($articulos){
                if( $articulos->stock_minimo == null )
                {
                    return "No definido";
                }
                else{
                    return $articulos->stock_minimo;
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
            ->join('areas', 'subareas.id_area', '=', 'areas.id_area')
            ->select(['salidas_master.id_master as id_master', 'salidas_master.tipo_retiro', 'subareas.descripcion_subarea as subarea', 'salidas_master.updated_at', 'users.name', 'salidas_master.estado as estado', 'areas.descripcion_area'])
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
    public function autorizacionestabla()
    {
        $salidas = DB::table('autorizaciones_master')
            ->join('autorizaciones_detalles', 'autorizaciones_master.id_master', '=', 'autorizaciones_detalles.id_master')
            ->join('subareas', 'autorizaciones_master.id_subarea', '=', 'subareas.id_subarea')
            ->join('articulos', 'articulos.id_articulo', '=', 'autorizaciones_detalles.id_articulo')
            ->join('empleados', 'autorizaciones_detalles.id_empleado', '=', 'empleados.id_empleado')
            ->join('users', 'autorizaciones_master.id_usuario', '=', 'users.id')
            ->select(['autorizaciones_master.id_master as id_master', 'autorizaciones_master.tipo_retiro', 'subareas.descripcion_subarea', 'autorizaciones_master.updated_at', 'users.name', 'autorizaciones_master.estado as estado'])
            ->distinct();

        return Datatables::of($salidas)
            ->addColumn('action', function ($salidas) {

                if($salidas->estado == false)
                {
                    return '<a href="edit/'.$salidas->id_master.'" class="btn btn-xs btn-primary edit"><i class="glyphicon glyphicon-edit edit"></i></a>';
                }
            })
            ->editColumn('estado', function($salidas){
                if( $salidas->estado == 0 )
                {
                    return "<span class='label label-warning'>Pendiente</span>";
                }
                elseif ($salidas->estado == 1 )
                {
                    return "<span class='label label-success'>Autorizado</span>";
                }
                elseif ($salidas->estado == 2 )
                {
                    return "<span class='label label-info'>Autorizado parcialmente</span>";
                }
                elseif ($salidas->estado == 3 )
                {
                    return "<span class='label label-label-danger'>Rechazado</span>";
                }
            })
            ->make(true);
    }
    public function autorizacionesdetallestabla($id)
    {
        $salidas = DB::table('autorizaciones_detalles')
            ->join('articulos', 'autorizaciones_detalles.id_articulo', '=', 'articulos.id_articulo')
            ->join('empleados', 'autorizaciones_detalles.id_empleado', '=', 'empleados.id_empleado')
            ->select(['articulos.descripcion', 'empleados.nombre', 'autorizaciones_detalles.cantidad'])
            ->where('autorizaciones_detalles.id_master', '=', $id);

        return Datatables::of($salidas)->make(true);
    }
    public function autorizacionesadmin()
    {
        $salidas = DB::table('autorizaciones_master')
            ->join('autorizaciones_detalles', 'autorizaciones_master.id_master', '=', 'autorizaciones_detalles.id_master')
            ->join('subareas', 'autorizaciones_master.id_subarea', '=', 'subareas.id_subarea')
            ->join('articulos', 'articulos.id_articulo', '=', 'autorizaciones_detalles.id_articulo')
            ->join('empleados', 'autorizaciones_detalles.id_empleado', '=', 'empleados.id_empleado')
            ->join('users', 'autorizaciones_master.id_usuario', '=', 'users.id')
            ->join('users_info', 'autorizaciones_master.id_usuario', '=', 'users_info.id_user')
            ->join('areas', 'users_info.id_area', '=', 'areas.id_area')
            ->select(['autorizaciones_master.id_master as id_master', 'autorizaciones_master.tipo_retiro', 'subareas.descripcion_subarea', 'autorizaciones_master.updated_at', 'users.name', 'autorizaciones_master.estado as estado', 'areas.descripcion_area', 'autorizaciones_master.id_subarea'])
            ->distinct();

        return Datatables::of($salidas)
            ->editColumn('estado', function($salidas){
                if( $salidas->estado == 0 )
                {
                    return "<span class='label label-warning'>Pendiente</span>";
                }
                elseif ($salidas->estado == 1 )
                {
                    return "<span class='label label-success'>Autorizado</span>";
                }
                elseif ($salidas->estado == 2 )
                {
                    return "<span class='label label-info'>Autorizado parcialmente</span>";
                }
                elseif ($salidas->estado == 3 )
                {
                    return "<span class='label label-label-danger'>Rechazado</span>";
                }
            })
            ->addColumn('action', function ($salidas) {

                if($salidas->estado == 0)
                {
                    return "<a href='#' id='edit' class='btn btn-xs btn-primary edit'><i class='glyphicon glyphicon-search edit'></i></a>";
                }
            })
            ->make(true);
    }
    public function autorizacionesdetallesadmin($id)
    {
        $salidas = DB::table('autorizaciones_detalles')
            ->join('articulos', 'autorizaciones_detalles.id_articulo', '=', 'articulos.id_articulo')
            ->join('empleados', 'autorizaciones_detalles.id_empleado', '=', 'empleados.id_empleado')
            ->select(['articulos.descripcion', 'empleados.nombre', 'autorizaciones_detalles.cantidad'])
            ->where('autorizaciones_detalles.id_master', '=', $id);

        return Datatables::of($salidas)->make(true);
    }
}