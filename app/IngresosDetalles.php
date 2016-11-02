<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IngresosDetalles extends Model
{
 	protected $table = 'ingresos_detalles';
	protected $primaryKey = 'id_detalles';
    //Definimos los campos que se pueden llenar con asignación masiva
    protected $fillable = ['id_master','id_articulo','cantidad', 'precio_unitario'];
    public $timestamps = false;
    
    
    public function master()
    {
    	return $this->belongsTo('App\IngresosMaster');
    }
}
