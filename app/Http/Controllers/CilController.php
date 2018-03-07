<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User; 

use App\Empleados;

use App\Role;  

use App\Permission;  

use Auth;

use View;

use DB;

use Validator;

class CilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function Index(){
    	return view('cil.cil_index');
    }
    public function Usuarios(){
        return view('cil.cil_usuarios');
    }
    public function RolesIndex(){

        $permisos = Permission::all();

        return view('cil.cil_usuarios_rolesypermisos')->with('permisos', $permisos);
    }
    public function UsuariosNuevo(){
        return view('cil.cil_usuarios_nuevo');
    }

    public function RolesNuevo(){
        return view('cil.cil_roles_nuevo');
    }

    public function RolesUpdate($id){

        $role = Role::find($id);

        return view('cil.cil_roles_modificar')->with('role', $role);
    }

    public function PermisosUpdate($id){

        $permiso = Permission::find($id);

        return view('cil.cil_permisos_modificar')->with('permiso', $permiso);
    }

    public function PermisosNuevo(){
        return view('cil.cil_permisos_nuevo');
    }

    public function UsuariosModificar($id){

    	$user = User::find($id);

        $empleado = Empleados::select('nombres', 'apellidos')
                           ->where('id_empleado', '=', $user->id_empleado)
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
    public function RolesNuevoPost(Request $request){

        DB::beginTransaction();
        
        try 
        {   
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'display_name' => 'required|max:255',
                'description' => 'required|max:255',
            ]);

            if ($validator->fails()) {
            return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput();
            }
            
            $query = new Role;
                $query->name = $request->name;
                $query->display_name = $request->display_name;
                $query->description = $request->description;
            $query->save();

            $query->permisos()->attach($request->permisos);
           
            //Commit y redirect con success
            DB::commit();
            return redirect("/cil/roles")
                ->with('status', 'Rol creado correctamente');
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
    public function RolesUpdatePost(Request $request){

        DB::beginTransaction();
        
        try 
        {
           //Validaciones
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'display_name' => 'required|max:255',
                'description' => 'required|max:255',
            ]);

            if ($validator->fails()) {
                return redirect()
                            ->back()
                            ->withErrors($validator)
                            ->withInput();
            }

            $query = Role::findOrFail($request->role_id);
                $query->name = $request->name;
                $query->display_name = $request->display_name;
                $query->description = $request->description;
            $query->save();

            $prueba = array();

            //Eliminar permisos
            if($query->permisos != ""){
                foreach ($query->permisos as $key => $value) {
                    array_push($prueba, $value->id);
                    if (!in_array($value->id, $request->permisos)) {
                        $query->permisos()->detach($value->id);
                    }
                }

                //Agregar permisos
                foreach ($request->permisos as $key => $value) {
                    if (!in_array($value, $prueba)) {
                        $query->permisos()->attach($value);
                    }
                }
            }

            //Commit y redirect con success
            DB::commit();
            return redirect("/cil/roles")
                ->with('status', 'Rol modificado correctamente');
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
    public function PermisosNuevoPost(Request $request){

        DB::beginTransaction();
        
        try 
        {
           //Validaciones
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255|unique:permissions',
                'display_name' => 'required|max:255|unique:permissions',
                'description' => 'required|max:255',
            ]);

            if ($validator->fails()) {
                return redirect()
                            ->back()
                            ->withErrors($validator)
                            ->withInput();
            }

            $query = new Permission;
                $query->name = $request->name;
                $query->display_name = $request->display_name;
                $query->description = $request->description;
            $query->save();

            //Commit y redirect con success
            DB::commit();
            return redirect("/cil/roles")
                ->with('status', 'Permiso creado correctamente');
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
    public function PermisosUpdatePost(Request $request){

        DB::beginTransaction();
        
        try 
        {
           //Validaciones
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'display_name' => 'required|max:255',
                'description' => 'required|max:255',
            ]);

            if ($validator->fails()) {
                return redirect()
                            ->back()
                            ->withErrors($validator)
                            ->withInput();
            }

            $query = Permission::findOrFail($request->permiso_id);
                $query->name = $request->name;
                $query->display_name = $request->display_name;
                $query->description = $request->description;
            $query->save();

            //Commit y redirect con success
            DB::commit();
            return redirect("/cil/roles")
                ->with('status', 'Rol modificado correctamente');
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
