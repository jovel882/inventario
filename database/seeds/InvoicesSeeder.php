<?php

use Illuminate\Database\Seeder;
use App\Models\Invoice;
use App\Models\Order;

class InvoicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Invoice::class,10)->create([
            'user_id' => 5,
        ]);        
        factory(Invoice::class,10)->create([
            'user_id' => 6,
        ]);
        $this->attach_order_products(3,5);
        $this->attach_order_products(4,6);
    }
    /**
     * Carga la relacion de productos del proveedor especificado a las facturas de cliente especificado.
     * @param int $id_provider Id del proveedor.
     * @param int $id_client Id del cliente.
     * @return void.
     */    
    public function attach_order_products(int $id_provider,int $id_client) :void {
        $invoices=Invoice::where("user_id",$id_client)->get();
        $orders=Order::with('order_products')->where("user_id",$id_provider)->get();        
        $attach_array=array();
        $quantity_invoice=0;
        $total=0;
        foreach($orders as $order){
            if($quantity_invoice<$invoices->count()){
                foreach($order->order_products as $order_product){
                    $quantity=rand(1,$order_product->quantity);
                    $total+=$total_tmp=$order_product->price*$quantity;
                    $attach_array[$order_product->id]=array("quantity"=>$quantity,"price"=>$order_product->price,"total"=>$total_tmp);
                    $order_product->quantity_available-=$quantity;
                    $order_product->save();
                }
            }
            else{
                break;
            }
            $invoices[$quantity_invoice]->order_products()->attach($attach_array);
            $invoices[$quantity_invoice]->total=$total;
            $invoices[$quantity_invoice]->save();
            $quantity_invoice++;
            $attach_array=array();
            $total=0;
        }
    }
}
