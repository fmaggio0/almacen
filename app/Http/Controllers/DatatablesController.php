<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Datatables;
use DB;
use App\Salidas;
use App\SalidasDetalles;
use Response;
use App\User;
use Auth;
use App\Role;

class DatatablesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

	public function articulostable()
	{
	    $articulos = DB::table('articulos')
            ->join('rubros', 'articulos.id_rubro', '=', 'rubros.id_rubro')
            ->leftJoin('subrubros', 'articulos.id_subrubro', '=', 'subrubros.id_subrubro')
            ->select(['articulos.id_articulo', 'articulos.descripcion', 'articulos.unidad', 'articulos.tipo', 'rubros.descripcion AS descripcionrubro', 'subrubros.descripcion AS descripcionsubrubro', 'articulos.estado', 'articulos.updated_at', 'articulos.id_rubro', 'articulos.id_subrubro', 'articulos.stock_actual', 'articulos.stock_minimo']);

        return Datatables::of($articulos)
            ->addColumn('action', function ($articulos) {

            	if($articulos->estado == false)
            	{
                	return '<a href="#" value="'.$articulos->id_articulo.'" class="btn btn-xs btn-primary activar"><i class="glyphicon glyphicon-ok">';
                }
                else
                {
                	return '<a href="/articulos/editar/'.$articulos->id_articulo.'" class="btn btn-xs btn-primary edit"><i class="glyphicon glyphicon-edit edit"></i></a><a href="#" value="'.$articulos->id_articulo.'" class="btn btn-xs btn-danger delete"><i class="glyphicon glyphicon-remove"></i></a>';
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

    public function proveedorestable()
    {
        $proveedores = DB::table('proveedores')
            ->select(['proveedores.id_proveedor', 'proveedores.nombre', 'proveedores.direccion', 'proveedores.estado', 'proveedores.updated_at', 'proveedores.rubros', 'proveedores.email', 'proveedores.telefono', 'proveedores.observaciones', 'proveedores.cuit']);

        return Datatables::of($proveedores)
            ->addColumn('action', function ($proveedores) {

                if($proveedores->estado == false)
                {
                    return '<a href="#" value="'.$proveedores->id_proveedor.'" class="btn btn-xs btn-primary activar"><i class="glyphicon glyphicon-ok">';
                }
                else
                {
                    return '<a href="/proveedores/editar/'.$proveedores->id_proveedor.'" value="'.$proveedores->id_proveedor.'" class="btn btn-xs btn-primary edit"><i class="glyphicon glyphicon-edit edit"></i></a><a href="#" value="'.$proveedores->id_proveedor.'" class="btn btn-xs btn-danger delete"><i class="glyphicon glyphicon-remove"></i></a>';
                }
            })
            ->editColumn('estado', function($proveedores){
                if( $proveedores->estado == false )
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

    public function ingresostable()
    {
        $ingresos = DB::table('ingresos_master')
            ->join('ingresos_detalles', 'ingresos_master.id_master', '=', 'ingresos_detalles.id_master')
            ->join('articulos', 'articulos.id_articulo', '=', 'ingresos_detalles.id_articulo')
            ->leftJoin('proveedores', 'ingresos_master.id_proveedor', '=', 'proveedores.id_proveedor')
            ->join('users', 'ingresos_master.id_usuario', '=', 'users.id')
            ->select(['ingresos_master.id_master as id_master', 'ingresos_master.tipo_ingreso', 'ingresos_master.tipo_comprobante', 'ingresos_master.nro_comprobante','ingresos_master.descripcion', 'proveedores.nombre as proveedor', 'ingresos_master.created_at', 'ingresos_master.fecha_factura', 'ingresos_master.estado as estado'])
            ->distinct();

        return Datatables::of($ingresos)
            ->addColumn('id_tabla', function ($ingresos) {
                return $ingresos->id_master;
            })
            ->addColumn('action', function ($ingresos) {

                if($ingresos->estado == true)
                {
                    return '<a href="#" class="btn btn-xs botgris edit"><i class="glyphicon glyphicon-print"></i></a>';
                }
            })
            ->editColumn('estado', function($ingresos){
                if( $ingresos->estado == false )
                {
                    return "<span class='label label-danger'>No registrado</span>";
                }
                else
                {
                    return "<span class='label label-success'>Registrado</span>";
                }

            })
            ->editColumn('id_master', function($ingresos){
                if( $ingresos->tipo_ingreso == "Ajuste de stock")
                {
                    return "ADS-".$ingresos->id_master;
                }
                else
                {
                    return "IPF-".$ingresos->id_master;
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
            ->join('users', 'salidas_master.id_usuario', '=', 'users.id')
            ->join('areas', 'subareas.id_area', '=', 'areas.id_area')
            ->select(['salidas_master.id_master as id_master', 'subareas.descripcion_subarea as subarea', 'salidas_master.updated_at', 'salidas_master.origen', 'users.name', 'salidas_master.estado as estado', 'areas.descripcion_area', 'salidas_master.id_subarea'])
            ->distinct();

        return Datatables::of($salidas)
            ->addColumn('id_tabla', function ($salidas) {
                return $salidas->id_master;
            })
            ->addColumn('action', function ($salidas) {

                if($salidas->estado === 0)
                {
                    return '<a href="#" class="btn btn-xs botgris"><i class="glyphicon glyphicon-print"></i></a>';
                }
                elseif($salidas->estado === 1)
                {
                    return "<a href='/egresos/modificar/".$salidas->id_master."' class='btn btn-xs btn-primary edit'><i class='glyphicon glyphicon-search edit'></i></a>";
                }
            })
            ->editColumn('estado', function($salidas){
                if( $salidas->estado === 2 )
                {
                    return "<span class='label label-danger'>Cancelado</span>";
                }
                elseif( $salidas->estado === 1 )
                {
                    return "<span class='label label-warning'>Pendiente</span>";
                }
                elseif( $salidas->estado === 0 )
                {
                    return "<span class='label label-success'>Registrado</span>";
                }

            })
            ->editColumn('id_master', function($salidas){
                if( $salidas->origen == "salida_almacen" )
                {
                    return "MSA-".$salidas->id_master;
                }
                else if ($salidas->origen == "salida_autorizacion")
                {
                    return "AUT-".$salidas->id_master;
                }

            })
            ->make(true);
    }

    public function autorizacionestabla()
    {
        $salidas = DB::table('autorizaciones_master')
            ->join('autorizaciones_detalles', 'autorizaciones_master.id_master', '=', 'autorizaciones_detalles.id_master')
            ->join('subareas', 'autorizaciones_master.id_subarea', '=', 'subareas.id_subarea')
            ->join('articulos', 'articulos.id_articulo', '=', 'autorizaciones_detalles.id_articulo')
            ->join('users', 'autorizaciones_master.id_usuario', '=', 'users.id')
            ->select(['autorizaciones_master.id_master as id_master', 'subareas.descripcion_subarea', 'autorizaciones_master.updated_at', 'users.name', 'autorizaciones_master.estado as estado'])
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
                    return "<span class='label label-danger'>Rechazado</span>";
                }
            })
            ->make(true);
    }

    public function autorizacionesadmin()
    {
        $salidas = DB::table('autorizaciones_master')
            ->join('autorizaciones_detalles', 'autorizaciones_master.id_master', '=', 'autorizaciones_detalles.id_master')
            ->join('subareas', 'autorizaciones_master.id_subarea', '=', 'subareas.id_subarea')
            ->join('articulos', 'articulos.id_articulo', '=', 'autorizaciones_detalles.id_articulo')
            ->join('users', 'autorizaciones_master.id_usuario', '=', 'users.id')
            ->join('areas', 'subareas.id_area', '=', 'areas.id_area')
            ->select(['autorizaciones_master.id_master as id_master', 'subareas.descripcion_subarea', 'autorizaciones_master.updated_at', 'users.name', 'autorizaciones_master.estado as estado', 'areas.descripcion_area', 'autorizaciones_master.id_subarea'])
            ->distinct();

        return Datatables::of($salidas)
            ->addColumn('action', function ($articulos) {
                return '<a href="#" class="btn btn-xs btn-primary edit"><i class="glyphicon glyphicon-edit edit"></i></a>';
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
                    return "<span class='label label-danger'>Rechazado</span>";
                }
            })
            ->make(true);
    }

    public function Usuarios()
    {
        $query = DB::table('users')
            ->select(['users.id', 'users.name', 'users.email', 'users.id_empleado', DB::raw("concat(empleados.apellidos, ', ', empleados.nombres) AS full_name")])  
            ->join('empleados', 'empleados.id_empleado', '=', 'users.id_empleado')
            ->distinct();
         
        return Datatables::of($query)
            ->addColumn('roles', function ($usuarios) {
                $user = User::find($usuarios->id);
                $tmp = '';
                foreach ($user->roles as $role) {
                    $tmp .= " <span class='label label-info'>".$role->display_name."</span>";
                }
                return $tmp;
            })
            ->addColumn('action', function ($usuarios) {
                return '<a href="/cil/usuarios/modificar/'.$usuarios->id.'" class="btn btn-xs btn-primary edit"><i class="glyphicon glyphicon-edit edit"></i></a>';
            })
            ->make(true);
    }
    public function Roles()
    {
        $query = DB::table('roles')
            ->select()
            ->distinct();
         
        return Datatables::of($query)
            ->addColumn('permisos', function ($query) {
                $role = Role::find($query->id);
                $tmp = '';
                foreach ($role->permisos as $permisos) {
                    $tmp .= " <span class='label label-info'>".$permisos->display_name."</span>";
                }
                return $tmp;
            })
            ->addColumn('action', function ($usuarios) {
                return '<a href="/cil/roles/update/'.$usuarios->id.'" class="btn btn-xs btn-primary edit"><i class="glyphicon glyphicon-edit edit"></i></a>';
            })
            ->make(true);
    }

    public function Empleado($id)
    {
        $salidas = DB::table('salidas_detalles')
            ->where('salidas_detalles.id_empleado', '=', $id)
            ->join('salidas_master', 'salidas_master.id_master', '=', 'salidas_detalles.id_master')
            ->join('articulos', 'articulos.id_articulo', '=', 'salidas_detalles.id_articulo')
            ->join('empleados', 'empleados.id_empleado', '=', 'salidas_detalles.id_empleado')
            ->select(['salidas_detalles.id_master', 'salidas_master.origen', 'salidas_master.updated_at', 'articulos.descripcion', 'articulos.tipo', 'salidas_detalles.cantidad', DB::raw("concat(empleados.apellidos, ', ', empleados.nombres) AS full_name")])
            ->distinct();

        return Datatables::of($salidas)
            ->editColumn('id_master', function($salidas){
                if( $salidas->origen == "salida_almacen" )
                {
                    return "MSA-".$salidas->id_master;
                }
                else if ($salidas->origen == "salida_autorizacion")
                {
                    return "AUT-".$salidas->id_master;
                }

            })
            ->make(true);
    }

    public function Indumentaria()
    {

        $salidas = DB::table('empleados')
            ->where('empleados.id_area', '=', User::find(Auth::user()->id)->empleados->id_area )
            ->where('empleados.estado', '=', 1 )
            ->join('areas', 'areas.id_area', '=', 'empleados.id_area')
            ->select('empleados.nombres', 'empleados.apellidos', 'empleados.id_area', 'empleados.id_subarea', 'empleados.funcion', 'empleados.talle_remera', 'empleados.talle_camisa', 'empleados.talle_calzado', 'empleados.estado', 'empleados.updated_at', 'areas.descripcion_area', 'empleados.id_empleado');

        //return $salidas;

        return Datatables::of($salidas)
            ->addColumn('action', function ($salidas) {
                return '<a href="/areas/indumentaria/'.$salidas->id_empleado.'" class="btn btn-xs btn-primary edit"><i class="glyphicon glyphicon-edit edit"></i></a>';
            })
        ->make(true);
    }                 
}