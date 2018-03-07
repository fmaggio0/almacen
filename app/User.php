<?php
namespace App;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\UserInfo;
use Zizaco\Entrust\HasRole;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use App\Role;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    use EntrustUserTrait;

    protected $fillable = [
        'name', 'email', 'password', 'id_empleado'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }
    public function empleados()
    {
        return $this->hasOne('App\Empleados', 'id_empleado', 'id_empleado');
    }
}
