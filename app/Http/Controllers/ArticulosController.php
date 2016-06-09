<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use App\Http\Controllers\Controller;
use App\addarticulo;
use App\articulos;

class ArticulosController extends Controller
{
	public function index(){

		return view('configuraciones.articulos');
	}

	public function store(Request $request)
	{
        $articulo = new addarticulo;
     
        $v = \Validator::make($request->all(), [
            
            'descripcion' => 'required|max:255',
            'unidad' => 'required|max:20',
            'usuario'    => 'required|max:255', //modificar cuando cambie la tabla
            'id_rubro' => 'required|numeric',
            'id_subrubro' => ''
        ]);
 
        if ($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }
        
        $articulo->create($request->all());
        $articulos = addarticulo::all();
        return \View::make('configuraciones.articulos', compact('articulos'));
        
	}
    public function baja(Request $id)
    {
        $update = articulos::findOrFail($id);

        $update->update($id)

    }
}
