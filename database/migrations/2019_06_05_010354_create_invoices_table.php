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
            $table->float("price",10,2)->nullable(false)->comment("Maximo 10 digitos don decimas de precision.");
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
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('invoice_order_product');
    }
}
