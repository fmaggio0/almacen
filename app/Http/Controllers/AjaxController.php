<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Empleados;
use DB;
use Response;
use App\UserInfo;

class AjaxController extends Controller
{
    public function getRubros() {
    	$rubros=DB::table('rubros')
			->select('id_rubro AS id', 'descripcion AS text' )
			->get();

    	return Response::json($rubros);
    }

    public function getRubros2() {
        $rubros=DB::table('rubros')
            ->select('descripcion AS id', 'descripcion AS text' )
            ->get();

        return Response::json($rubros);
    }

    public function getSubrubros(){
		$subrubros=DB::table('subrubros')
			->select('id_subrubro AS id', 'descripcion AS text' )
			->get();

    	return Response::json($subrubros);
    }

    public function getSubrubrosxid_rubro($id){
    	$rubrosub=DB::table('subrubros')
			->where('id_rubro', '=', $id )
			->select('id_subrubro AS id', 'descripcion AS text' )
			->get();
    	return Response::json($rubrosub);
    }

    public function getEmpleados(Request  $request){
    	$term = $request->term ?: '';
    	$empleados = Empleados::where('Apellido', 'like', $term.'%')
	    	->select('Apellido AS text', 'Nro_Legajo AS id', 'Nombres as nombre')
	   	 	->get();

    	return Response::json($empleados);
    }

    public function getSubareas(Request $request){
    	$term = $request->term ?: '';
		$subareas=DB::table('subareas')
			->where('descripcion_subarea', 'like', $term.'%')
			->select('id_subarea AS id', 'descripcion_subarea AS text' )
			->get();

        return Response::json($subareas);
    }

    public function getArticulos(Request $request)
    {
        $term = $request->term ?: '';
        $tags = DB::table ('articulos')
            ->where('descripcion', 'like', $term.'%')
            ->select('descripcion AS text', 'id_articulo AS id', 'stock_actual', 'unidad', 'stock_minimo')
            ->get();

        return Response::json($tags);
    }

    public function getProveedores(Request $request)
    {
        $term = $request->term ?: '';
        $tags = DB::table ('proveedores')
            ->where('nombre', 'like', $term.'%')
            ->select('nombre AS text', 'id_proveedor AS id')
            ->get();

        return Response::json($tags);
    }

    public function getDetallesIngresos($id){
        $detalles=DB::table('ingresos_detalles')
            ->where('id_master', '=', $id )
            ->join('articulos', 'ingresos_detalles.id_articulo', '=', 'articulos.id_articulo')
            ->select('articulos.descripcion as Articulo', 'ingresos_detalles.cantidad as Cantidad')
            ->get();
        return Response::json($detalles);
    }

    public function getDetallesSalidas($id){
        $detalles= DB::table('salidas_detalles')
            ->where('id_master', '=', $id )
            ->join('articulos', 'salidas_detalles.id_articulo', '=', 'articulos.id_articulo')
            ->join('personal_prod.tpersonal as empleados', 'salidas_detalles.id_empleado', '=', 'empleados.Nro_Legajo')
            ->select('articulos.descripcion as Articulo', 'empleados.Nombres as Nombre','empleados.Apellido as Apellido', 'salidas_detalles.cantidad as Cantidad')
            ->get();
        return Response::json($detalles);
    }

    public function getDetallesAutorizaciones($id){
        $detalles=DB::table('autorizaciones_detalles')
            ->where('id_master', '=', $id )
            ->join('articulos', 'autorizaciones_detalles.id_articulo', '=', 'articulos.id_articulo')
            ->join('personal_prod.tpersonal as empleados', 'autorizaciones_detalles.id_empleado', '=', 'empleados.Nro_Legajo')
            ->select('articulos.descripcion as Articulo', 'empleados.Nombres as Nombre','empleados.Apellido as Apellido', 'autorizaciones_detalles.cantidad as Cantidad')
            ->get();
        return Response::json($detalles);
    }
    /*public function getDetallesSalidas($id){
        $detalles= DB::connection('personal')->table('tpersonal')
            ->select('*')
            ->get();
        return Response::json($detalles);
    }*/
}
