<?php

//HOME

Route::get('/', function () {
    return view('auth.login');
});


//PARA LAS AREAS

Route::group(['middleware' => ['role:developers|compras']], function() {

	//GESTIONAR AUTORIZACIONES
	Route::get('/autorizaciones', 					['uses' => 'AutorizacionesController@index']);
	Route::get('/autorizaciones/{id}', 				['uses' => 'AutorizacionesController@getEdit']);
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
	Route::get('/articulos/nuevo', 					['uses' => 'ArticulosController@indexNuevo']);
	Route::post('/articulos/addarticulo', 			['uses' => 'ArticulosController@store']);
	Route::post('/articulos/dardebaja', 			['uses' => 'ArticulosController@baja']);
	Route::post('/articulos/activar', 				['uses' => 'ArticulosController@activar']);
	Route::get('/articulos/editar/{id}', 			['uses' => 'ArticulosController@indexEdit']);
	Route::post('/articulos/editar/post', 			['uses' => 'ArticulosController@edit']);

	//CONFIGURACIONES - PROVEEDORES
	Route::get('/proveedores', 						['uses' => 'ProveedoresController@index']);
	Route::get('/proveedores/nuevo', 				['uses' => 'ProveedoresController@indexNuevo']);
	Route::post('/proveedores/addproveedor', 		['uses' => 'ProveedoresController@store']);
	Route::post('/proveedores/dardebaja', 			['uses' => 'ProveedoresController@baja']);
	Route::post('/proveedores/activar', 			['uses' => 'ProveedoresController@activar']);
	Route::get('/proveedores/editar/{id}', 			['uses' => 'ProveedoresController@indexEdit']);
	Route::post('/proveedores/editar/post', 		['uses' => 'ProveedoresController@edit']);

	//INFORMES/REPORTES
	Route::get('/informes/empleados', 				['uses' => 'InformesController@index']);
	Route::get('/informes/empleados/{id}', 			['uses' => 'InformesController@IndexEmpleado']);

	Route::get('/informes/stock', 					['uses' => 'InformesController@indexStock']);

});

//PARA LAS AREAS

Route::group(['middleware' => ['role:developers|areas']], function() {

	Route::get('/areas', 						['uses' => 'AreasController@index']);
	Route::get('/areas/autorizaciones', 		['uses' => 'AreasController@IndexAutorizaciones']);
	Route::get('/areas/autorizaciones/nueva', 	['uses' => 'AreasController@NuevaAutorizacion']);
	Route::post('/areas/autorizaciones/store', 	['uses' => 'AutorizacionesController@store']);

	Route::get('/areas/indumentaria', 				['uses' => 'AreasController@indexIndumentaria']);
	Route::get('/areas/indumentaria/{id}', 			['uses' => 'AreasController@modificarIndumentaria']);
	Route::post('/areas/indumentaria/modificar', 	['uses' => 'AreasController@modificarIndumentariaPost']);

});

//PARA EL CENTRO INFORMATICO LOCAL

Route::group(['middleware' => ['role:developers|cil']], function() {

	Route::get('/cil', 									['uses' => 'CilController@Index']);
	Route::get('/cil/usuarios', 						['uses' => 'CilController@Usuarios']);
	Route::get('/cil/usuarios/nuevo', 					['uses' => 'CilController@UsuariosNuevo']);
	Route::get('/cil/usuarios/modificar/{id}', 			['uses' => 'CilController@UsuariosModificar']);
	Route::post('/cil/usuarios/update', 				['uses' => 'CilController@UsuariosUpdate']);
	Route::post('/cil/usuarios/nuevo/post', 			['uses' => 'CilController@UsuariosNuevoPost']);
	Route::get('/cil/roles', 							['uses' => 'CilController@RolesIndex']);
	Route::get('/cil/roles/nuevo', 						['uses' => 'CilController@RolesNuevo']);
	Route::get('/cil/permisos/nuevo', 					['uses' => 'CilController@PermisosNuevo']);
	Route::get('/cil/roles/update/{id}', 				['uses' => 'CilController@RolesUpdate']);
	Route::get('/cil/permisos/update/{id}', 			['uses' => 'CilController@PermisosUpdate']);
	Route::post('/cil/roles/nuevo/post', 				['uses' => 'CilController@RolesNuevoPost']);
	Route::post('/cil/permisos/nuevo/post', 			['uses' => 'CilController@PermisosNuevoPost']);
	Route::post('/cil/roles/update/post', 				['uses' => 'CilController@RolesUpdatePost']);
	Route::post('/cil/permisos/update/post', 			['uses' => 'CilController@PermisosUpdatePost']);

});

