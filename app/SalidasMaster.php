<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalidasMaster extends Model
{
	protected $table = 'salidas_master';
	protected $primaryKey = 'id_master';
    //Definimos los campos que se pueden llenar con asignación masiva
    protected $fillable = ['tipo_retiro','id_subarea', 'estado', 'usuario'];

    public function detalles()
    {
    	return $this->hasMany('App\SalidasDetalles');

    }
}
