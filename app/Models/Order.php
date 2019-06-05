<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];    
    protected $guarded = ['id'];
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function order_products()
    {
        return $this->hasMany('App\Models\OrderProduct');
    }        
}
