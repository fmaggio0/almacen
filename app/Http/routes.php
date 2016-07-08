<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('auth.login');
});

//Gestionar autorizaciones

	Route::get('/autorizaciones', ['as' => 'gestionarautorizacion', function (){
		 return view('autorizaciones.autorizaciones_retiro');
	}]);


	Route::get('/autorizaciones/details/{id}', function ($id) {      
	$detalles=DB::table('autorizaciones_detalles')
		->where('id_master', '=', $id)
		->join('articulos', 'articulos.id_articulo', '=', 'autorizaciones_detalles.id_articulo')
		->join('empleados', 'empleados.id_empleado', '=', 'autorizaciones_detalles.id_empleado')
		->select('articulos.id_articulo', 'articulos.descripcion','autorizaciones_detalles.id_empleado', 'empleados.nombre','empleados.apellido', 'autorizaciones_detalles.cantidad' )
		->get();
    return Response::json($detalles);
});

	Route::post('/autorizaciones/guardar', 	['as' => 'autorizaciones.view', 'uses' =>'DatatablesController@autorizacionesdetallesadmin']);

//Fin Gestionar autorizaciones

Route::get('/autorizar/id', ['as' => 'autorizar_retiro', function (){
	 return view('autorizaciones.autorizar_retiro');
}]);

Route::get('/salidas', array('as' => 'salidas', 'uses' => 'MovimientosController@index' ));

Route::get('/articulos', array('as' => 'articulos', 'uses' => 'ArticulosController@index' ));







Route::post('/articulos/addarticulo', 			['as' => 'addarticulos', 'uses' => 'ArticulosController@store']);

Route::post('/articulos/dardebaja', 			['as' => 'dardebaja', 'uses' => 'ArticulosController@baja']);

Route::post('/articulos/activar', 			['as' => 'activar', 'uses' => 'ArticulosController@activar']);

Route::post('/articulos/edit', 					['as' => 'edit', 'uses' => 'ArticulosController@edit']);

Route::post('/movimientos/addsalida', 			['as' => 'addsalida', 'uses' => 'MovimientosController@store']);






//para el usuario


Route::get('/usuario',							['as' => 'autorizaciones', 'uses' => 'AutorizacionesController@index']);
Route::post('/usuario/autorizar', 				['as' => 'autorizar', 'uses' => 'AutorizacionesController@store']);


//RESPUESTAS AJAX JSON/ARRAY

Route::get('/ajax/rubros', ['uses' => 'AjaxController@getRubros']);

Route::get('/ajax/subrubros', ['uses' => 'AjaxController@getSubrubros']);

Route::get('/ajax/subrubros/{id}', ['uses' => 'AjaxController@getSubrubrosxid_rubro']);

Route::get('/ajax/empleados', ['uses' => 'AjaxController@getEmpleados']);

Route::get('/ajax/subareas', ['uses' => 'AjaxController@getSubareas']);

Route::get('/ajax/subareas/{id}', ['uses' => 'AjaxController@getSubareasxid_area']);

Route::get('/ajax/articulos', ['uses' => 'AjaxController@getArticulos']);

//RUTAS DATATABLES

Route::get('/datatables/autorizar', ['uses' => 'DatatablesController@autorizacionestabla']);

Route::get('/datatables/autorizar-detalles/{id}', ['uses' =>'DatatablesController@autorizacionesdetallestabla']);

Route::get('/datatables/salidas', ['uses' =>'DatatablesController@salidastable']);

Route::get('/datatables/salidas-detalles/{id}', ['uses' =>'DatatablesController@salidasdetallestabla']);

Route::get('/datatables/articulos', ['uses' => 'DatatablesController@articulostable']);

Route::get('/datatables/autorizaciones', ['uses' => 'DatatablesController@autorizacionesadmin']);

Route::get('/datatables/autorizaciones-detalles/{id}', ['uses' =>'DatatablesController@autorizacionesdetallesadmin']);

