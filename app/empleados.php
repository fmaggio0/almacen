<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleados extends Model
{
    protected $table = 'empleados';
	protected $primaryKey = 'id_empleado';
	public $incrementing = false;
    //Definimos los campos que se pueden llenar con asignación masiva
    protected $fillable = ['nombres','apellidos', 'id_area', 'id_subarea', 'funcion', 'talle_remera', 'talle_camisa', 'talle_calzado', 'estado'];
}
