<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use App\Http\Controllers\Controller;
use App\Articulos;

class ArticulosController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

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
        DB::beginTransaction();
        try 
        {
            //Validaciones
            $this->validate($request, [
                'descripcion' => 'required|max:255|unique:articulos',
                'unidad' => 'required|max:20',
                'id_rubro' => 'required|numeric',
                'id_subrubro' => ''
            ]);
            
            $articulo = new Articulos;
                $articulo->descripcion         = strtoupper($request->descripcion);
                $articulo->unidad              = strtoupper($request->unidad);
                $articulo->tipo                = strtoupper($request->tipo);
                $articulo->id_rubro            = $request->id_rubro;
                $articulo->id_subrubro         = $request->id_subrubro;
                $articulo->stock_actual        = 0;
            $articulo->save();
            

            //Commit y redirect con success
            DB::commit();
            return redirect("/articulos")->with('status', 'Se ha añadido correctamente el articulo.');
        }
        catch (Exception $e)
        {
            //Rollback y redirect con error
            DB::rollback();
            return redirect("/articulos")->with('status', 'Se ha producido un errro: ( ' . $e->getCode() . ' ): ' . $e->getMessage().' - Copie este texto y envielo a informática');
        }
	}

    public function edit(Request $request)
    {
        DB::beginTransaction();
        try 
        {
            //Validaciones
            $this->validate($request, [
                'descripcion' => 'required|max:255|min:4',
                'unidad' => 'required|max:20',
                'id_rubro' => 'required|numeric'
            ]);
            
            $id = $request->id_articulo;
            $update = Articulos::findOrFail($id);
                $update->descripcion         = strtoupper($request->descripcion);
                $update->unidad              = strtoupper($request->unidad);
                $update->id_rubro            = $request->id_rubro;
                $update->id_subrubro         = $request->id_subrubro;
                $update->stock_minimo        = $request->stock_minimo;
            $update->save();

            

            //Commit y redirect con success
            DB::commit();
            return redirect("/articulos")->with('status', 'Se ha añadido correctamente el articulo.');
        }
        catch (Exception $e)
        {
            //Rollback y redirect con error
            DB::rollback();
            return redirect("/articulos")->with('status', 'Se ha producido un errro: ( ' . $e->getCode() . ' ): ' . $e->getMessage().' - Copie este texto y envielo a informática');
        }
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
}
