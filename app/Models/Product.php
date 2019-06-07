<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
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
    public static function getProducts(?int $id=null)
    {
        if($id){
            $product=self::withTrashed()->with('user')->where("id",$id)->first();
            if($product){
                if(!auth()->user()->can('pass', $product)){
                    abort(403);
                }
                return $product;
            }
            return false;
        }
        if(auth()->user()->hasRole('Super Administrator')){
            return self::withTrashed()->with('user')->get();
        }
        else{
            return self::where("user_id",auth()->user()->id)->withTrashed()->with('user')->get();
        }
    }    
    public static function storageProducts($request)
    {
        if(!$request->id){
            if (\Gate::denies('product')) {
                abort(403);
            }            
            try {
                self::create($request->all());
            } catch (\Illuminate\Database\QueryException $exception) {
                return 3;  
            }
            return 1;  
        }
        else{
            try {
                $product  = self::findOrFail($request->id);
                if(!auth()->user()->can('pass', $product)){
                    abort(403);
                }                
                $input = $request->all();
                $product->fill($input)->save();
            } catch (\Illuminate\Database\QueryException $exception) {
                return 4;
            }
            catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
                return 5;
            }                                    
            return 2;  
        }        
    }    
    public static function removeProduct($request)
    {
        try {
            $product  = self::findOrFail($request->id);
            if(!auth()->user()->can('pass', $product)){
                if(!$request->ajax()){
                    abort(403); 
                }
                return false;
            }                
            $product->delete();
        } catch (\Illuminate\Database\QueryException $exception) {
            return false;
        }catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return false;
        }                        
        return true;  
    }    
    public static function restoreProduct($id)
    {
        try {
            $product  = self::onlyTrashed()->findOrFail($id);
            if(!auth()->user()->can('pass', $product)){
                abort(403); 
            }
            $product->restore();
        } catch (\Illuminate\Database\QueryException $exception) {
            return false;
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return false;
        }                        
        return true;  
    }    
}
