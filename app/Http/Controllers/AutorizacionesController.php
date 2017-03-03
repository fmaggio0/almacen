<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\AutorizacionesMaster;
use App\AutorizacionesDetalles;
use App\SalidasDetalles;
use App\SalidasMaster;
use App\Articulos;
use App\Http\Requests;
use Auth;
use App\Areas;
use Response;
use DB;


class AutorizacionesController extends Controller
{
    
    public function index(){
        return view('autorizaciones.autorizaciones_retiro');    
    }

	public function store(Request $request){
        DB::beginTransaction();
        try 
        {

    	    $master = new AutorizacionesMaster;

    	    $post = $request->all();

    	    $master->tipo_retiro = $post['tipo_retiro'];
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

            //Actualizamos AutorizacionesMaster con:
            //	0 - Pendiente
            //	1 - Autorizado totalmente
            //  2 - Autorizado parcialmente
            //  3 - No autorizado

            if($count == 0){
            	$id_master = $request->id_master;
	            $update = AutorizacionesMaster::findOrFail($id_master);
	            $update->estado = 1;
	            $update->save();
            }
            else if($count == count($request->id_detalles)){
            	$id_master = $request->id_master;
	            $update = AutorizacionesMaster::findOrFail($id_master);
	            $update->estado = 3;
	            $update->save();
            }
            else{
                $id_master = $request->id_master;
                $update = AutorizacionesMaster::findOrFail($id_master);
                $update->estado = 2;
                $update->save();
            }

            $cantidad_registros = count($request->id_detalles);

            //return "$cantidad_registros $count";

            if( $cantidad_registros == $count ){
            }
            else{
                //Replicamos la AutorizacionesMaster en una SalidasMaster
                $id_master = $request->id_master;
                $obtenermaster = AutorizacionesMaster::findOrFail($id_master);
                $salidasmaster = new SalidasMaster;
                $salidasmaster->tipo_retiro = $obtenermaster->tipo_retiro;
                $salidasmaster->estado = 0;
                $salidasmaster->id_subarea = $obtenermaster->id_subarea;
                $salidasmaster->id_usuario = $request->id_usuario;
                $salidasmaster->save();

                //Por cada una AutorizacionesDetalles creamos una SalidasDetalles
                for($i=0;$i <count($request->id_detalles);$i++)
                {
                    if($request->estado[$i] == 1){
                        $id = $request->id_detalles[$i];
                        $obtenerdetalles = AutorizacionesDetalles::findOrFail($id);
                        $salidasdetalles = new SalidasDetalles;
                        $salidasdetalles->id_master = $salidasmaster->id_master;
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
