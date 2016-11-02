<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Http\RedirectResponse;
use DB;
use App\Http\Controllers\Controller;
use App\Articulos;
use App\SalidasMaster;
use App\SalidasDetalles;
use App\IngresosMaster;
use App\IngresosDetalles;
use App\AutorizacionesMaster;
use Validator;
use Exception;
use Input;


class MovimientosController extends Controller
{
    public function indexingresos(){

        return view('movimientos.ingresos');
    }
    
	public function indexegresos(){

		return view('movimientos.egresos');
	}
    
    public function storeingreso(Request $request){

        try 
        {
           //Validaciones
            $validator = Validator::make($request->all(), [
                'tipo_ingreso' => 'required|max:60',
                'id_usuario' => 'required|integer',
                'cantidad*' => 'required|integer'
            ]);

            if ($validator->fails()) {
                return redirect()
                            ->back()
                            ->withErrors($validator)
                            ->withInput();
            }

            //Cargar datos en la tabla salida master
            $master = new IngresosMaster;
            $master->tipo_ingreso = $request->tipo_ingreso;
            $master->tipo_comprobante = $request->tipo_comprobante;
            $master->nro_comprobante = $request->nro_comprobante;
            $master->descripcion = $request->descripcion;
            $master->id_proveedor = $request->id_proveedor;
            $master->id_usuario = $request->id_usuario;
            $master->total_factura = $request->total_factura;
            $master->estado = 1;


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
                                    'cantidad' => $request->cantidad[$i],
                                    'precio_unitario' => $request->precio_unitario[$i],
                                    );
                    IngresosDetalles::create($detalles);

                    $id_articulo = $request->articulos[$i];
                    $cantidad = $request->cantidad[$i];

                    $update = Articulos::findOrFail($id_articulo);
                    $update->stock_minimo = $request->stock_minimo[$i];
                    $update->increment('stock_actual', $cantidad);
                    $update->save();

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

	public function storeegreso(Request $request){

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

            if(Input::get('pendiente')) {
                $master->estado = 1;
            }

            //Si proviene de una autorizacion, cambiamos el estado de la autorizacion a 1(Autorizado)
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

                    $id_articulo = $request->articulos[$i];
                    $cantidad = $request->cantidad[$i];

                    $update = Articulos::findOrFail($id_articulo);
                    $update->decrement('stock_actual', $cantidad);
                    $update->save();
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
