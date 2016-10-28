<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleados extends Model
{
	protected $connection = 'personal';
    protected $table = 'tpersonal';
	protected $primaryKey = 'Nro_Legajo';
}
