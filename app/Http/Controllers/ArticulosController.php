<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use App\Http\Controllers\Controller;
use App\Articulos;

class ArticulosController extends Controller
{
	public function index(){

		return view('configuraciones.articulos');
	}

	public function store(Request $request)
	{
        $articulo = new Articulos;
     
        $v = \Validator::make($request->all(), [
            
            'descripcion' => 'required|max:255',
            'unidad' => 'required|max:20',
            'id_usuario'    => 'required', //modificar cuando cambie la tabla
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
        $update = Articulos::findOrFail($id);
        $update->estado = false;
        $update->save();
        return \View::make('configuraciones.articulos');
    }
    public function edit(Request $request)
    {
        $v = \Validator::make($request->all(), [
            
            'descripcion' => 'required|max:255|min:4',
            'unidad' => 'required|max:20',
            'id_usuario'    => 'required', //modificar cuando cambie la tabla
            'id_rubro' => 'required|numeric',
            'id_subrubro' => ''
        ]);
 
        if ($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $id = $request->id_articulo;
        $update = Articulos::findOrFail($id);
        $update->descripcion         = $request->descripcion;
        $update->unidad              = $request->unidad;
        $update->id_rubro            = $request->id_rubro;
        $update->id_subrubro         = $request->id_subrubro;
        $update->id_usuario             = $request->id_usuario;
        $update->save();
        return \View::make('configuraciones.articulos');
    }
    public function getArticulos(Request $request)
    {
        $term = $request->term ?: '';
        $tags = DB::table ('articulos')
            ->where('descripcion', 'like', $term.'%')
            ->select('descripcion AS text', 'id_articulo AS id', 'stock_actual', 'unidad')
            ->get();
        json_encode($tags);
        return $tags;
    }
}
