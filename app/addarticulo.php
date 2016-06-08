<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class addarticulo extends Model
{
    protected $table = 'articulos';
 
        //Definimos los campos que se pueden llenar con asignación masiva
        protected $fillable = ['descripcion', 'unidad', 'usuario', 'id_rubro','id_subrubro'];
}
