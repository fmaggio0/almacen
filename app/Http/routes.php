<?php

//HOME

Route::get('/', function () {
    return view('auth.login');
});

//ALMACEN

Route::get('/autorizaciones', ['uses' => 'AutorizacionesController@index']);

Route::get('/salidas', ['uses' => 'MovimientosController@index']);

Route::get('/articulos', ['uses' => 'ArticulosController@index']);

Route::post('/articulos/addarticulo', ['as' => 'addarticulos','uses' => 'ArticulosController@store']);

Route::post('/articulos/dardebaja', ['as' => 'dardebaja', 'uses' => 'ArticulosController@baja']);

Route::post('/articulos/activar', ['as' => 'activar', 'uses' => 'ArticulosController@activar']);

Route::post('/articulos/edit', ['as' => 'edit', 'uses' => 'ArticulosController@edit']);

Route::post('/movimientos/addsalida', ['as' => 'addsalida', 'uses' => 'MovimientosController@store']);

//PARA EL USUARIO NORMAL

Route::get('/usuario', ['uses' => 'AutorizacionesController@indexUsuario']);

Route::post('/usuario/autorizar', ['as' => 'autorizar', 'uses' => 'AutorizacionesController@store']);

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

Route::get('/datatables/autorizar-detalles/{id}', ['uses' => 'DatatablesController@autorizacionesdetallestabla']);

Route::get('/datatables/salidas', ['uses' =>'DatatablesController@salidastable']);

Route::get('/datatables/salidas-detalles/{id}', ['uses' => 'DatatablesController@salidasdetallestabla']);

Route::get('/datatables/articulos', ['uses' => 'DatatablesController@articulostable']);

Route::get('/datatables/autorizaciones', ['uses' => 'DatatablesController@autorizacionesadmin']);

Route::get('/datatables/autorizaciones-detalles/{id}', ['uses' =>'DatatablesController@autorizacionesdetallesadmin']);

Route::get('/datatables/autorizaciones-detalles-modal/{id}', ['uses' => 'DatatablesController@autorizaciondetallesmodal']);

