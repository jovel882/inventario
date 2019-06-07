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
    public static function getOrders(?int $id=null)
    {
        if($id){
            $order=self::withTrashed()->with('user:id,name')->with('order_products.product:id,name')->where("id",$id)->first();
            $productsOrder=json_encode((object)$order->order_products->map(function ($item,$key){
                $item["product_text"]=$item["product"]["name"];
                unset($item["product"]);
                return $item;
            })->toArray());            
            if($order){
                if(!auth()->user()->can('pass', $order)){
                    abort(403);
                }
                return compact("order","productsOrder");
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
    public static function storageOrders($request)
    {
        if(!$request->id){
            if (\Gate::denies('order')) {
                abort(403);
            }            
            try {
                $order=self::create(['user_id' => $request->user_id, 'date' => $request->date]);
                $order->order_products()->createMany(array_map(function($data){
                     unset($data["product_text"]); 
                     $data["quantity_available"]=$data["quantity"];
                     return $data ;
                    }, json_decode($request->data_Product,true))
                );
            } catch (\Illuminate\Database\QueryException $exception) {
                dd($exception);
                return 3;  
            }
            return 1;  
        }
        else{
            try {
                $order  = self::findOrFail($request->id);
                if(!auth()->user()->can('pass', $order)){
                    abort(403);
                }                
                $order->fill(['user_id' => $request->user_id, 'date' => $request->date])->save();
                $orderProducts=$order->order_products;
                
                $request->data_Product=json_decode($request->data_Product);
        
                foreach ($orderProducts as $orderProduct) {
                    $find=false;
                    foreach ($request->data_Product as $key => $product) {
                        if(isset($product->id) && $product->id==$orderProduct->id){
                            $orderProduct->product_id=$product->product_id;
                            $orderProduct->quantity=$product->quantity;
                            $orderProduct->price=$product->price;
                            $orderProduct->expiry_date=$product->expiry_date;
                            $orderProduct->lote=$product->lote;
                            $orderProduct->quantity_available=$product->quantity;
                            $orderProduct->save();
                            unset($request->data_Product->{$key});
                            $find=true;
                            break;
                        }
                    }
                    if($find==false){
                        $orderProduct->forceDelete();
                    }
                }
                foreach ($request->data_Product as $key => $product) {
                    if(strpos($key, "new")!==false){
                        $order->order_products()->create([
                            "product_id" => $product->product_id,
                            "quantity" => $product->quantity,
                            "price" => $product->price,
                            "expiry_date" => $product->expiry_date,
                            "lote" => $product->lote,
                            "quantity_available" => $product->quantity,
                            ]);
                    }
                }                
            } catch (\Illuminate\Database\QueryException $exception) {
                return 4;
            }
            catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
                return 5;
            }                                    
            return 2;  
        }        
    }
    public static function removeOrder($request)
    {
        try {
            $order  = self::findOrFail($request->id);
            if(!auth()->user()->can('pass', $order)){
                if(!$request->ajax()){
                    abort(403); 
                }
                
                return false;
            }                
            $order->delete();
            $order->order_products()->delete();
        } catch (\Illuminate\Database\QueryException $exception) {
            return false;
        }catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return false;
        }                        
        return true;  
    }    
    public static function restoreOrder($id)
    {
        try {
            $order  = self::onlyTrashed()->findOrFail($id);
            if(!auth()->user()->can('pass', $order)){
                abort(403); 
            }
            $order->restore();
            $order->order_products()->restore();
        } catch (\Illuminate\Database\QueryException $exception) {
            return false;
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return false;
        }                        
        return true;  
    }                    
}
