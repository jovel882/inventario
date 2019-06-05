<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->comment("Es el cliente dueño de esta factura.");
            $table->decimal("total",20,2)->nullable(false)->comment("Maximo 17 digitos con 2 decimas de precision.")->default(0);
            $table->date("date")->nullable(false);
            $table->timestamps();
            $table->softDeletes();
            $table->index('user_id');
            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onUpdate('cascade')            
            ->onDelete('cascade');            
        });
        Schema::create('invoice_order_product', function (Blueprint $table) {
            $table->unsignedInteger('invoice_id')->nullable(false);
            $table->unsignedInteger('order_product_id')->nullable(false);
            $table->unsignedSmallInteger("quantity")->comment("Maximo 32767")->nullable(false);
            $table->decimal("price",13,2)->nullable(false)->comment("Maximo 10 digitos con 2 decimas de precision.");
            $table->decimal("total",20,2)->nullable(false)->comment("Maximo 17 digitos con 2 decimas de precision.")->default(0);
            $table->timestamps();
            $table->primary(['invoice_id', 'order_product_id']);
            $table->index('invoice_id');
            $table->index('order_product_id');
            $table->foreign('invoice_id')
                  ->references('id')->on('invoices')
                  ->onUpdate('cascade')            
                  ->onDelete('cascade');            
            $table->foreign('order_product_id')
                  ->references('id')->on('order_products')
                  ->onUpdate('cascade')            
                  ->onDelete('cascade');
        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("SET FOREIGN_KEY_CHECKS=0");
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('invoice_order_product');
        DB::statement("SET FOREIGN_KEY_CHECKS=1");
    }
}
