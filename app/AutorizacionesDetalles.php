<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AutorizacionesDetalles extends Model
{
	protected $table = 'autorizaciones_detalles';
	protected $primaryKey = 'id_detalles';
    //Definimos los campos que se pueden llenar con asignación masiva
    protected $fillable = ['id_master','id_articulo','id_empleado', 'cantidad', 'estado'];
    public $timestamps = false;

    public function master()
    {
    	return $this->belongsTo('App\AutorizacionesMaster');
    }
}
