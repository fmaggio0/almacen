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

    $roles = DB::table('roles')
        ->select(['name', 'display_name', 'description', 'id'])
        ->lists('id');

    /*$permisos = DB::table('permissions')
        ->select(['name', 'display_name', 'description', 'id'])
        ->get();*/

    foreach ($roles as $role => $item) {
        $permisos = DB::select('SELECT GROUP_CONCAT(permissions.display_name) as concat
            FROM
              permission_role
            INNER JOIN
              permissions ON permission_role.permission_id = permissions.id
            WHERE
              permission_role.role_id = '.$item->id.'
            GROUP BY
              permission_role.role_id');

        //return $permisos[0]->concat;

    }
    //return $roles;
    	//return view('cil.cil_usuarios')->with('roles', $roles)->with('permisos', $permisos);
    }
    public function UsuariosNuevo(){
        return view('cil.cil_usuarios_nuevo');
    }
    public function UsuariosModificar($id){

    	$user = User::find($id);

        $empleado = Empleados::select('Nombres', 'Apellido')
                           ->where('Nro_Legajo', '=', $user->id_empleado)
                           ->get();

        return View::make('cil.cil_usuarios_modificar')->with('user', $user)->with('empleado', $empleado);
    }
    public function UsuariosNuevoPost(Request $request){

        DB::beginTransaction();
        
        try 
        {
           //Validaciones
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255|unique:users',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|confirmed|min:6',
                'id_empleado' => 'required|integer|unique:users'
            ]);

            if ($validator->fails()) {
                return redirect()
                            ->back()
                            ->withErrors($validator)
                            ->withInput();
            }


            $query = new User;
                $query->name = $request->name;
                $query->email = $request->email;
                $query->id_empleado = $request->id_empleado;
                $query->password = bcrypt($request->password);
            $query->save();

            $query->roles()->attach($request->roles);

            //Commit y redirect con success
            DB::commit();
            return redirect("/cil/usuarios")
                ->with('status', 'Usuario creado correctamente');
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

            $prueba = array();


            //Eliminar roles
            foreach ($query->roles as $key => $value) {
                array_push($prueba, $value->id);
                if (!in_array($value->id, $request->roles)) {
                    $query->roles()->detach($value->id);
                }
            }

            //Agregar roles
            foreach ($request->roles as $key => $value) {
                if (!in_array($value, $prueba)) {
                    $query->roles()->attach($value);
                }
            }

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
