<?php

use Illuminate\Database\Seeder;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Order;

class OrderProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->attach_order_product(3);
        $this->attach_order_product(4);
    }
    /**
     * Agrega los productos a la orden del proveedor especificado.
     * @param int $id_provider Id del proveedor.
     * @return void.
     */    
    public function attach_order_product(int $id_provider) :void {    
        $products=Product::where("user_id",$id_provider)->get();
        $orders=Order::where("user_id",$id_provider)->get();
        foreach($products as $product){
            foreach($orders as $order){
                factory(OrderProduct::class,1)->create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                ]);
            }
        }
    }
}