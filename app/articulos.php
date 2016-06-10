<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class articulos extends Model
{
	protected $table = 'articulos';
	protected $primaryKey = 'id_articulo';
    //Definimos los campos que se pueden llenar con asignación masiva
    protected $fillable = ['descripcion', 'unidad', 'usuario', 'id_rubro','id_subrubro', 'estado'];
}