//RESPUESTAS AJAX JSON/ARRAY

Route::get('/ajax/rubros', 								['uses' => 'AjaxController@getRubros']);
Route::get('/ajax/rubros2', 							['uses' => 'AjaxController@getRubros2']);
Route::get('/ajax/subrubros', 							['uses' => 'AjaxController@getSubrubros']);
Route::get('/ajax/subrubros/{id}', 						['uses' => 'AjaxController@getSubrubrosxid_rubro']);
Route::get('/ajax/empleados', 							['uses' => 'AjaxController@getEmpleados']);
Route::get('/ajax/subareas/', 							['uses' => 'AjaxController@getSubareas']);
Route::get('/ajax/subareas/{id}/', 						['uses' => 'AjaxController@getSubareasxID']);
Route::get('/ajax/articulos', 							['uses' => 'AjaxController@getArticulos']);
Route::get('/ajax/roles', 								['uses' => 'AjaxController@getRoles']);
Route::get('/ajax/permisos', 							['uses' => 'AjaxController@getPermisos']);
Route::get('/ajax/permisos/{id}', 						['uses' => 'AjaxController@getPermisosxID']);
Route::get('/ajax/ultimoretiroporempleado/{id_articulo}/{id_empleado}', 	['uses' => 'AjaxController@getUltimoRetiroPorEmpleado']);
Route::get('/ajax/proveedores', 						['uses' => 'AjaxController@getProveedores']);	
Route::get('/ajax/ingresostabledetails/{id}', 			['uses' => 'AjaxController@getDetallesIngresos']);
Route::get('/ajax/salidastabledetails/{id}', 			['uses' => 'AjaxController@getDetallesSalidas']);
Route::get('/ajax/autorizacionestabledetails/{id}', 	['uses' => 'AjaxController@getDetallesAutorizaciones']);
Route::get('/ajax/autorizaciones-detalles-modal/{id}', 	['uses' => 'AjaxController@getDetallesAutorizaciones']);

//RUTAS DATATABLES	

Route::get('/datatables/autorizar', 					['uses' => 'DatatablesController@autorizacionestabla']);
Route::get('/datatables/autorizar-detalles/{id}', 		['uses' => 'DatatablesController@autorizacionesdetallestabla']);
Route::get('/datatables/ingresos', 						['uses' => 'DatatablesController@ingresostable']);
Route::get('/datatables/salidas', 						['uses' => 'DatatablesController@salidastable']);
Route::get('/datatables/articulos', 					['uses' => 'DatatablesController@articulostable']);
Route::get('/datatables/proveedores', 					['uses' => 'DatatablesController@proveedorestable']);
Route::get('/datatables/autorizaciones', 				['uses' => 'DatatablesController@autorizacionesadmin']);
Route::get('/datatables/salidas-modal-edit/{id}',		['uses' => 'DatatablesController@salidasmodaledit']);
Route::get('/datatables/usuarios',						['uses' => 'DatatablesController@Usuarios']);
Route::get('/datatables/roles',							['uses' => 'DatatablesController@Roles']);
Route::get('/datatables/empleado/{id}', 				['uses' => 'DatatablesController@Empleado']);
Route::get('/datatables/indumentaria', 					['uses' => 'DatatablesController@Indumentaria']);