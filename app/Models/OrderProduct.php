<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderProduct extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];    
    protected $guarded = ['id'];
    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }    
    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }    
    public function invoices()
    {
        return $this->belongsToMany('App\Models\Invoice')->withTimestamps()->withPivot('quantity', 'price','total');
    }    
}
