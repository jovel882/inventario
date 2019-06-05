<?php

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Product::class,10)->create([
            'user_id' => 3,
        ]);        
        factory(Product::class,10)->create([
            'user_id' => 4,
        ]);        
    }
}
