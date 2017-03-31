<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Autorizaciones extends Model
{
	protected $table = 'autorizaciones_master';
	protected $primaryKey = 'id_master';
    //Definimos los campos que se pueden llenar con asignación masiva
    protected $fillable = ['tipo_retiro','id_subarea', 'estado', 'usuario'];

    public function detalles()
    {
    	return $this->hasMany('App\AutorizacionesDetalles');

    }
}
