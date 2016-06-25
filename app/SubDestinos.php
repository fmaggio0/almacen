<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubDestinos extends Model
{
	protected $table = 'subdestinos';
	protected $primaryKey = 'id_subdestino';
    //Definimos los campos que se pueden llenar con asignación masiva
    protected $fillable = ['descripcion_subdestino'];

    public function destino()
    {
    	return $this->belongsTo('App\Destinos');
    }
}
