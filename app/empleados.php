<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class empleados extends Model
{
    protected $table = 'empleados';
	protected $primaryKey = 'id_empleado';
    //Definimos los campos que se pueden llenar con asignación masiva
    protected $fillable = ['nombre', 'apellido', 'area', 'responsable','responsable_area', 'dni', 'legajo'];
}
