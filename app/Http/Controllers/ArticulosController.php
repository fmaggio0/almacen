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

		return view('configuraciones.articulos.articulos');
	}

    public function indexNuevo(){

        return view('configuraciones.articulos.nuevo');
    }

    public function indexEdit($id){

        $articulo = Articulos::find($id);
        return view('configuraciones.articulos.edit')->with('articulo', $articulo);
    }

	public function store(Request $request)
	{
        
     
        $v = \Validator::make($request->all(), [
            
            'descripcion' => 'required|max:255|unique:articulos',
            'unidad' => 'required|max:20',
            'id_rubro' => 'required|numeric',
            'id_subrubro' => ''
        ]);
 
        if ($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $articulo = new Articulos;
            $articulo->descripcion         = $request->descripcion;
            $articulo->unidad              = $request->unidad;
            $articulo->id_rubro            = $request->id_rubro;
            $articulo->id_subrubro         = $request->id_subrubro;
            $articulo->stock_actual        = 0;
        $articulo->save();

        return redirect("/articulos")->with('status', 'Se ha añadido correctamente el articulo.');
	}

    public function baja(Request $request)
    {
        $id = $request->id_articulo;
        $update = Articulos::findOrFail($id);
        $update->estado = false;
        $update->save();
        return back()->withInput();
    }

     public function activar(Request $request)
    {
        $id = $request->id_articulo;
        $update = Articulos::findOrFail($id);
        $update->estado = true;
        $update->save();
        return back()->withInput();
    }

    public function edit(Request $request)
    {
        $v = \Validator::make($request->all(), [
            
            'descripcion' => 'required|max:255|min:4',
            'unidad' => 'required|max:20',
            'id_rubro' => 'required|numeric'
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
            $update->stock_minimo        = $request->stock_minimo;
        $update->save();
        
        return redirect("/articulos")->with('status', 'Se ha modificado correctamente el articulo.');
    }
}
