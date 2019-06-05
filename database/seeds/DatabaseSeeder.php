<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tableNames = config('permission.table_names');
        $this->truncateTables([
            "invoice_order_product",
            "invoices",
            "order_products",
            "orders",
            "products",
            $tableNames['role_has_permissions'],
            $tableNames['model_has_roles'],
            $tableNames['model_has_permissions'],
            $tableNames['roles'],
            $tableNames['permissions'],
            "users",
        ]);        
        $this->call(PermissionsSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(ProductsSeeder::class);
        $this->call(OrdersSeeder::class);
        $this->call(OrderProductsSeeder::class);
        $this->call(InvoicesSeeder::class);
    }
    /**
     * Trunca todas las tablas enviadas en el array
     * @param array $tables Array con los nombres de las tablas a truncar.
     */
    protected function truncateTables(array $tables):void{
        DB::statement("SET FOREIGN_KEY_CHECKS=0");
        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }
        DB::statement("SET FOREIGN_KEY_CHECKS=1");        
    }        
}
