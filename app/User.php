<?php
namespace App;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\UserInfo;
use Zizaco\Entrust\HasRole;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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

    public function UserInfo()
    {
        return $this->hasOne('App\UserInfo', 'id_user');
    }
}
