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
use App\SubAreas;
use App\Empleados;
use Validator;
use Exception;
use Input;
use View;


class MovimientosController extends Controller
{
    public function Ingresos(){

        return view('movimientos.ingresos');
    }

    public function NuevoIngreso(){

        return view('movimientos.ingresos_nuevo');
    }
    
	public function indexegresos(){

		return view('movimientos.egresos');
	}

    public function indexmodificaregresos($id){

        $master = DB::table('salidas_master')
            ->where('id_master', '=', $id )
            ->join('subareas', 'salidas_master.id_subarea', '=', 'subareas.id_subarea')
            ->select('salidas_master.id_master', 'salidas_master.tipo_retiro', 'salidas_master.estado', 'salidas_master.id_subarea',  'subareas.descripcion_subarea')
        ->first();

        $detalles = DB::table('salidas_detalles')
            ->where('id_master', '=', $id )
            ->join('articulos', 'salidas_detalles.id_articulo', '=', 'articulos.id_articulo')
            ->join('personal_prod.tpersonal as empleados', 'salidas_detalles.id_empleado', '=', 'empleados.Nro_Legajo')
            ->select('salidas_detalles.id_detalles', 'salidas_detalles.id_articulo', 'salidas_detalles.id_empleado', 'salidas_detalles.cantidad', 'empleados.Nombres', 'empleados.Apellido', 'articulos.descripcion')
        ->get();

        $estado = $master->estado;

       if($estado == 1){
            return View::make('movimientos.egresos_modificar')->with('master', $master)->with('detalles', $detalles);
        }
        else{
            return redirect('/egresos')->with('status', 'No se puede modificar este movimiento porque no se creo como "Dejar pendiente"');
        }
    }

    public function IndexEgresosNuevo(){
        return view('movimientos.egresos_nuevo');
    }
    
    public function storeingreso(Request $request){

        DB::beginTransaction();
        
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
            $master->fecha_factura = $request->fecha;
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
            return redirect("/ingresos")
                ->with('status', 'Ingreso procesado correctamente');
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
            return redirect('/egresos')
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

    public function ModificarEgreso(Request $request){
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
            }
            */
            
            $update = SalidasMaster::findOrFail($request->id_master);
                $update->estado = 0;
            $update->save();

            $ids_detalles_enviados = array();

            $ids_detalles_query = SalidasDetalles::where('id_master', $request->id_master)->pluck('id_detalles')->toArray();

            for($i=0;$i <count($request->articulos);$i++)
            {             
               if($request->estado[$i] == "viejo" && $request->id_detalle[$i] != "null"){
                    array_push($ids_detalles_enviados, intval($request->id_detalle[$i]));
                }
                else if($request->estado[$i] == "nuevo"){
                    $detalles = array(
                                'id_master' => $request->id_master,
                                'id_articulo'=> $request->articulos[$i],
                                'id_empleado'  => $request->empleados[$i],
                                'cantidad' => $request->cantidad[$i]
                                );
                    SalidasDetalles::create($detalles);

                    $update2 = Articulos::findOrFail($request->articulos[$i]);
                        $update2->decrement('stock_actual', $request->cantidad[$i]);
                    $update2->save();
                }
            }  

            $array = array_diff($ids_detalles_query, $ids_detalles_enviados);
            $ids_a_eliminar = array_values($array);

            for($i=0;$i <count($ids_a_eliminar);$i++)
            {             
                $query = SalidasDetalles::findOrFail($ids_a_eliminar[$i]);
                $update3 = Articulos::findOrFail($query->id_articulo);
                    $update3->increment('stock_actual', $query->cantidad);
                $update3->save();
            }  

            SalidasDetalles::destroy($ids_a_eliminar);

            //Commit y redirect con success
            DB::commit();
            return redirect('/egresos')
                ->with('status', 'Salida procesada correctamente');
        }

        catch (Exception $e)
        {
            //Rollback y redirect con error
            DB::rollback();
            return redirect('/egresos')
                ->withErrors('Se ha producido un errro: ( ' . $e->getCode() . ' ): ' . $e->getMessage().' - Copie este texto y envielo a informática');
        }
    }
    

}
