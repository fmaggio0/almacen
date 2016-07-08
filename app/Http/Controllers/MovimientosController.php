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


class MovimientosController extends Controller
{
	public function index(){

		return view('movimientos.salidas');
	}

	public function store(Request $request){

       

        DB::beginTransaction();

        try {

            $master = new SalidasMaster;

            $post = $request->all();

            $master->tipo_retiro = $post['tipo_retiro'];
            $master->id_subarea = $post['destino'];
            $master->id_usuario = $post['usuario'];

           if ( $master->tipo_retiro == "Autorizacion de recursos" || $master->tipo_retiro == "Autorizacion de elementos de seguridad")
            {
                $id = $post['id_autorizacion'];
                $update = AutorizacionesMaster::findOrFail($id);
                $update->estado = 1;
                $update->save();
                $errors = "estado= 1";
            }

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
                    SalidasDetalles::create($detalles);
                }
                return $errors;
                
            }
        }
        // Ha ocurrido un error, devolvemos la BD a su estado previo y hacemos lo que queramos con esa excepción
        catch (\Exception $e)
        {
                DB::rollback();
                // no se... Informemos con un echo por ejemplo
                $errors = "chau";
                return $errors;
        }

        // Hacemos los cambios permanentes ya que no han habido errores
        DB::commit();
        return back()->withInput();
	}
}
