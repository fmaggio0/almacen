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
       /* $update = articulos::findOrFail($id); */
        $id = $request->id_articulo;
        $update = articulos::findOrFail($id);
        $update->estado = false;
        $update->save();
       /*$request->where('id_articulo', $id)->update(array('estado' => 'false'));*/
       return \View::make('configuraciones.articulos');
    }
}
