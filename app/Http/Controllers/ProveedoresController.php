<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Proveedores;

use DB;
class ProveedoresController extends Controller
{
    public function index(){

		return view('configuraciones.proveedores.proveedores');
	}

    public function indexNuevo(){

        return view('configuraciones.proveedores.nuevo');
    }

    public function indexEdit($id){

        $proveedor = Proveedores::find($id);
        return view('configuraciones.proveedores.edit')->with('proveedor', $proveedor);
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
        DB::beginTransaction();
        try
        {
        $this->Validate($request, [
            'nombre' => 'required|max:60',
            'direccion' => 'required|max:60',
            'email'    => 'max:60',
            'telefono' => 'max:60',
            'cuit' => 'max:60',
            'observaciones' => 'max:255',
            'rubros' => 'max:255',
        ]);
 
        $id = $request->id_proveedor;
        $update = Proveedores::findOrFail($id);
            $update->nombre             = $request->nombre;
            $update->direccion          = $request->direccion;
            $update->coordenadas        = $request->coordinatesx.','.$request->coordinatesy;
            $update->cuit               = $request->cuit;
            $update->email              = $request->email;
            $update->telefono           = $request->telefono;
            $update->observaciones      = $request->observaciones;
            $update->rubros             = implode(",",$request->rubros);
        $update->save();
        DB::commit();
        return redirect("/proveedores")->with('status', 'Se ha modificado correctamente el proveedor.');
        }
        catch(Exception $e){
            DB::rollback();
            return redirect("/proveedores")->with('status', 'Se ha producido un errro: ( ' . $e->getCode() . ' ): ' . $e->getMessage().' - Copie este texto y envielo a informática');
        }
        
    }
    public function store(Request $request){
        DB::beginTransaction();
        try 
        {
            //Validaciones
            $this->validate($request, [
                'nombre' => 'required|max:60|unique:proveedores',
                'direccion' => 'required|max:60',
                'email'    => 'max:60',
                'telefono' => 'max:60',
                'cuit' => 'max:60',
                'observaciones' => 'max:255',
                'rubros' => 'max:255',
            ]);
            
                $proveedor = new Proveedores;
                    $proveedor->nombre             = $request->nombre;
                    $proveedor->direccion          = $request->direccion;
                    $proveedor->coordenadas        = $request->coordinatesx.','.$request->coordinatesy;
                    $proveedor->cuit               = $request->cuit;
                    $proveedor->email              = $request->email;
                    $proveedor->telefono           = $request->telefono;
                    $proveedor->observaciones      = $request->observaciones;
                    $proveedor->rubros             = implode(",", $request->rubros);
                $proveedor->save();

            

            //Commit y redirect con success
            DB::commit();
            return redirect("/proveedores")->with('status', 'Se ha añadido correctamente el proveedor.');
        }
        catch (Exception $e)
        {
            //Rollback y redirect con error
            DB::rollback();
            return redirect("/proveedores")->with('status', 'Se ha producido un errro: ( ' . $e->getCode() . ' ): ' . $e->getMessage().' - Copie este texto y envielo a informática');
        }
    }
}
