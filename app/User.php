<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

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
    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }    
    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }    
    public static function getProviders()
    {
        return self::whereHas("roles", function($q){ $q->where("name", "Provider"); })->get();
    }    
}
