<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Autorizaciones;
use App\AutorizacionesDetalles;
use App\SalidasDetalles;
use App\Salidas;
use App\Articulos;
use App\Http\Requests;
use Auth;
use App\Areas;
use Response;
use DB;
use Event;
use App\Events\AutorizacionesEvent;


class AutorizacionesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('autorizaciones.autorizaciones_retiro');    
    }

	public function store(Request $request){
        DB::beginTransaction();
        try 
        {

    	    $post = $request->all();

            $master = new Autorizaciones;
        	    $master->id_subarea = $post['destino'];
        	    $master->id_usuario = $post['usuario'];
    	    $master->save();

    	    $j = $master->id_master;

    			if($j > 0)
    			{
    		        for($i=0;$i <count($post['articulos1']);$i++)
    		        {
    		            $detalles = array(
    		                                'id_master' => $j,
    		                                'id_articulo'=> $post['articulos1'][$i],
    		                                'id_empleado'  => $post['empleados1'][$i],
    		                                'cantidad' => $post['cantidad1'][$i]
    		                                );
    		            AutorizacionesDetalles::create($detalles);
    		        }
                }

            //Commit y redirect con success
            DB::commit();

            return redirect('/areas/autorizaciones')
                ->with('status', 'Salida procesada correctamente');
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

	public function storeadmin(Request $request){

   		/*$post = $request->all();

    	return Response::json($post);*/

    	///////////////////////////////////////////////

    	DB::beginTransaction();

        try 
        { 
            //Validaciones
            /*$validator = Validator::make($request->all(), [
                'tipo_retiro' => 'required|max:60',
                'destino' => 'required|integer',
                'usuario' => 'required|integer',
                'cantidad*' => 'required'
            ]);

            if ($validator->fails()) {
                return redirect()
                            ->back()
                            ->withErrors($validator)
                            ->withInput();
            }*/

       		//Actualizamos AutorizacionesDetalles con el estado que corresponda
            $count = 0;
            for($i=0;$i <count($request->id_detalles);$i++)
            {
	            $id = $request->id_detalles[$i];
	            if($request->estado[$i] == 2){
	            	$count++;
	            }
                $update = AutorizacionesDetalles::findOrFail($id);
                $update->estado = $request->estado[$i];
                $update->save();
            }

            //Actualizamos Autorizaciones con:
            //	0 - Pendiente
            //	1 - Autorizado totalmente
            //  2 - Autorizado parcialmente
            //  3 - No autorizado

            if($count == 0){
            	$id_master = $request->id_master;
	            $update = Autorizaciones::findOrFail($id_master);
	            $update->estado = 1;
	            $update->save();
            }
            else if($count == count($request->id_detalles)){
            	$id_master = $request->id_master;
	            $update = Autorizaciones::findOrFail($id_master);
	            $update->estado = 3;
	            $update->save();
            }
            else{
                $id_master = $request->id_master;
                $update = Autorizaciones::findOrFail($id_master);
                $update->estado = 2;
                $update->save();
            }

            $cantidad_registros = count($request->id_detalles);

            //return "$cantidad_registros $count";

            if( $cantidad_registros == $count ){
            }
            else{
                //Replicamos la Autorizaciones en una Salidas
                $id_master = $request->id_master;
                $obtenermaster = Autorizaciones::findOrFail($id_master);
                $Salidas = new Salidas;
                $Salidas->origen = "salida_autorizacion";
                $Salidas->estado = 0;
                $Salidas->id_subarea = $obtenermaster->id_subarea;
                $Salidas->id_usuario = $request->id_usuario;
                $Salidas->save();

                //Por cada una AutorizacionesDetalles creamos una SalidasDetalles
                for($i=0;$i <count($request->id_detalles);$i++)
                {
                    if($request->estado[$i] == 1){
                        $id = $request->id_detalles[$i];
                        $obtenerdetalles = AutorizacionesDetalles::findOrFail($id);
                        $salidasdetalles = new SalidasDetalles;
                        $salidasdetalles->id_master = $Salidas->id_master;
                        $salidasdetalles->id_articulo = $obtenerdetalles->id_articulo;
                        $salidasdetalles->id_empleado = $obtenerdetalles->id_empleado;
                        $salidasdetalles->cantidad = $obtenerdetalles->cantidad;
                        $salidasdetalles->save();

                        $update = Articulos::findOrFail($obtenerdetalles->id_articulo);
                        $update->decrement('stock_actual', $obtenerdetalles->cantidad);
                        $update->save();
                    }
                }
            }

            //Commit y redirect con success
            DB::commit();
            return redirect()
                ->back()
                ->with('status', 'Salida procesada correctamente');
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
