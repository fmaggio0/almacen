<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IngresosMaster extends Model
{
    protected $table = 'ingresos_master';
	protected $primaryKey = 'id_master';
    //Definimos los campos que se pueden llenar con asignación masiva
    protected $fillable = ['tipo_ingreso','tipo_comprobante','nro_comprobante', 'descripcion', 'total_factura', 'estado', 'id_proveedor', 'id_usuario'];

    public function detalles()
    {
    	return $this->hasMany('App\IngresosDetalles');

    }
}
