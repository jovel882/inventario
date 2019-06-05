<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->comment("Es el proveedor dueño de esta orden.");
            $table->date("date")->nullable(false);
            $table->timestamps();
            $table->softDeletes();
            $table->index('user_id');
            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onUpdate('cascade')            
            ->onDelete('cascade');            
        });
        Schema::create('order_products', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_id')->nullable(false);
            $table->unsignedInteger('product_id')->nullable(false);
            $table->unsignedSmallInteger("quantity")->comment("Maximo 32767")->nullable(false);
            $table->unsignedSmallInteger("quantity_available")->comment("Maximo 32767")->nullable(false);
            $table->string('lote')->nullable(false);
            $table->date("expiry_date");
            $table->decimal("price",13,2)->nullable(false)->comment("Maximo 10 digitos don decimas de precision.");
            $table->timestamps();
            $table->softDeletes();
            $table->index('order_id');
            $table->index('product_id');
            $table->foreign('order_id')
                  ->references('id')->on('orders')
                  ->onUpdate('cascade')            
                  ->onDelete('cascade');            
            $table->foreign('product_id')
                  ->references('id')->on('products')
                  ->onUpdate('cascade')            
                  ->onDelete('cascade');
            $table->unique(['order_id', 'product_id']);                        
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
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_products');
        DB::statement("SET FOREIGN_KEY_CHECKS=1");
    }
}
