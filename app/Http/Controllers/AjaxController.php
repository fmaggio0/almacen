<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Empleados;
use DB;
use Response;
use App\UserInfo;
use App\Role;  

class AjaxController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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
    	$empleados = DB::table('empleados')
            ->where('empleados.apellidos', 'ilike', '%'.$term.'%')
            ->join('areas', 'areas.id_area', '=', 'empleados.id_area')
            ->leftJoin('subareas', 'subareas.id_subarea', '=', 'empleados.id_subarea')
            ->select('empleados.id_empleado AS id', 'empleados.apellidos AS text', 'empleados.nombres as nombres', 'empleados.funcion as funcion', 'areas.descripcion_area as descripcion_area', 'subareas.descripcion_subarea as descripcion_subarea' )
            ->get();
    	return Response::json($empleados);
    }

    public function getSubareas(Request  $request){
        $term = $request->term ?: '';
		$subareas=DB::table('subareas')
			->where('descripcion_subarea', 'ilike', '%'.$term.'%')
			->select('id_subarea AS id', 'descripcion_subarea AS text' )
			->get();
        return Response::json($subareas);
    }

    public function getSubareasxID($id, Request $request){
        $term = $request->term ?: '';
        $subareas=DB::table('subareas')
            ->where('id_area', '=', $id)
            ->where('descripcion_subarea', 'ilike', '%'.$term.'%')
            ->select('id_subarea AS id', 'descripcion_subarea AS text' )
            ->get();
        return Response::json($subareas);
    }

    public function getArticulos(Request $request)
    {
        $term = $request->term ?: '';
        $tags = DB::table ('articulos')
            ->where('descripcion', 'ilike', '%'.$term.'%')
            ->select('descripcion AS text', 'id_articulo AS id', 'stock_actual', 'unidad', 'stock_minimo', 'tipo')
            ->get();
        return Response::json($tags);
    }

    public function getRoles(Request $request)
    {
        $term = $request->term ?: '';
        $tags = DB::table ('roles')
            ->where('display_name', 'ilike', $term.'%')
            ->select('display_name AS text', 'id AS id')
            ->get();
        return Response::json($tags);
    }

    public function getPermisos(Request $request)
    {
        $term = $request->term ?: '';
        $tags = DB::table ('permissions')
            ->where('display_name', 'ilike', $term.'%')
            ->select('display_name AS text', 'id AS id')
            ->get();
        return Response::json($tags);
    }

    public function getPermisosxID($id)
    {
        $role = Role::find($id);

        return Response::json($role->permisos);
    }

    public function getUltimoRetiroPorEmpleado($id_articulo, $id_empleado)
    {
        $asd=DB::table('salidas_detalles')
            ->where('id_articulo', '=', $id_articulo)
            ->where('id_empleado', '=', $id_empleado)
            ->select('salidas_detalles.created_at')
            ->orderBy('salidas_detalles.created_at', 'desc')
            ->first();
        return Response::json($asd);
    }

    public function getProveedores(Request $request)
    {
        $term = $request->term ?: '';
        $tags = DB::table ('proveedores')
            ->where('nombre', 'ilike', '%'.$term.'%')
            ->select('nombre AS text', 'id_proveedor AS id')
            ->get();

        return Response::json($tags);
    }

    public function getDetallesIngresos($id){

        $master = DB::table('ingresos_master')
            ->where('id_master', '=', $id )
            ->select('total_factura', 'tipo_ingreso')
            ->get();

        $detalles = DB::table('ingresos_detalles')
            ->where('id_master', '=', $id )
            ->join('articulos', 'ingresos_detalles.id_articulo', '=', 'articulos.id_articulo')
            ->select('articulos.descripcion as Articulo', 'ingresos_detalles.cantidad as Cantidad', 'precio_unitario')
            ->get();

        $data[] = array(
           'master' => $master,
           'detalles' => $detalles
        );

        return Response::json($data);
    }

    public function getDetallesSalidas($id){
        $detalles= DB::table('salidas_detalles')
            ->where('id_master', '=', $id )
            ->join('articulos', 'salidas_detalles.id_articulo', '=', 'articulos.id_articulo')
            ->join('empleados', 'salidas_detalles.id_empleado', '=', 'empleados.id_empleado')
            ->select('articulos.descripcion', 'empleados.nombres','empleados.apellidos', 'salidas_detalles.cantidad', 'articulos.tipo')
            ->get();
        return Response::json($detalles);
    }

    public function getDetallesAutorizaciones($id){
        $detalles=DB::table('autorizaciones_detalles')
            ->where('id_master', '=', $id )
            ->join('articulos', 'autorizaciones_detalles.id_articulo', '=', 'articulos.id_articulo')
            ->join('empleados', 'autorizaciones_detalles.id_empleado', '=', 'empleados.id_empleado')
            ->select('articulos.id_articulo', 'articulos.tipo', 'articulos.descripcion','autorizaciones_detalles.id_empleado', 'empleados.nombres','empleados.apellidos', 'autorizaciones_detalles.cantidad', 'articulos.stock_actual', 'autorizaciones_detalles.id_detalles', 'autorizaciones_detalles.estado')
            ->get();

        foreach ($detalles as $detalle) {
            $asd=DB::table('salidas_detalles')
                ->where('id_articulo', '=', $detalle->id_articulo)
                ->where('id_empleado', '=', $detalle->id_empleado)
                ->select('salidas_detalles.created_at', 'salidas_detalles.id_detalles')
                ->orderBy('salidas_detalles.created_at', 'desc')
                ->first();

            if($asd === null){
                $data[] = array(
                   'id_master' => $id,
                   'apellidos' => $detalle->apellidos,
                   'nombres' => $detalle->nombres,
                   'cantidad' => $detalle->cantidad,
                   'tipo' => $detalle->tipo,
                   'descripcion' => $detalle->descripcion,
                   'id_articulo' => $detalle->id_articulo,
                   'stock_actual' => $detalle->stock_actual,
                   'id_empleado' => $detalle->id_empleado,
                   'id_detalles' => $detalle->id_detalles,
                   'estado' => $detalle->estado,
                );
            }
            else{
                $data[] = array(
                    'id_master' => $id,
                   'apellidos' => $detalle->apellidos,
                   'nombres' => $detalle->nombres,
                   'cantidad' => $detalle->cantidad,
                   'tipo' => $detalle->tipo,
                   'descripcion' => $detalle->descripcion,
                   'id_articulo' => $detalle->id_articulo,
                   'id_empleado' => $detalle->id_empleado,
                   'stock_actual' => $detalle->stock_actual,
                   'ultimo_entregado' => $asd->created_at,
                   'id_detalles' => $detalle->id_detalles,
                   'estado' => $detalle->estado,
                );
            }  
        }

        return Response::json($data);
    }
    /*public function getDetallesSalidas($id){
        $detalles= DB::connection('personal')->table('tpersonal')
            ->select('*')
            ->get();
        return Response::json($detalles);
    }*/
}
