<?php

namespace App;
 
use Zizaco\Entrust\EntrustRole;
 
class Role extends EntrustRole {
  protected $table = 'roles';
	protected $fillable = [
        'name',
        'display_name',
        'description'
    ];
    
   //establecemos las relacion de muchos a muchos con el modelo User, ya que un rol 
   //lo pueden tener varios usuarios y un usuario puede tener varios roles
   public function users(){
        return $this->belongsToMany('App\User');
    }

    public function permisos(){
        return $this->belongsToMany('App\Permission');
    }
}