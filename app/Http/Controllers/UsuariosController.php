<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use DB;
use App\SubAreas;

class UsuariosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function subareas(Request $request){

    	$post = $request->all();
    	$userid = Auth::user()->id;
		$info = DB::table('users_info')
	 		->where('users_info.id_area', '=', $userid)
        	->get();
   	 	$term = $post['term'] ?: '';
    	$areas = SubAreas::where('descripcion_subarea', 'like', $term.'%')
    		->where('id_area', '=', $info->id_area )
	   	 	->select('descripcion_subarea AS text', 'id_subarea AS id')
	   	 	->get()
	   		->toJson();
    return $areas->id_area;
    }
}
