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
    	$empleados = Empleados::where('apellido', 'like', $term.'%')
	    	->select('apellido AS text', 'id_empleado AS id', 'nombre')
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

    public function getSubareasxid_area(Request $request, $id){
    	$term = $request->term ?: '';
        $areaid = UserInfo::find($id)->id_area;   
        $subareas=DB::table('subareas')
            ->where('id_area', '=', $areaid )
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
            ->select('descripcion AS text', 'id_articulo AS id', 'stock_actual', 'unidad')
            ->get();

        return Response::json($tags);
    }
}
