<?php

//HOME

Route::get('/', function () {
    return view('auth.login');
});

//GESTIONAR AUTORIZACIONES

Route::get('/autorizaciones', ['uses' => 'AutorizacionesController@index']);

//GESTIONAR STOCK

Route::get('/egresos', ['uses' => 'MovimientosController@indexegresos']);

Route::get('/ingresos', ['uses' => 'MovimientosController@indexingresos']);

Route::post('/movimientos/addsalida', ['as' => 'addsalida', 'uses' => 'MovimientosController@storeegreso']);

Route::post('/movimientos/addingreso', ['as' => 'addingreso', 'uses' => 'MovimientosController@storeingreso']);


//CONFIGURACIONES - ARTICULOS

Route::get('/articulos', ['uses' => 'ArticulosController@index']);

Route::post('/articulos/addarticulo', ['as' => 'addarticulos','uses' => 'ArticulosController@store']);

Route::post('/articulos/dardebaja', ['as' => 'dardebaja', 'uses' => 'ArticulosController@baja']);

Route::post('/articulos/activar', ['as' => 'activar', 'uses' => 'ArticulosController@activar']);

Route::post('/articulos/editar', ['uses' => 'ArticulosController@edit']);

//CONFIGURACIONES - PROVEEDORES

Route::get('/proveedores', ['uses' => 'ProveedoresController@index']);

Route::post('/proveedores/addproveedor', ['as' => 'addproveedor','uses' => 'ProveedoresController@store']);

Route::post('/proveedores/dardebaja', ['as' => 'dardebajaproveedor', 'uses' => 'ProveedoresController@baja']);

Route::post('/proveedores/activar', ['as' => 'activarproveedor', 'uses' => 'ProveedoresController@activar']);

Route::post('/proveedores/edit', ['as' => 'editproveedor', 'uses' => 'ProveedoresController@edit']);

//PARA EL USUARIO NORMAL

Route::group(['middleware' => ['role:developers|areas']], function() {

	Route::get('/areas/autorizaciones', ['uses' => 'AutorizacionesController@indexUsuario']);
	Route::post('/areas/autorizaciones/nueva', ['as' => 'autorizar', 'uses' => 'AutorizacionesController@store']);

});

//RESPUESTAS AJAX JSON/ARRAY

Route::get('/ajax/rubros', ['uses' => 'AjaxController@getRubros']);

Route::get('/ajax/rubros2', ['uses' => 'AjaxController@getRubros2']);

Route::get('/ajax/subrubros', ['uses' => 'AjaxController@getSubrubros']);

Route::get('/ajax/subrubros/{id}', ['uses' => 'AjaxController@getSubrubrosxid_rubro']);

Route::get('/ajax/empleados', ['uses' => 'AjaxController@getEmpleados']);

Route::get('/ajax/subareas', ['uses' => 'AjaxController@getSubareas']);

Route::get('/ajax/articulos', ['uses' => 'AjaxController@getArticulos']);

Route::get('/ajax/proveedores', ['uses' => 'AjaxController@getProveedores']);

Route::get('/ajax/ingresostabledetails/{id}', ['uses' => 'AjaxController@getDetallesIngresos']);

Route::get('/ajax/salidastabledetails/{id}', ['uses' => 'AjaxController@getDetallesSalidas']);

Route::get('/ajax/autorizacionestabledetails/{id}', ['uses' => 'AjaxController@getDetallesAutorizaciones']);

//RUTAS DATATABLES

Route::get('/datatables/autorizar', ['uses' => 'DatatablesController@autorizacionestabla']);

Route::get('/datatables/autorizar-detalles/{id}', ['uses' => 'DatatablesController@autorizacionesdetallestabla']);

Route::get('/datatables/ingresos', ['uses' =>'DatatablesController@ingresostable']);

Route::get('/datatables/salidas', ['uses' =>'DatatablesController@salidastable']);

Route::get('/datatables/articulos', ['uses' => 'DatatablesController@articulostable']);

Route::get('/datatables/proveedores', ['uses' => 'DatatablesController@proveedorestable']);

Route::get('/datatables/autorizaciones', ['uses' => 'DatatablesController@autorizacionesadmin']);

/*Route::get('/datatables/autorizaciones-detalles-modal/{id}', ['uses' => 'DatatablesController@autorizaciondetallesmodal']); SE SIGUE USANDO ???? */

