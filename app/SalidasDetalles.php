<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalidasDetalles extends Model
{
	protected $table = 'salidas_detalles';
	protected $primaryKey = 'id_detalles';
    //Definimos los campos que se pueden llenar con asignación masiva
    protected $fillable = ['id_master','id_articulo','id_empleado', 'cantidad'];

    public function master()
    {
    	return $this->belongsTo('App\SalidasMaster');
    }
}
