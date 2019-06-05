<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id',true);
            $table->unsignedInteger('user_id')->comment("Es el proveedor dueño de este producto.");
            $table->string('name')->nullable(false);
            $table->timestamps();
            $table->softDeletes();
            $table->index('user_id');
            $table->foreign('user_id')
            ->references('id')->on('users')
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
        Schema::dropIfExists('products');
    }
}
