<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;
use App\Areas;
use App\Empleados;
use Auth;
use DB;
use Validator;


class AreasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
		return view('areas.areas_index');
	}

	public function IndexAutorizaciones(){
		return view('areas.areas_autorizaciones');
	}

	public function NuevaAutorizacion(){
		return view('areas.areas_autorizaciones_nueva')->with("id_area", User::find(Auth::user()->id)->empleados->id_area);
	}

	public function indexIndumentaria(){
		return view('areas.areas_indumentaria');
	}

	public function modificarIndumentaria($id){

		$area = Areas::find(User::find(Auth::user()->id)->empleados->id_area);

		return view('areas.areas_indumentaria_modificar')->with("empleado", Empleados::find($id))->with("area", $area);
	}

	public function modificarIndumentariaPost(Request $request){
		DB::beginTransaction();
        try 
        {
           //Validaciones
            $validator = Validator::make($request->all(), [
                'id_empleado' => 'required',
                'talle_remera' => 'required',
                'talle_camisa' => 'required|integer',
                'talle_calzado' => 'required|integer'
            ]);

            if ($validator->fails()) {
                return redirect()
                            ->back()
                            ->withErrors($validator)
                            ->withInput();
            }

            $id = $request->id_empleado;
	        $update = Empleados::findOrFail($id);
	            $update->talle_remera       = $request->talle_remera;
	            $update->talle_camisa       = $request->talle_camisa;
	            $update->talle_calzado      = $request->talle_calzado;
	        $update->save();

            //Commit y redirect con success
            DB::commit();
            return redirect("/areas/indumentaria")
                ->with('status', 'Se ha modificado la indumentaria correctamente.');
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
