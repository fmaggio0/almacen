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
        return \View::make('configuraciones.articulos');
	}
    public function baja(Request $request)
    {
        $id = $request->id_articulo;
        $update = articulos::findOrFail($id);
        $update->estado = false;
        $update->save();
        return \View::make('configuraciones.articulos');
    }
    public function edit(Request $request)
    {
        $v = \Validator::make($request->all(), [
            
            'descripcion' => 'required|max:255|min:4',
            'unidad' => 'required|max:20',
            'usuario'    => 'required|max:255', //modificar cuando cambie la tabla
            'id_rubro' => 'required|numeric',
            'id_subrubro' => ''
        ]);
 
        if ($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $id = $request->id_articulo;
        $update = articulos::findOrFail($id);
        $update->descripcion         = $request->descripcion;
        $update->unidad              = $request->unidad;
        $update->id_rubro            = $request->id_rubro;
        $update->id_subrubro         = $request->id_subrubro;
        $update->usuario             = $request->usuario;
        $update->save();
        return \View::make('configuraciones.articulos');
    }
}
