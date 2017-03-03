<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class AreasController extends Controller
{
    
    public function index(){
		return view('areas.areas_index');
	}

	public function IndexAutorizaciones(){
		return view('areas.areas_autorizaciones');
	}

	public function NuevaAutorizacion(){
		return view('areas.areas_autorizaciones_nueva');
	}

}
