<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Proveedores;

class ProveedoresController extends Controller
{
    public function index(){

		return view('configuraciones.proveedores');
	}

	public function store(Request $request)
	{
        $articulo = new Proveedores;
     
     //VALIDACIONES DEL LADO DEL SERVIDOR

        $v = \Validator::make($request->all(), [
            
            'nombre' => 'required|max:60|unique:proveedores',
            'direccion' => 'max:60',
            'email'    => 'max:60',
            'telefono' => 'max:60',
            'id_usuario'    => 'required',
            'observaciones' => 'max:255',
            'rubros' => 'max:255',
        ]);
 
        if ($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }
        
        $articulo->create($request->all());
        return response()->json(['msg' => 'Success!']);
	}

    public function baja(Request $request)
    {
        $id = $request->id_proveedor;
        $update = Proveedores::findOrFail($id);
        $update->estado = false;
        $update->save();
        return back()->withInput();
    }

     public function activar(Request $request)
    {
        $id = $request->id_proveedor;
        $update = Proveedores::findOrFail($id);
        $update->estado = true;
        $update->save();
        return back()->withInput();
    }

    public function edit(Request $request)
    {
        $v = \Validator::make($request->all(), [
            'nombre' => 'required|max:60',
            'direccion' => 'max:60',
            'email'    => 'max:60',
            'telefono' => 'max:60',
            'id_usuario'    => 'required',
            'observaciones' => 'max:255',
            'rubros' => 'max:255',
        ]);
 
        if ($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $id = $request->id_proveedor;
        $update = Proveedores::findOrFail($id);
        $update->nombre             = $request->nombre;
        $update->direccion          = $request->direccion;
        $update->email              = $request->email;
        $update->telefono           = $request->telefono;
        $update->observaciones      = $request->observaciones;
        $update->rubros             = $request->rubros;
        $update->id_usuario         = $request->id_usuario;
        $update->save();
        return response()->json(['msg' => 'Success!']);
    }
}
