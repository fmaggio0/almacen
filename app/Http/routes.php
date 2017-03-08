<?php

//HOME

Route::get('/', function () {
    return view('auth.login');
});

//GESTIONAR AUTORIZACIONES

Route::get('/autorizaciones', 					['uses' => 'AutorizacionesController@index']);

Route::post('/autorizaciones/post', 			['uses' => 'AutorizacionesController@storeadmin']);

//GESTIONAR STOCK

Route::get('/egresos', 							['uses' => 'MovimientosController@indexegresos']);

Route::get('/egresos/nuevo', 					['uses' => 'MovimientosController@IndexEgresosNuevo']);

Route::get('/egresos/modificar/{id}', 			['uses' => 'MovimientosController@indexmodificaregresos']);

Route::get('/ingresos', 						['uses' => 'MovimientosController@Ingresos']);

Route::get('/ingresos/nuevo', 					['uses' => 'MovimientosController@NuevoIngreso']);

Route::post('/movimientos/addsalida', 			['as' => 'addsalida', 'uses' => 'MovimientosController@storeegreso']);

Route::post('/movimientos/addingreso', 			['as' => 'addingreso', 'uses' => 'MovimientosController@storeingreso']);

Route::post('/egresos/modificar-egreso', 		['uses' => 'MovimientosController@ModificarEgreso']);

//CONFIGURACIONES - ARTICULOS

Route::get('/articulos', 						['uses' => 'ArticulosController@index']);

Route::post('/articulos/addarticulo', 			['as' => 'addarticulos','uses' => 'ArticulosController@store']);

Route::post('/articulos/dardebaja', 			['as' => 'dardebaja', 'uses' => 'ArticulosController@baja']);

Route::post('/articulos/activar', 				['as' => 'activar', 'uses' => 'ArticulosController@activar']);

Route::post('/articulos/editar', 				['uses' => 'ArticulosController@edit']);

//CONFIGURACIONES - PROVEEDORES

Route::get('/proveedores', 						['uses' => 'ProveedoresController@index']);

Route::post('/proveedores/addproveedor', 		['as' => 'addproveedor','uses' => 'ProveedoresController@store']);

Route::post('/proveedores/dardebaja', 			['as' => 'dardebajaproveedor', 'uses' => 'ProveedoresController@baja']);

Route::post('/proveedores/activar', 			['as' => 'activarproveedor', 'uses' => 'ProveedoresController@activar']);

Route::post('/proveedores/edit', 				['as' => 'editproveedor', 'uses' => 'ProveedoresController@edit']);

//PARA LAS AREAS

Route::group(['middleware' => ['role:developers|areas']], function() {

	Route::get('/areas', 						['uses' => 'AreasController@index']);
	Route::get('/areas/autorizaciones', 		['uses' => 'AreasController@IndexAutorizaciones']);
	Route::get('/areas/autorizaciones/nueva', 	['uses' => 'AreasController@NuevaAutorizacion']);
	Route::post('/areas/autorizaciones/store', 	['uses' => 'AutorizacionesController@store']);

});

//PARA EL CENTRO INFORMATICO LOCAL

Route::group(['middleware' => ['role:developers|cil']], function() {

	Route::get('/cil', 									['uses' => 'CilController@Index']);
	Route::get('/cil/usuarios', 						['uses' => 'CilController@Usuarios']);
	Route::get('/cil/usuarios/modificar/{id}', 		['uses' => 'CilController@UsuariosModificar']);

});

//RESPUESTAS AJAX JSON/ARRAY

Route::get('/ajax/rubros', 								['uses' => 'AjaxController@getRubros']);

Route::get('/ajax/rubros2', 							['uses' => 'AjaxController@getRubros2']);

Route::get('/ajax/subrubros', 							['uses' => 'AjaxController@getSubrubros']);

Route::get('/ajax/subrubros/{id}', 						['uses' => 'AjaxController@getSubrubrosxid_rubro']);

Route::get('/ajax/empleados', 							['uses' => 'AjaxController@getEmpleados']);

Route::get('/ajax/subareas', 							['uses' => 'AjaxController@getSubareas']);

Route::get('/ajax/articulos', 							['uses' => 'AjaxController@getArticulos']);

Route::get('/ajax/roles', 								['uses' => 'AjaxController@getRoles']);

Route::get('/ajax/ultimoretiroporempleado/{id_articulo}/{id_empleado}', 	['uses' => 'AjaxController@getUltimoRetiroPorEmpleado']);

Route::get('/ajax/proveedores', 						['uses' => 'AjaxController@getProveedores']);
		
Route::get('/ajax/ingresostabledetails/{id}', 			['uses' => 'AjaxController@getDetallesIngresos']);

Route::get('/ajax/salidastabledetails/{id}', 			['uses' => 'AjaxController@getDetallesSalidas']);

Route::get('/ajax/autorizacionestabledetails/{id}', 	['uses' => 'AjaxController@getDetallesAutorizaciones']);

Route::get('/ajax/autorizaciones-detalles-modal/{id}', 	['uses' => 'AjaxController@getDetallesAutorizaciones']);

//RUTAS DATATABLES	

Route::get('/datatables/autorizar', 					['uses' => 'DatatablesController@autorizacionestabla']);

Route::get('/datatables/autorizar-detalles/{id}', 		['uses' => 'DatatablesController@autorizacionesdetallestabla']);

Route::get('/datatables/ingresos', 						['uses' =>'DatatablesController@ingresostable']);

Route::get('/datatables/salidas', 						['uses' =>'DatatablesController@salidastable']);

Route::get('/datatables/articulos', 					['uses' => 'DatatablesController@articulostable']);

Route::get('/datatables/proveedores', 					['uses' => 'DatatablesController@proveedorestable']);

Route::get('/datatables/autorizaciones', 				['uses' => 'DatatablesController@autorizacionesadmin']);

Route::get('/datatables/salidas-modal-edit/{id}',		['uses' => 'DatatablesController@salidasmodaledit']);

Route::get('/datatables/usuarios',						['uses' => 'DatatablesController@Usuarios']);