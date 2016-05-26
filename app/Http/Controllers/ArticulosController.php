<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;

class ArticulosController extends Controller
{
	public function index(){

		$articulos=DB::table('articulos')->get();
		return view('configuraciones.articulos', compact('articulos'));
	}
    
}
