<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubAreas extends Model
{
	protected $table = 'subareas';
	protected $primaryKey = 'id_subarea';
    //Definimos los campos que se pueden llenar con asignación masiva
    protected $fillable = ['descripcion_subarea'];

    public function destino()
    {
    	return $this->belongsTo('App\Areas');
    }
}
