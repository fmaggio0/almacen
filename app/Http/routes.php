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
    return view('welcome');
});

Route::get('/autorizar', ['as' => 'autorizar', function (){
	 return view('autorizaciones.autorizaciones_retiro');
}]);

Route::get('/autorizar/id', ['as' => 'autorizar_retiro', function (){
	 return view('autorizaciones.autorizar_retiro');
}]);

Route::get('/salidas', ['as' => 'salidas', function (){
	 return view('salidas.salidas');
}]);

Route::get('/movimientos', ['as' => 'movimientos', function (){
	 return view('salidas.movimientos');
}]);

Route::get('/articulos', array('as' => 'articulos', 'uses' => 'ArticulosController@index' ));


Route::get('/articulos/tabla', function(){
	return Datatables::eloquent(App\Articulos::query())->make(true);
});

Route::get('rubros', function (Illuminate\Http\Request  $request) {      
	$rubros=DB::table('rubros')->select('id_rubro AS id', 'descripcion AS text' )->get();
    return Response::json($rubros);
});
Route::get('subrubros/id={id}', function ($id) {    
	$subrubros=DB::table('subrubros')->where('id_rubro', '=', $id )->select('id_subrubro AS id', 'descripcion AS text' )->get();
    return Response::json($subrubros);
});

Route::post('/articulos/addarticulo', ['as' => 'addarticulos', 'uses' => 'ArticulosController@store']);