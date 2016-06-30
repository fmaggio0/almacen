<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class UserInfo extends Model
{
  	protected $table = 'users_info';
  	protected $primaryKey = 'id_user';
    //Definimos los campos que se pueden llenar con asignación masiva
    protected $fillable = ['id_area','id_user'];

    public function User()
    {
    	return $this->belongsTo('App\User');

    }
}
