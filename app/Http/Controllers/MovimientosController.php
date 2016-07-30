<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Http\RedirectResponse;
use DB;
use App\Http\Controllers\Controller;
use App\SalidasMaster;
use App\SalidasDetalles;
use App\AutorizacionesMaster;
use Validator;
use Exception;


class MovimientosController extends Controller
{
	public function index(){

		return view('movimientos.salidas');
	}

	public function store(Request $request){

        DB::beginTransaction();

        try 
        {
            //Validaciones
            $validator = Validator::make($request->all(), [
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
            }

            //Cargar datos en la tabla salida master
            $master = new SalidasMaster;
            $master->tipo_retiro = $request->tipo_retiro;
            $master->id_subarea = $request->destino;
            $master->id_usuario = $request->usuario;

            //Si es una autorizacion, cambiamos el estado de la autorizacion a 1(Autorizado)
            if ( $master->tipo_retiro == "Autorizacion de recursos" || $master->tipo_retiro == "Autorizacion de elementos de seguridad")
            {
                $id = $request->id_autorizacion;
                $update = AutorizacionesMaster::findOrFail($id);
                $update->estado = 1;
                $update->save();
               
            }

            //Guardamos salidas master
            $master->save();

            //Obtenemos el id 
            $id = $master->id_master;


            //Cargamos datos en la tabla salida detalles
            if($id > 0)
            {
                for($i=0;$i <count($request->articulos);$i++)
                {
                    $detalles = array(
                                    'id_master' => $id,
                                    'id_articulo'=> $request->articulos[$i],
                                    'id_empleado'  => $request->empleados[$i],
                                    'cantidad' => $request->cantidad[$i]
                                    );
                    SalidasDetalles::create($detalles);
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
