<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Destinos extends Model
{
	protected $table = 'destinos';
	protected $primaryKey = 'id_destino';
    //Definimos los campos que se pueden llenar con asignación masiva
    protected $fillable = ['descripcion_destino'];

    public function subdestinos()
    {
    	return $this->hasMany('App\SubDestinos');

    }
}
