<?php

use Illuminate\Database\Seeder;
use App\Models\Order;

class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Order::class,15)->create([
            'user_id' => 3,
        ]);        
        factory(Order::class,15)->create([
            'user_id' => 4,
        ]);        
    }
}
