<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User; 

use App\Empleados; 

use Auth;

use View;

use DB;

use Validator;

class CilController extends Controller
{
    public function Index(){
    	return view('cil.cil_index');
    }
    public function Usuarios(){
    	return view('cil.cil_usuarios');
    }
    public function UsuariosModificar($id){

    	$user = User::find($id);

        $empleado = Empleados::select('Nombres', 'Apellido')
                           ->where('Nro_Legajo', '=', $user->id_empleado)
                           ->get();

        return View::make('cil.cil_usuarios_modificar')->with('user', $user)->with('empleado', $empleado);
    }

    public function UsuariosUpdate(Request $request){

        DB::beginTransaction();
        
        try 
        {
           //Validaciones
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255',
                'id_empleado' => 'required|integer'
            ]);

            if ($validator->fails()) {
                return redirect()
                            ->back()
                            ->withErrors($validator)
                            ->withInput();
            }

            $query = User::findOrFail($request->id_user);
                $query->name = $request->name;
                $query->email = $request->email;
                $query->id_empleado = $request->id_empleado;
            $query->save();

            foreach ($query->roles as $key => $value) {
                if (!in_array($value->id, $request->roles)) {
                    $query->roles()->detach($value->id);
                }
                else{
                    $query->roles()->attach($value->id);
                }
            }

            //return $query->roles[0]["id"];

            //Commit y redirect con success
            DB::commit();
            return redirect("/cil/usuarios")
                ->with('status', 'Usuario modificado correctamente');
        }

        catch (Exception $e)
        {
            //Rollback y redirect con error
            DB::rollback();
            return redirect()
                ->back()
                ->withErrors('Se ha producido un errro: ( ' . $e->getCode() . ' ): ' . $e->getMessage().' - Copie este texto y envielo a informática');
        }
    }
}
