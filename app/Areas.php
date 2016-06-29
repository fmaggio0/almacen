<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Areas extends Model
{
	protected $table = 'areas';
	protected $primaryKey = 'id_area';
    //Definimos los campos que se pueden llenar con asignación masiva
    protected $fillable = ['descripcion_area'];

    public function subdestinos()
    {
    	return $this->hasMany('App\SubAreas');

    }
}
