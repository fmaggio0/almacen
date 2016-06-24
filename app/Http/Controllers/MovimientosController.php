<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use App\Http\Controllers\Controller;
use App\addarticulo;
use App\articulos;

class MovimientosController extends Controller
{
	public function index(){

		return view('salidas.movimientos');
	}

	public function store(){

		return "hola";
	}
}
