<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class PersonalController extends Controller
{
    public function index(){

		return view('personal.empleados');
	}

	public function nuevo(){

		return view('personal.create');
	}

}
